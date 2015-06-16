<?php

class Request_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function add_simplify($murid,$matpel,$lokasi,$preferensi,$catatan){
    	$this->db->query("INSERT INTO request(murid_id,matpel_id,lokasi_id,preferensi,request_catatan)
    						VALUES($murid,$matpel,$lokasi,'$preferensi','$catatan')");

    	$id = $this->db->insert_id();
    	$code = $this->generate_code($id);
    	$this->db->query("UPDATE request SET request_code='$code' WHERE request_id=$id");

    	return $id;
    }
    
    function add($input){
        $this->db->set('murid_id',$input['murid_id']);
        $this->db->set('matpel_id',$input['matpel']);
        $this->db->set('lokasi_id',$input['lokasi']);
        $this->db->set('request_frekuensi',$input['freq']);
        $this->db->set('request_budget',$input['budget']);
	   $this->db->set('referal_code',$input['referal']);
        $this->db->set('request_jadwal',$input['jyt']);
        $this->db->set('request_mulai',$input['jkd']);
        $this->db->set('request_catatan',$input['catatan']);
        $this->db->set('request_gender',$input['gender']);
        $this->db->set('request_status',1,TRUE);
	   $this->db->set('requested_by',$input['requested_by']);
	   $this->db->set('request_get_disc',$input['disc']);
	   $this->db->set('request_metode',$input['metode']);
	   $this->db->set('request_progress',0, TRUE);
	   $this->db->set('request_handle_by',0, TRUE);
	   $this->db->set('request_date',date("Y-m-d H:i:s"));
        $this->db->insert('request');
        $id = $this->db->insert_id();
        $code = $this->generate_code($id);
        foreach($input['guru'] as $g){
            $priority = (!empty($input['prioritas'][$g]))?$input['prioritas'][$g]:0;
            $this->add_guru($id,$g,$priority);
        }
        return $code;
    }
    
    function generate_code($request_id){
        $hash = strtoupper(md5($request_id));
        $code = $request_id.substr($hash, 0, 5).$request_id;
        $this->db->set('request_code',$code);
        $this->db->where('request_id',$request_id);
        $this->db->update('request');
        return $code;
    }
    
    function add_guru($request_id,$guru_id,$priority){
        $this->db->set('request_id',$request_id,TRUE);
        $this->db->set('guru_id',$guru_id,TRUE);
        $this->db->set('request_guru_priority',$priority,TRUE);
        $this->db->set('request_guru_status_id',1,TRUE);
        $this->db->insert('request_guru');
    }
    
    function add_matpel($request_id,$matpel_id){
        $this->db->set('request_id',$request_id,TRUE);
        $this->db->set('matpel_id',$matpel_id,TRUE);
        $this->db->insert('request_matpel');
    }
    
    function find($input){
        $this->db->where('request_email',$input['email']);
        $this->db->where('request_hp',$input['hp']);
        $this->db->where('request_code',$input['code']);
        $result = $this->db->get('request');
        if($result->num_rows() > 0){
            return $result->first_row();
        }else{
            return null;
        }
    }
    
    /*** DELETE REQUEST ***/
    function delete_request($request_id){
        //delete request
	   $q_check = "SELECT * FROM request_guru WHERE request_id = ".$request_id;
	   $check_request = $this->db->query($q_check);
	   $result['count'] = $check_request->num_rows();
	   if($result['count'] > 0){
		$query = "DELETE t1, t2
                    FROM request as t1
                    INNER JOIN request_guru as t2 on t2.request_id = t1.request_id
                   WHERE t1.request_id = ".$request_id;
	  } else {
		$query = "DELETE FROM request WHERE request_id = ".$request_id;
	  }
	  $this->db->query($query);
    }   
    
    /*** GET ***/
    function get_list_request($murid_id){
        $result = array();
        $this->db->join('matpel','request.matpel_id=matpel.matpel_id', 'left outer');
        $this->db->join('jenjang_pendidikan','matpel.jenjang_pendidikan_id=jenjang_pendidikan.jenjang_pendidikan_id', 'left outer');
        $this->db->where('murid_id',$murid_id);
        $this->db->order_by('request.request_id','desc');
        $request = $this->db->get('request');
        $result['count'] = $request->num_rows();
        if($result['count'] > 0){
            $i=0;
            foreach($request->result() as $row){
                $result['data'][$i] =  $row;
                $result['data'][$i]->guru = $this->get_pilihan_guru($result['data'][$i]->request_id);
                $i++;
            }
		  
        }else{
            $result['data'] = $request->result_array();
        }
        return $result;
    }
    
    function get_pilihan_guru($request_id){
        $this->db->where('request_id',$request_id);
        $this->db->join('guru','request_guru.guru_id=guru.guru_id', 'left outer');
        $this->db->join('request_guru_status','request_guru.request_guru_status_id=request_guru_status.request_guru_status_id', 'left outer');
        $this->db->order_by('request_guru.request_guru_priority','asc');
        return $this->db->get('request_guru');
    }
    
    function get_request_by_id($id){
        $this->db->join('matpel','request.matpel_id=matpel.matpel_id', 'left outer');
        $this->db->join('jenjang_pendidikan','matpel.jenjang_pendidikan_id=jenjang_pendidikan.jenjang_pendidikan_id', 'left outer');
        $this->db->join('lokasi','request.lokasi_id=lokasi.lokasi_id', 'left outer');
        //$this->db->join('request_durasi','request.request_durasi=request_durasi.request_durasi_id', 'left outer');
        $this->db->join('murid','request.murid_id=murid.murid_id', 'left outer');
        $this->db->where('request_id',$id);
        return $this->db->get('request')->first_row();
    }
    
    function get_request_by_guru_id($id){
        $this->db->join('request','request.request_id=request_guru.request_id');
        $this->db->join('matpel','request.matpel_id=matpel.matpel_id', 'left outer');
        $this->db->join('jenjang_pendidikan','matpel.jenjang_pendidikan_id=jenjang_pendidikan.jenjang_pendidikan_id', 'left outer');
        //$this->db->join('request_durasi','request.request_durasi=request_durasi.request_durasi_id', 'left outer');
        $this->db->join('request_guru_status','request_guru.request_guru_status_id=request_guru_status.request_guru_status_id', 'left outer');
	   $this->db->order_by('request.request_id','desc');
        $this->db->where('request_guru.guru_id',$id);
        return $this->db->get('request_guru');
    }
    
    function get_request_for_guru_by_id($id,$guru_id){
        $this->db->join('request','request.request_id=request_guru.request_id');
        $this->db->join('matpel','request.matpel_id=matpel.matpel_id', 'left outer');
        $this->db->join('jenjang_pendidikan','matpel.jenjang_pendidikan_id=jenjang_pendidikan.jenjang_pendidikan_id', 'left outer');
        $this->db->join('guru','request_guru.guru_id=guru.guru_id', 'left outer');
        //$this->db->join('request_durasi','request.request_durasi=request_durasi.request_durasi_id', 'left outer');
        $this->db->join('request_guru_status','request_guru.request_guru_status_id=request_guru_status.request_guru_status_id', 'left outer');
        $this->db->order_by('request_guru_priority','asc');
        $this->db->where('request_guru.guru_id',$guru_id);
        $this->db->where('request.request_id',$id);
        return $this->db->get('request_guru')->first_row();
    }
    
    function get_province($lokasi_id){
		$this->db->select('*');
		$this->db->where('lokasi_id',$lokasi_id);
		return $this->db->get('lokasi')->first_row();
    }
    
     function cari_guru($input){
		$this->db->select('*');
		$this->db->where('guru_id',$input['id_guru']);
		return $this->db->get('guru')->first_row();
    }
    /*** UPDATE ***/
    function update_respon_guru($id,$guru_id,$status){
        $this->db->set('request_guru_status_id',$status);
        $this->db->where('request_guru.guru_id',$guru_id);
        $this->db->where('request_guru.request_id',$id);
        $this->db->update('request_guru');
    }
    
      function update_request_pilih_status($id,$status){
		if($status == 1){
			$this->db->set('request_pilih_status',0);
		}else{
			$this->db->set('request_pilih_status',1);
		}
        $this->db->where('request_id',$id);
        $this->db->update('request');
    }
    
    
    /*** ADMIN ***/
    function get_request($page=0){
        $offset = 20;
        $start = $page*$offset;
        $this->db->join('matpel','request.matpel_id=matpel.matpel_id', 'left outer');
        $this->db->join('jenjang_pendidikan','matpel.jenjang_pendidikan_id=jenjang_pendidikan.jenjang_pendidikan_id', 'left outer');
        $this->db->join('murid','request.murid_id=murid.murid_id', 'left outer');
        $this->db->limit($offset,$start);
        $this->db->order_by('request_id','desc');
        return $this->db->get('request');
    }
    
    public function get_request_count(){
        return $this->db->count_all_results('request');
    }
    
      public function get_duta_by_referal_code($referal_code){
        return $this->db->where('duta_guru_id',$referal_code);
    }
    
    function get_request_guru_by_id($id,$guru_id=null){
        $this->db->join('guru','request_guru.guru_id=guru.guru_id', 'left outer');
        $this->db->join('request_guru_status','request_guru.request_guru_status_id=request_guru_status.request_guru_status_id', 'left outer');
        $this->db->order_by('request_guru_priority','asc');
        $this->db->where('request_id',$id);
        return $this->db->get('request_guru');
    }
        
    function convert_jadwal($jadwal_pilihan_murid){
		$jdwl = explode(";",$jadwal_pilihan_murid);
			if(count($jdwl) > 1){	
				for($j=0;$j< (count($jdwl)-1);$j++){
					$pref_jadwal = explode(",", $jdwl[$j]);
					if($j == 0){
						$temp_guru = $pref_jadwal[0];
						$temp_hari = $pref_jadwal[2];
						$hh = sprintf('%d', $pref_jadwal[1]);
						$dd = intval($temp_hari);
						$jam_hari[$dd][] = $hh;
					}else {
						if($pref_jadwal[0] == $temp_guru){
							if($pref_jadwal[2] == $temp_hari){
								$hh = sprintf('%d', $pref_jadwal[1]);
								$dd = intval($temp_hari);
								$jam_hari[$dd][] = $hh;
							}else{
								//$jam_hari = "";
								$temp_hari = $pref_jadwal[2];
								$hh = sprintf('%d', $pref_jadwal[1]);
								$dd = intval($temp_hari);
								$jam_hari[$dd][] = $hh;
							}
						} else {
							$jam_hari = "";
							$hh = sprintf('%d', $pref_jadwal[1]);
							$dd = intval($pref_jadwal[2]);
							$jam_hari[$dd][] = $hh;
							$temp_guru = $pref_jadwal[0];
							$temp_hari = $pref_jadwal[2];
						}
					}
					$jadwal_kursus[$temp_guru] = $jam_hari;
					//print_r($temp_hari);
					//print_r($jam_hari);
				}
				$jadwal_kursus["flag"] = 1;
			} else {
				$jadwal_kursus[] = $jadwal_pilihan_murid;
				$jadwal_kursus["flag"] = 0;
			}
	return $jadwal_kursus;
	}
	
    function convert_jadwal_kursus($jadwal_pilihan_murid){
		$jdwl = explode(";",$jadwal_pilihan_murid);
			if(count($jdwl) > 1){	
				for($j=0;$j< (count($jdwl)-1);$j++){
					$pref_jadwal = explode(",", $jdwl[$j]);
					if($j == 0){
						$temp_hari = $pref_jadwal[1];
						$hh = sprintf('%d', $pref_jadwal[0]);
						$dd = intval($temp_hari);
						$jam_hari[$dd][] = $hh;
					}else {
						if($pref_jadwal[1] == $temp_hari){
							$hh = sprintf('%d', $pref_jadwal[0]);
							$dd = intval($temp_hari);
							$jam_hari[$dd][] = $hh;
						}else{
							//$jam_hari = "";
							$temp_hari = $pref_jadwal[1];
							$hh = sprintf('%d', $pref_jadwal[0]);
							$dd = intval($temp_hari);
							$jam_hari[$dd][] = $hh;
						}
					}
					$jadwal_kursus = $jam_hari;
					//print_r($temp_hari);
					//print_r($jam_hari);
				}
				$jadwal_kursus["flag"] = 1;
			} else {
				$jadwal_kursus[] = $jadwal_pilihan_murid;
				$jadwal_kursus["flag"] = 0;
			}
	return $jadwal_kursus;
	}
	
	function convert_jadwal_kursus_admin($jadwal_pilihan_murid){
		$jdwl = explode(";",$jadwal_pilihan_murid);
			if(count($jdwl) > 1){	
				for($j=0;$j< (count($jdwl)-1);$j++){
					$pref_jadwal = explode(",", $jdwl[$j]);
					if($j == 0){
						$temp_hari = $pref_jadwal[1];
						$hh = sprintf('%d', $pref_jadwal[0]);
						$dd = intval($temp_hari);
						$jam_hari[$dd][$hh] = $dd;
					}else {
						if($pref_jadwal[1] == $temp_hari){
							$hh = sprintf('%d', $pref_jadwal[0]);
							$dd = intval($temp_hari);
							$jam_hari[$dd][$hh] = $dd;
						}else{
							//$jam_hari = "";
							$temp_hari = $pref_jadwal[1];
							$hh = sprintf('%d', $pref_jadwal[0]);
							$dd = intval($temp_hari);
							$jam_hari[$dd][$hh] = $dd;
						}
					}
					$jadwal_kursus = $jam_hari;
					//print_r($temp_hari);
					//print_r($jam_hari);
				}
				$jadwal_kursus["flag"] = 1;
			} else {
				$jadwal_kursus[] = $jadwal_pilihan_murid;
				$jadwal_kursus["flag"] = 0;
			}
	return $jadwal_kursus;
	}
	
	function convert_day($day_id){
		switch ($day_id){
			case 6 :
				$dd = "Minggu";
			break;
			case 0:
				$dd = "Senin";
			break;
			case 1:
				$dd = "Selasa";
			break;
			case 2:
				$dd = "Rabu";
			break;
			case 3:
				$dd = "Kamis";
			break;
			case 4:
				$dd = "Jumat";
			break;
			case 5:
				$dd = "Sabtu";
			break;
		}
		return $dd;
	}
	
	function day_to_hari($day){
		switch ($day){
			case "01":
				$dd = "Minggu";
			break;
			case "Monday":
				$dd = "Senin";
			break;
			case "Tuesday":
				$dd = "Selasa";
			break;
			case "Wednesday":
				$dd = "Rabu";
			break;
			case "Thursday":
				$dd = "Kamis";
			break;
			case "Friday":
				$dd = "Jumat";
			break;
			case "Saturday":
				$dd = "Sabtu";
			break;
		}
		return $dd;
	}
	
	function convert_month($month_id){
		switch ($month_id){
			case "01":
				$mm= "Januari";
			break;
			case "02":
				$mm= "Februari";
			break;
			case "03":
				$mm = "Maret";
			break;
			case "04":
				$mm = "April";
			break;
			case "05":
				$mm = "Mei";
			break;
			case "06":
				$mm = "Juni";
			break;
			case "07":
				$mm= "Juli";
			break;
			case "08":
				$mm= "Agustus";
			break;
			case "09":
				$mm= "September";
			break;
			case "10":
				$mm= "Oktober";
			break;
			case "11":
				$mm= "November";
			break;
			case "12":
				$mm= "Desember";
			break;
		}
		return $mm;
	}
	
	function convert_hour($hours){
		$min_hh = min($hours);
		$max_hh = max($hours);
		$jam_kursus = $min_hh.".00 - ".$max_hh.".00";
		return $jam_kursus;
	}
	
	function update_request($id,$input){
        $this->db->set('matpel_id',$input['matpel']);
        $this->db->set('lokasi_id',$input['lokasi']);
        $this->db->set('request_frekuensi',$input['request_frek']);
        $this->db->set('referal_code',$input['duta_murid']);
        $this->db->set('request_budget',$input['budget']);
        $this->db->set('request_mulai',$input['mulai']);
        $this->db->set('request_gender',$input['gender']);
        $this->db->set('preferensi',$input['preferensi']);
        $this->db->set('request_catatan',$input['catatan']);
        $this->db->set('request_jadwal',$input['jadwal']);
        $this->db->set('request_get_disc',$input['disc']);
        $this->db->where('request_id',$id);
        $this->db->update('request');
    }
    
     function delete_guru_request($request_id, $guru_id){
	  $query = "DELETE FROM request_guru WHERE request_id = ".$request_id." AND guru_id = ".$guru_id;
	  $this->db->query($query);
    }   
    
     function get_by_search($key){
	   $this->db->join('murid','murid.murid_id=request.murid_id', 'left outer');
	   $this->db->join('matpel','matpel.matpel_id=request.matpel_id', 'left outer');
	   $this->db->join('jenjang_pendidikan','jenjang_pendidikan.jenjang_pendidikan_id=matpel.jenjang_pendidikan_id', 'left outer');
	   $this->db->like('murid.murid_nama',$key);
        return $this->db->get('request');
    }

    function count_active(){
    	date_default_timezone_set("Asia/Jakarta");
    	$now = date('Y-m-d H:i:s');
    	$query = $this->db->query("SELECT count(request_id) as new_req
										FROM (SELECT request_id,request_status,request_progress, 
												(ABS(TIMESTAMPDIFF(MINUTE,'$now',request_date))) as diff FROM request) as rq
										WHERE rq.diff<120 AND rq.request_status=1 AND rq.request_progress=0");
    	$result = $query->result_array();
    	return $result[0]['new_req'];
    }

    public function insert_lowongan($request,$title,$keterangan,$lokasi,$matpel,$harga,$type="request"){
    	$this->db->query("INSERT INTO request_guru_home(request_guru_home_title,request_guru_home_text,lokasi_id,matpel_id,harga,request_id,type)
    								VALUES('$title','$keterangan',$lokasi,$matpel,'$harga',$request,'$type')");
    }

    public function is_already_lowongan($request,$tipe="request"){
    	$query = $this->db->query("SELECT * FROM request_guru_home WHERE request_id=$request AND type='$tipe'");
    	$result = $query->result_array();
    	if(sizeof($result)>0){
    		return $result[0];
    	} else {
    		return null;
    	}
    }

    public function add_request_langsung($nama,$telp,$email,$matpel,$lokasi) {
    	$this->db->query("INSERT INTO request_langsung(nama_request,telp_request,email_request,matpel_request,lokasi_request)
    						VALUES('$nama','$telp','$email','$matpel','$lokasi')");

    	return $this->db->insert_id();
    }
}
?>