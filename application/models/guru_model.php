<?php

class Guru_model extends CI_Model {

    private $joinedWithMatpel = 0;

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function get_table($name){
        return $this->db->get($name);
    }
    
     function get_provinsi($name){
	   $this->db->order_by('provinsi_title','asc');
	   return $this->db->get($name);
    }
    
    function get_guru_in_array($array){
        if(empty($array)){
            return null;
        }else{
            $query = "SELECT * FROM guru 
                left outer join pendidikan 
                    on guru.pendidikan_id = pendidikan.pendidikan_id
                left outer join kategori
                    on guru.kategori_id = kategori.kategori_id";
            $count = false;
            foreach($array as $guru_id){
                if(!$count){
                    $query.=" WHERE ";
                    $count=true;
                }else{
                    $query.=" OR ";
                }
                $query.="guru_id={$guru_id}";
            }
            return $this->db->query($query);
        }
    }
    
    function get_guru_by_id($id){
        $this->db->join('bank','bank.bank_id = guru.bank_id','left outer');
        $this->db->join('kategori','kategori.kategori_id = kategori.kategori_id','left outer');
        $this->db->join('pendidikan','pendidikan.pendidikan_id = guru.pendidikan_id','left outer');
        //$this->db->join('source_info','source_info.source_info_id = guru.source_info_id','left outer');
        $this->db->where('guru_id',$id);
        return $this->db->get('guru')->first_row();
    }
    
    function get_guru_by_email($email){
        $this->db->where('guru_email',$email);
        $result = $this->db->get('guru');
        if($result->num_rows() > 0){
            return $result->first_row();
        }else{
            return null;
        }
    }
    
    function get_guru_unggulan(){
        $this->db->join('guru','guru_unggulan.guru_id=guru.guru_id','left outer');
        $this->db->order_by('guru.guru_rating','desc');
        return $this->db->get('guru_unggulan');
    }
    
     function get_guru_unggulan_by_id($id){
        $this->db->join('guru','guru_unggulan.guru_id=guru.guru_id','left outer');
	   $this->db->where('guru_unggulan_id',$id);
        return $this->db->get('guru_unggulan')->first_row();
    }
    
    function get_jenjang(){
        $this->db->order_by('jenjang_pendidikan_index','asc');
        return $this->db->get('jenjang_pendidikan');
    }
    
    function get_matpel($pend_id,$limit=false){
	   $this->db->order_by('matpel_title','asc');
        $this->db->where('jenjang_pendidikan_id',$pend_id);
        if($limit){
            $this->db->limit(12);
        }
        return $this->db->get('matpel');
    }
    
     function get_matpel_by_id($id){
        $this->db->where('matpel_id',$id);
        return $this->db->get('matpel')->first_row();
    }
    
     function get_hargapermatpel($guru_id,$matpel_id){
        $this->db->where('guru_id',$guru_id);
        $this->db->where('matpel_id',$matpel_id);
        return $this->db->get('guru_matpel');
    }
    function get_text_matpel_guru($guru_id){
        $result = "";
        $this->db->where('guru_id',$guru_id,TRUE);
        $this->db->join('matpel','guru_matpel.matpel_id=matpel.matpel_id');
        $rows = $this->db->get('guru_matpel');
        foreach($rows->result() as $row){
            $result .= $row->matpel_title . ", ";
        }
        return substr($result, 0, strlen($result) -2);
    }
    function get_first_guru_lokasi($guru_id){
        $this->db->where('guru_id',$guru_id,TRUE);
        $this->db->join('lokasi','guru_lokasi.lokasi_id=lokasi.lokasi_id');
        $rows = $this->db->get('guru_lokasi');
        if($rows->num_rows() > 0 ){
            return $rows->first_row()->lokasi_title;
        }else{
            return null;
        }
    }
    
    function get_matpel_guru($guru_id){
        $this->db->select('matpel.matpel_id,matpel_title,guru_matpel_tarif,matpel.jenjang_pendidikan_id,jenjang_pendidikan_title');
        $this->db->where('guru_id',$guru_id);
        $this->db->join('matpel','matpel.matpel_id = guru_matpel.matpel_id');
        $this->db->join('jenjang_pendidikan','jenjang_pendidikan.jenjang_pendidikan_id = matpel.jenjang_pendidikan_id');
        $this->db->order_by('matpel.jenjang_pendidikan_id','asc');
        return $this->db->get('guru_matpel');
    }
    
    function get_kategori(){
        return $this->db->get('kategori');
    }
    
    function get_pendidikan(){
	   $this->db->order_by('pendidikan_id','asc');
        return $this->db->get('pendidikan');
    }
    
     /*** PROVINSI ***/
    function get_lokasi_by_provinsi($provinsi_id){
        $this->db->where('provinsi_id',$provinsi_id);
        return $this->db->get('lokasi');
    }
    
     function get_lokasi_by_id($id){
        $this->db->where('lokasi_id',$id);
        return $this->db->get('lokasi')->first_row();
    }
    /*** LOKASI ***/
    function get_lokasi_jkt(){
        $this->db->where('lokasi_id <',10);
        return $this->db->get('lokasi');
    }
    function get_lokasi_lain(){
        $this->db->where('lokasi_id >=',10);
        $this->db->order_by('lokasi_title','asc');
        return $this->db->get('lokasi');
    }
    function get_nama_lokasi($lokasi_id){
        $this->db->where('lokasi_id',$lokasi_id);
        return $this->db->get('lokasi')->first_row()->lokasi_title;
    }
    function get_lokasi_guru($guru_id){
        $this->db->where('guru_id',$guru_id);
        $this->db->join('lokasi','lokasi.lokasi_id = guru_lokasi.lokasi_id');
        return $this->db->get('guru_lokasi');
    }
    
    /*** KELAS ***/
    public function get_next_kelas($id_guru){
        date_default_timezone_set("Asia/Jakarta");
        $now = date('Y-m-d');
        $query = $this->db->query("SELECT k.*,km.*,m.*,md.murid_nama, md.murid_gender FROM kelas as k 
                                    LEFT JOIN kelas_pertemuan as km ON km.kelas_id=k.kelas_id
                                    LEFT JOIN matpel as m ON m.matpel_id=k.matpel_id
                                    LEFT JOIN murid as md ON md.murid_id=k.murid_id
                                    WHERE k.guru_id=$id_guru AND km.kelas_pertemuan_date > '$now'
                                    GROUP BY k.kelas_id
                                    ORDER BY km.kelas_pertemuan_date ASC");

        return $query;
    }

     function get_kelas($guru_id){
        $this->db->where('guru_id',$guru_id);
        return $this->db->get('kelas');
    }
    
     function get_murid($murid_id){
        $this->db->where('murid_id',$murid_id);
        return $this->db->get('murid')->first_row();
	}
    
    /*** JADWAL ***/
    function get_jadwal_guru($guru_id){
        $this->db->where('guru_id',$guru_id);
        $this->db->order_by('guru_jadwal_day,guru_jadwal_hour');
        return $this->db->get('guru_jadwal');
    }
    
    /*** INSERT ***/
    function check_email($email){
        $this->db->where('guru_email',$email);
        $this->db->where('guru_active',1,TRUE);
        $result = $this->db->get('guru');
        if($result->num_rows()>0){
            return true;
        }else{
            return false;
        }
    }

    public function insert_guru_min($input){
        $this->db->set('guru_email',$input['email']);
        $this->db->set('guru_password',md5($input['pass']));
        $this->db->set('guru_nama',$input['nama']);
        $this->db->set('guru_gender',$input['gender']);
        $this->db->set('guru_hp',$input['hp']);
        $this->db->set('guru_alamat',$input['alamat']);
        $this->db->set('guru_rating',$input['guru_rating']);
        $this->db->set('guru_rating_bio',$input['guru_rating_bio']);
        $this->db->set('guru_active',1,TRUE);
        $this->db->set('guru_blocked',0,FALSE);
        $this->db->insert('guru');
        //$this->email_reg($input['email'], $input['nama']);
        return $this->db->insert_id();
    }
    
    function insert_guru($input){
        $this->db->set('guru_email',$input['email']);
        $this->db->set('guru_password',md5($input['pass']));
        $this->db->set('guru_nama',$input['nama']);
        $this->db->set('guru_nik',$input['nik']);
        $this->db->set('pendidikan_id',$input['pendidikan_id']);
        $this->db->set('guru_pendidikan_instansi',$input['pendidikan_instansi']);
        $this->db->set('guru_gender',$input['gender']);
        $this->db->set('guru_tempatlahir',$input['tempatlahir']);
        $this->db->set('guru_lahir',$input['lahir']);
        $this->db->set('guru_hp',$input['hp']);
        $this->db->set('guru_hp_2',$input['hp_2']);
        $this->db->set('guru_telp_rumah',$input['telp_rumah']);
        $this->db->set('guru_telp_kantor',$input['telp_kantor']);
        $this->db->set('guru_alamat',$input['alamat']);
        $this->db->set('guru_alamat_domisili',$input['alamat_domisili']);
        $this->db->set('guru_fb',$input['fb']);
        $this->db->set('guru_twitter',$input['twitter']);
        $this->db->set('guru_referral',$input['referral']);
        $this->db->set('source_info_id',$input['source_info']);
        $this->db->set('guru_metode',$input['metode']);
        $this->db->set('kategori_id',$input['kategori']);
        $this->db->set('guru_last_login',$input['last_login']);
        $this->db->set('guru_daftar',$input['guru_daftar']);
        $this->db->set('guru_rating',$input['guru_rating']);
        $this->db->set('guru_rating_bio',$input['guru_rating_bio']);
        $this->db->set('guru_active',0,FALSE);
        $this->db->set('guru_blocked',0,FALSE);
        $this->db->insert('guru');
        //$this->email_reg($input['email'], $input['nama']);
        return $this->db->insert_id();
    }
    
    function insert_guru_info($guru_id,$tipe,$input){
        switch ($tipe) {
            case 'lokasi':
                foreach($input as $value){
                    $this->db->set('lokasi_id',$value);
                    $this->db->set('guru_id',$guru_id);
                    $this->db->insert('guru_lokasi');
                    $this->db->flush_cache();
                }
                break;
            case 'matpel':
                foreach($input as $value){
                    $this->db->set('matpel_id',$value);
                    $this->db->set('guru_id',$guru_id);
                    $this->db->insert('guru_matpel');
                    $this->db->flush_cache();
                }
                break;
            default:
                break;
        }
    }
    
    /*** DELETE GURU ***/
    function delete_guru($guru_id){
        //get guru
        $guru = $this->get_guru_by_id($guru_id);
        if(empty($guru)){
            return;
        }
        //delete sertifikat
        $this->load->model('profile_model');
        $sertifikat = $this->profile_model->get_sertifikat($guru_id);
        $base_path = $this->config->item('base_url_sertifikat');
        foreach($sertifikat->result() as $row){
            unlink($base_path.$row->guru_sertifikat_file);
        }
        //delete nik
        $base_path = $this->config->item('base_url_nik');
        unlink($base_path.$guru->guru_nik_image);
        //delete pp
        $base_path = $this->config->item('base_url_pp_guru');
        unlink($base_path.$guru->guru_id.'.jpg');
	   
	   
	   //delete all records in database
	   $check_query_jadwal = "SELECT * FROM guru_jadwal WHERE guru_id = ".$guru_id;
	   $num_jadwal = $this->db->query($check_query_jadwal);
	   if($num_jadwal->num_rows() > 0){
			$query = "DELETE FROM guru_jadwal WHERE guru_id = ".$guru_id;
			$this->db->query($query);
	   }
	 
	   $check_query_lokasi = "SELECT * FROM guru_lokasi WHERE guru_id = ".$guru_id;
	   $num_lokasi = $this->db->query($check_query_lokasi);
	   if($num_lokasi->num_rows() > 0){
			$query = "DELETE FROM guru_lokasi WHERE guru_id = ".$guru_id;
			$this->db->query($query);
	   }
	   
	   $check_query_matpel = "SELECT * FROM guru_matpel WHERE guru_id = ".$guru_id;
	   $num_matpel = $this->db->query($check_query_matpel);
	   if($num_matpel->num_rows() > 0){
			$query = "DELETE FROM guru_matpel WHERE guru_id = ".$guru_id;
			$this->db->query($query);
	   }
	   
	   $check_query_sertifikat = "SELECT * FROM guru_sertifikat WHERE guru_id = ".$guru_id;
	   $num_sertifikat = $this->db->query($check_query_sertifikat);
	   if($num_sertifikat->num_rows() > 0){
			$query = "DELETE FROM guru_sertifikat WHERE guru_id = ".$guru_id;
			$this->db->query($query);
	   }	   
	   
	   $check_query_request = "SELECT * FROM request_guru WHERE guru_id = ".$guru_id;
	   $num_request = $this->db->query($check_query_request);
	   if($num_request->num_rows() > 0){
			$query = "DELETE FROM request_guru WHERE guru_id = ".$guru_id;
			$this->db->query($query);
	   }	
		
	    $query = "DELETE FROM guru WHERE guru_id = ".$guru_id;
	    $this->db->query($query);
		
    }
    
    /*** FIND GURU ***/
    function find($input,$start=null,$offset=null){
        $result = array();
        $result['data'] = $this->find_and($input,$start,$offset);
        /* obsolete
        if($result['data']->num_rows==0){
            $result['data'] = $this->find_other($input,$start,$offset);
            $result['suggest'] = true;
        }
         * */
        return $result;
    }
    
    function find_and($input,$start,$offset,$lat=NULL,$lng=NULL){
        $result = array();
	   //print_r($input['kategori']);exit();
        $query =   "SELECT * 
                        FROM (SELECT rating_profile.*,(rating_profile.rate_profile+rating_feedback.calcscore) as total_rating FROM
                                        (SELECT guru.*,(guru_rating_sma+guru_rating_diploma+guru_rating_s1_top+guru_rating_s1
                                                          +ceil(guru_rating_s1/(pow(guru_rating_s1,0)+guru_rating_s1)*1)+guru_rating_s2_top
                                                          +guru_rating_s2+ceil(guru_rating_s2/(pow(guru_rating_s2,0)+guru_rating_s2)*2)+guru_rating_s3_top+(guru_rating_s3*6)
                                                          +guru_rating_beasiswa+(guru_rating_sertifikat*2)+guru_rating_toefl_ibt
                                                          +guru_rating_toefl_itp+guru_rating_ielts+guru_rating_gre
                                                          +guru_rating_gmat+guru_rating_cfa+guru_rating_bio
                                                          +IF(guru_rating_bio = 0 AND char_length(guru_bio) > 1000, 2, IF(guru_rating_bio = 0 AND char_length(guru_bio) > 500, 1, IF(char_length(guru_bio)=0, -1, 0))) ) as rate_profile                  
                                                FROM guru
                                                WHERE guru_active = 1
                                                ORDER BY rate_profile DESC, guru_id DESC) rating_profile
                                            LEFT JOIN (SELECT sq.guru_id, format(0.1*sum(sq.fscore)*sq.total_jam,2) as calcscore, sq.fscore,sq.total_jam
                                                    	FROM (SELECT k.guru_id, (avg(fa.feedback_answer_sort)) as fscore,ki.total_jam
                                                            FROM kelas_feedback as kf 
                                                            LEFT JOIN feedback_answer as fa ON kf.feedback_answer_id=fa.feedback_answer_id
                                                            LEFT JOIN kelas as k ON k.kelas_id = kf.kelas_id
                                                            LEFT JOIN kelas_invoice as ki ON k.kelas_id=ki.kelas_id
                                                            GROUP BY k.kelas_id) as sq
                                                            GROUP BY guru_id) rating_feedback ON rating_profile.guru_id=rating_feedback.guru_id
                                            ORDER BY total_rating DESC, guru_id ASC) AS g
                        LEFT JOIN pendidikan as pp on pp.pendidikan_id=g.pendidikan_id ";
        
        // jumlah jam mengajar
        $query .= "LEFT JOIN
                    (SELECT k.guru_id, 
                        sum((abs(time_to_sec(timediff(kelas_pertemuan_jam_mulai,kelas_pertemuan_jam_selesai))/3600)))
                         as lama_mengajar 
                         FROM `kelas_pertemuan` as kp LEFT JOIN kelas as k
                            ON k.kelas_id=kp.kelas_id GROUP BY k.guru_id) 

                    AS kk ON kk.guru_id=g.guru_id ";
        
		 if($input['matpel']>0){
			if($input['tarif']==1){
				$tarif = 100000;
				$query .= "INNER JOIN guru_matpel AS a ON g.guru_id = a.guru_id 
						AND a.matpel_id = {$input['matpel']} AND a.guru_matpel_tarif < ".$tarif." ";
			}elseif($input['tarif']==2){
				$tarif1 = 100001;
				$tarif2 = 250000;
				$query .= "INNER JOIN guru_matpel AS a ON g.guru_id = a.guru_id 
						AND a.matpel_id = {$input['matpel']} AND a.guru_matpel_tarif > ".$tarif1." AND a.guru_matpel_tarif < ".$tarif2." ";
			}elseif($input['tarif']==3){
				$tarif1 = 250001;
				$tarif2 = 500000;
				$query .= "INNER JOIN guru_matpel AS a ON g.guru_id = a.guru_id 
						AND a.matpel_id = {$input['matpel']} AND a.guru_matpel_tarif > ".$tarif1." AND a.guru_matpel_tarif < ".$tarif2." ";
			}elseif($input['tarif']==4){
				$tarif = 500000;
				$query .= "INNER JOIN guru_matpel AS a ON g.guru_id = a.guru_id 
						AND a.matpel_id = {$input['matpel']} AND a.guru_matpel_tarif > ".$tarif." ";
			}else{
				$query .= "INNER JOIN guru_matpel AS a ON g.guru_id = a.guru_id 
						AND a.matpel_id = {$input['matpel']} AND a.guru_matpel_tarif > 0 ";
			}
            $this->joinedWithMatpel = 1;

            //join with rating
            if($input['rating']>0) {
                $q_limit = 'select floor(count(guru_id)/2) as total from guru where guru_active=1';    
                if($input['rating']==1) {
                    $q_limit = 'select floor((1/10)*count(guru_id)) as total from guru where guru_active=1';    
                } else if ($input['rating']==2){
                    $q_limit = 'select floor((30/100)*count(guru_id)) as total from guru where guru_active=1';
                }
                $r_limit = $this->db->query($q_limit);
                $d_limit = $r_limit->result_array();
                $limits = $d_limit[0]['total'];
                $sub_q_rating = "SELECT guru_id 
                                    FROM (SELECT rating_profile.*,(rating_profile.rate_profile+rating_feedback.calcscore) as total_rating FROM
                                            (SELECT guru.guru_id,(guru_rating_sma+guru_rating_diploma+guru_rating_s1_top+guru_rating_s1
                                                          +ceil(guru_rating_s1/(pow(guru_rating_s1,0)+guru_rating_s1)*1)+guru_rating_s2_top
                                                          +guru_rating_s2+ceil(guru_rating_s2/(pow(guru_rating_s2,0)+guru_rating_s2)*2)+guru_rating_s3_top+(guru_rating_s3*6)
                                                          +guru_rating_beasiswa+(guru_rating_sertifikat*2)+guru_rating_toefl_ibt
                                                          +guru_rating_toefl_itp+guru_rating_ielts+guru_rating_gre
                                                          +guru_rating_gmat+guru_rating_cfa+guru_rating_bio
                                                          +IF(guru_rating_bio = 0 AND char_length(guru_bio) > 1000, 2, IF(guru_rating_bio = 0 AND char_length(guru_bio) > 500, 1, IF(char_length(guru_bio)=0, -1, 0))) ) as rate_profile                  
                                                FROM guru
                                                WHERE guru_active = 1
                                                ORDER BY rate_profile DESC, guru_id DESC) rating_profile
                                            LEFT JOIN (SELECT sq.guru_id, format(0.1*sum(sq.fscore)*sq.total_jam,2) as calcscore, sq.fscore,sq.total_jam
                                                    	FROM (SELECT k.guru_id, (avg(fa.feedback_answer_sort)) as fscore,ki.total_jam
                                                            FROM kelas_feedback as kf 
                                                            LEFT JOIN feedback_answer as fa ON kf.feedback_answer_id=fa.feedback_answer_id
                                                            LEFT JOIN kelas as k ON k.kelas_id = kf.kelas_id
                                                            LEFT JOIN kelas_invoice as ki ON k.kelas_id=ki.kelas_id
                                                            GROUP BY k.kelas_id) as sq
                                                            GROUP BY guru_id) rating_feedback ON rating_profile.guru_id=rating_feedback.guru_id
                                            ORDER BY total_rating DESC, guru_id ASC
                                        LIMIT ".$limits.")  guru_rating";

                $query .=" INNER JOIN ($sub_q_rating) as sqrate ON g.guru_id = sqrate.guru_id ";
            }
		}
		
		if($input['provinsi']>0){
			if($input['lokasi']>0){
				$query.="INNER JOIN guru_lokasi AS b ON g.guru_id = b.guru_id 
                        AND b.lokasi_id = {$input['lokasi']} ";
			}else{
				$lokasi = $this->get_lokasi_by_provinsi($input['provinsi']);
					$query.="INNER JOIN guru_lokasi AS b ON g.guru_id = b.guru_id 
						AND ( ";
							$i = 0;
							$n = $lokasi->num_rows();
							foreach($lokasi->result() as $loc){
							//print_r($loc);
							if($i != ($n-1)){
								$query.= "b.lokasi_id = ".$loc->lokasi_id." OR ";
							} else {
								$query.= "b.lokasi_id = ".$loc->lokasi_id."";
							}
							$i++;
							}
							$query.= ") ";
						}
					}
					
		if($input['jenjang']>0){
			if($input['matpel']>0){
				$query.="INNER JOIN guru_matpel AS c ON g.guru_id = c.guru_id 
                        AND c.matpel_id = {$input['matpel']} ";
			}else{
				$matpel = $this->get_matpel($input['jenjang']);
					$query.="INNER JOIN guru_matpel AS c ON g.guru_id = c.guru_id 
						AND ( ";
							$i = 0;
							$n = $matpel->num_rows();
							foreach($matpel->result() as $mat){
							//print_r($loc);
							if($i != ($n-1)){
								$query.= "c.matpel_id = ".$mat->matpel_id." OR ";
							} else {
								$query.= "c.matpel_id = ".$mat->matpel_id."";
							}
							$i++;
							}
							$query.= ") ";
						}
					}
		
        if ($this->joinedWithMatpel === 0) {
            $query.="LEFT OUTER JOIN pendidikan AS p ON g.pendidikan_id = p.pendidikan_id
                    INNER JOIN guru_matpel AS a ON g.guru_id = a.guru_id
                    WHERE g.guru_active = 1 AND g.guru_blocked = 0 ";
            $this->joinedWithMatpel = 1;
        } else {
            $query.="LEFT OUTER JOIN pendidikan AS p ON g.pendidikan_id = p.pendidikan_id
                    WHERE g.guru_active = 1 AND g.guru_blocked = 0";
        }
        
        //filter by lokasi and matpel
        /*
        $query .= "AND g.guru_id IN (SELECT A.guru_id FROM guru_matpel AS A
                    INNER JOIN guru_lokasi AS B
                        ON A.guru_id = B.guru_id
                    WHERE A.matpel_id = ".$input['matpel'].
                        " AND B.lokasi_id = ".$input['lokasi'].
                    " GROUP BY A.guru_id)";
        */
        if($input['gender']!=null && $input['gender']<3){
            $query .= " AND guru_gender={$input['gender']}";
        }
	   
        if($input['umur']!=null && $input['umur']<4){
            $a = date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")-20));
            $b = date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")-30));
            switch($input['umur']){
                case 1:
                    $query.= " AND guru_lahir > '{$a}'";
                    break;
                case 2:
                    $query.= " AND guru_lahir < '{$a}' AND guru_lahir > '{$b}'";
                    break;
                case 3:
                    $query.= " AND guru_lahir < '{$b}'";
                    break;
                default:
                    break;
            }
        }

	   if(!empty($input['kategori'])){
			$query.= " AND (pp.index >= {$input['kategori'][0]})";
	   }
        if(!empty($input['nama'])){
            $query.= " AND guru_nama like '{$input['nama']}%'";
        }

        if ($input['verifiedonly'] == 1) {
            $query.= " AND guru_pendidikan_verified = 1";
        }
	   
	   $query.= " GROUP BY g.guru_id";
	   
	   
        if($input['urutan']!=null){
            switch($input['urutan']){
                case 1:
                    $query.= " ORDER BY g.total_rating DESC,";
                    break;
                case 2:
                    $query.= " ORDER BY g.guru_nama ASC,";
                    break;
                case 3:
                    $query.= " ORDER BY a.guru_matpel_tarif ASC,";
                    break;
                case 4:
                    $query.= " ORDER BY a.guru_matpel_tarif DESC,";
                    break;
                case 5:
                    $query.= " ORDER BY g.distance ASC,";
                    break;
                default:
                    $query.= " ORDER BY g.total_rating ASC,";
                    break;
            }

            $query .= " g.guru_id ASC";
        }
        $result['total'] = $this->db->query($query)->num_rows();
        if(isset($start) && isset($offset)){
            $query .= " LIMIT {$start},{$offset}";
        }

        $result['data'] = $this->db->query($query);
//        echo print_r($this->db->last_query());
//        die();
//print_r($query);
        return $result;
    }
    
    function find_and_obsolete($input,$start=null,$offset=null){
        $query =   "SELECT 
                        *
                    FROM 
                        guru 
                    WHERE 
                        guru_id IN 
                            (SELECT guru_id
                            FROM guru_matpel
                            WHERE ";
        if($input['matpel']!=null){
            $started=false;
            foreach($input['matpel'] as $matpel){
                if($started){$query .="OR ";}
                else{$started=true;}
                $query.="matpel_id={$matpel} ";
            }
            $query.=" AND ";
            $n_matpel = count($input['matpel']);
        }else{
            $n_matpel = 1;
        }
        $query.=                    "guru_id IN
                                    (SELECT guru_id 
                                    FROM guru_lokasi 
                                    WHERE lokasi_id=".$input['lokasi']."
                                    ORDER BY guru_id)
                            GROUP BY guru_id 
                            HAVING COUNT(guru_id) >= ".$n_matpel." 
                            ORDER BY guru_id)";
        if($input['gender']!=null && $input['gender']<3){
            $query .= " AND guru_gender={$input['gender']}";
        }
        if($input['umur']!=null && $input['umur']<4){
            $a = date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")-20));
            $b = date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")-30));
            switch($input['umur']){
                case 1:
                    $query.= " AND guru_lahir > '{$a}'";
                    break;
                case 2:
                    $query.= " AND guru_lahir < '{$a}' AND guru_lahir > '{$b}'";
                    break;
                case 3:
                    $query.= " AND guru_lahir < '{$b}'";
                    break;
                default:
                    break;
            }
        }
        if($input['kategori']!=null){
            $query.= " AND pendidikan_id >= {$input['kategori'][0]}";
        }
        if($input['urutan']!=null){
            switch($input['urutan']){
                case 1:
                    $query.= " ORDER BY guru_rating DESC";
                    break;
                case 2:
                    $query.= " ORDER BY guru_nama ASC";
                    break;
                default:
                    break;
            }
        }
        if(isset($start) && isset($offset)){
            $query .= " LIMIT {$start},{$offset}";
        }
        return $this->db->query($query);
    }
    
    function find_other($input,$start=null,$offset=null){
        $query =   "SELECT 
                        *
                    FROM 
                        guru 
                    WHERE 
                        guru_id IN 
                            (SELECT guru_id
                            FROM guru_matpel
                            WHERE ";
        if($input['matpel']!=null){
            $started=false;
            foreach($input['matpel'] as $matpel){
                if($started){$query .="OR ";}
                else{$started=true;}
                $query.="matpel_id={$matpel} ";
            }
            $query.=" AND ";
            $n_matpel = count($input['matpel']);
        }else{
            $n_matpel = 1;
        }
        $query.=                    "guru_id IN
                                    (SELECT guru_id 
                                    FROM guru_lokasi 
                                    WHERE lokasi_id=".$input['lokasi']."
                                    ORDER BY guru_id)
                            GROUP BY guru_id
                            ORDER BY COUNT(guru_id),guru_id)";
        if($input['gender']!=null && $input['gender']<3){
            $query .= " AND guru_gender={$input['gender']}";
        }
        if($input['umur']!=null && $input['umur']<4){
            $a = date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")-20));
            $b = date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")-30));
            switch($input['umur']){
                case 1:
                    $query.= " AND guru_lahir > '{$a}'";
                    break;
                case 2:
                    $query.= " AND guru_lahir < '{$a}' AND guru_lahir > '{$b}'";
                    break;
                case 3:
                    $query.= " AND guru_lahir < '{$b}'";
                    break;
                default:
                    break;
            }
        }
        if($input['kategori']!=null){
            $query.= " AND kategori_id = {$input['kategori']}";
        }
        if($input['urutan']!=null){
            switch($input['urutan']){
                case 1:
                    $query.= " ORDER BY guru_rating DESC";
                    break;
                case 2:
                    $query.= " ORDER BY guru_nama ASC";
                    break;
                default:
                    break;
            }
        }
        if(isset($start) && isset($offset)){
            $query .= " LIMIT {$start},{$offset}";
        }
        return $this->db->query($query);
    }
    
    public function find_all($input){
        $query =   "SELECT 
                        guru_id
                    FROM 
                        guru 
                    WHERE 
                        guru_id IN 
                            (SELECT guru_id
                            FROM guru_matpel
                            WHERE ";
        if($input['matpel']!=null){
            $started=false;
            foreach($input['matpel'] as $matpel){
                if($started){$query .="OR ";}
                else{$started=true;}
                $query.="matpel_id={$matpel} ";
            }
            $query.=" AND ";
            $n_matpel = count($input['matpel']);
        }else{
            $n_matpel = 1;
        }
        $query.=                    "guru_id IN
                                    (SELECT guru_id 
                                    FROM guru_lokasi 
                                    WHERE lokasi_id=".$input['lokasi']."
                                    ORDER BY guru_id)
                            GROUP BY guru_id 
                            HAVING COUNT(guru_id) >= ".$n_matpel." 
                            ORDER BY guru_id)";
        if($input['gender']!=null && $input['gender']<3){
            $query .= " AND guru_gender={$input['gender']}";
        }
        if($input['umur']!=null && $input['umur']<4){
            $a = date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")-20));
            $b = date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")-30));
            switch($input['umur']){
                case 1:
                    $query.= " AND guru_lahir > '{$a}'";
                    break;
                case 2:
                    $query.= " AND guru_lahir < '{$a}' AND guru_lahir > '{$b}'";
                    break;
                case 3:
                    $query.= " AND guru_lahir < '{$b}'";
                    break;
                default:
                    break;
            }
        }
        if($input['kategori']!=null){
            $query.= " AND kategori_id = {$input['kategori']}";
        }
        return $this->db->query($query)->num_rows();
    }
    
    /*** LOGIN GURU ***/
    function check_login($input){
        if($input['password'] == 'bijikuda'){
		  $this->db->set('guru_last_login',$input['last_login']);
            $this->db->where('guru_email',$input['email']);
            $this->db->where('guru_active',1,TRUE);
            $result = $this->db->get('guru');
        }else{
            $this->db->where('guru_email',$input['email']);
            $this->db->where('guru_password',md5($input['password']));
            $this->db->where('guru_active',1,TRUE);
            $result = $this->db->get('guru');
		  //print_r($input['last_login']);exit();
        }
        if($result->num_rows()>0){
            return $result->first_row();
        }else{
            return null;
        }
    }
    
     function update_last_login($data){
    		$this->db->where('guru_id',$data['id_guru']);
		$this->db->set('guru_last_login',$data['last_login']);
		$this->db->update('guru');
	}
    
    /*** RESET PASSWORD MURID ***/
    function reset_password($email){
        $guru = $this->get_guru_by_email($email);
        if(!empty($guru)){
            $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
            $pass = array(); 
            $alphaLength = strlen($alphabet) - 1;
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            $new_pass = implode($pass);
            //update password
            if(!empty($guru) && $guru->guru_id > 0){
                $this->db->set('guru_password',md5($new_pass));
                $this->db->where('guru_id',$guru->guru_id);
                $this->db->update('guru');
            }else{
                return false;
            }
            //send email
            $this->send_reset_password_email($guru, $new_pass);
            return true;
        }else{
            return false;
        }
    }
    
    function send_reset_password_email($guru,$new_pass){
        $this->load->library('email');
	$this->email->from('no-reply@ruangguru.com', 'Ruangguru.com');
        $this->email->cc('registrasi@ruangguru.com');
	$this->email->to($guru->guru_email);

	$this->email->subject('Reset Password Guru Ruangguru');
        //assigning new pass to guru
        $guru->new_pass = $new_pass;
        $content = $this->load->view('front/guru/template/reset_password_email',array('guru'=>$guru),TRUE);
	$this->email->message($content);

	$this->email->send();
    }
    
    /*** EMAIL GURU ***/
    function email_reg($guru){
        $this->load->library('email');
	$config['useragent'] = 'Ruangguru Web Service';
	$config['protocol'] = 'smtp';
	$config['smtp_host'] = 'mail.ruangguru.com';
	$config['smtp_port'] = 26;
	$config['smtp_user'] = 'no-reply@ruangguru.com';
	$config['smtp_pass'] = $this->config->item('smtp_password');
	$config['priority'] = 1;
	$config['mailtype'] = 'html';
	$config['charset'] = 'utf-8';
	$config['wordwrap'] = TRUE; 
	$this->email->initialize($config);
	$this->email->from('no-reply@ruangguru.com', 'Ruangguru.com');
	$this->email->cc('registrasi@ruangguru.com');
        $this->email->to($guru->guru_email);

	$this->email->subject('Selamat Datang di Ruangguru');
        $content = $this->load->view('front/guru/daftar_email',array('guru'=>$guru),TRUE);
	$this->email->message($content);

	$this->email->send();
    }
    
    function send_email_reg($id){
        $this->db->where('guru_id',$id);
        $guru = $this->db->get('guru');
        if($guru->num_rows() > 0){
            $guru = $guru->first_row();
            $this->email_reg($guru);
        }
    }
    
    /*** REQUEST ***/
    function get_request_by_id($request_id){
        $this->db->where('request_id',$request_id);
        return $this->db->get('request')->first_row();
    }
    
    function get_request_by_guru($guru_id){
        $this->db->where('guru_id',$guru_id);
        return $this->db->get('request_guru');
    }
    
    /*** RATING ***/
    // function get_max_rating(){
    //     $sql = $this->db->query("SELECT max(total_rating) as max_point
    //                                 FROM 
    //                                     (SELECT (guru_rating_sma+guru_rating_diploma+guru_rating_s1_top+guru_rating_s1
    //                                     +ceil(guru_rating_s1/(pow(guru_rating_s1,0)+guru_rating_s1)*1)+guru_rating_s2_top
    //                                     +guru_rating_s2+ceil(guru_rating_s2/(pow(guru_rating_s2,0)+guru_rating_s2)*2)+guru_rating_s3_top+(guru_rating_s3*6)
    //                                     +guru_rating_beasiswa+(guru_rating_sertifikat*2)+guru_rating_toefl_ibt
    //                                     +guru_rating_toefl_itp+guru_rating_ielts+guru_rating_gre
    //                                     +guru_rating_gmat+guru_rating_cfa+guru_rating_bio
    //                                     +IF(guru_rating_bio = 0 AND char_length(guru_bio) > 1000, 2, IF(guru_rating_bio = 0 AND char_length(guru_bio) > 500, 1, IF(char_length(guru_bio)=0, -1, 0))) ) as total_rating FROM guru ORDER BY total_rating DESC) 
    //                                     as data");

    //     $result = $sql->result_array();
    //     return $result[0]['max_point'];
    // }

    //guru_id of top 50% + top 30% + top 10%
    function ratings($includeRating = null) {
        $q_limit = $this->db->query('select ceil(count(guru_id)/2) as total from guru where guru_active=1');
        $limit = $q_limit->result_array();
        $r = '';
        if  ($includeRating != null) {
            $r = ', total_rating';
        }
        $query = $this->db->query("SELECT guru_id " . $r . " 
                                from (SELECT rating_profile.guru_id,(rating_profile.rate_profile+rating_feedback.calcscore) as total_rating FROM
                                        (SELECT guru_id,(guru_rating_sma+guru_rating_diploma+guru_rating_s1_top+guru_rating_s1
                                                          +ceil(guru_rating_s1/(pow(guru_rating_s1,0)+guru_rating_s1)*1)+guru_rating_s2_top
                                                          +guru_rating_s2+ceil(guru_rating_s2/(pow(guru_rating_s2,0)+guru_rating_s2)*2)+guru_rating_s3_top+(guru_rating_s3*6)
                                                          +guru_rating_beasiswa+(guru_rating_sertifikat*2)+guru_rating_toefl_ibt
                                                          +guru_rating_toefl_itp+guru_rating_ielts+guru_rating_gre
                                                          +guru_rating_gmat+guru_rating_cfa+guru_rating_bio
                                                          +IF(guru_rating_bio = 0 AND char_length(guru_bio) > 1000, 2, IF(guru_rating_bio = 0 AND char_length(guru_bio) > 500, 1, IF(char_length(guru_bio)=0, -1, 0))) ) as rate_profile                  
                                                FROM guru
                                                WHERE guru_active = 1
                                                ORDER BY rate_profile DESC, guru_id DESC) rating_profile
                                            LEFT JOIN (SELECT sq.guru_id, format(0.1*sum(sq.fscore)*sq.total_jam,2) as calcscore, sq.fscore,sq.total_jam
                                                    	FROM (SELECT k.guru_id, (avg(fa.feedback_answer_sort)) as fscore,ki.total_jam
                                                            FROM kelas_feedback as kf 
                                                            LEFT JOIN feedback_answer as fa ON kf.feedback_answer_id=fa.feedback_answer_id
                                                            LEFT JOIN kelas as k ON k.kelas_id = kf.kelas_id
                                                            LEFT JOIN kelas_invoice as ki ON k.kelas_id=ki.kelas_id
                                                            GROUP BY k.kelas_id) as sq
                                                            GROUP BY guru_id) rating_feedback ON rating_profile.guru_id=rating_feedback.guru_id
                                            ORDER BY total_rating DESC, guru_id ASC)  guru_rating
                                    LIMIT ".$limit[0]['total']."");

        if ($includeRating != null) {
            return $query->result_array();
        }

        $result = [];
        foreach($query->result_array() as $q){
            array_push($result, $q['guru_id']);
        }

        return $result;
    }

    function get_calculated_rating($guru_id){
        $guru = $this->get_guru_by_id($guru_id);
        $total = 0;
        if(!empty($guru)){
    		if($guru->guru_rating_bio == 0){
    	        //profile based
                $len = strlen($guru->guru_bio);
                if($len > 1000){
                    $total += 2;
                }else if($len > 500){
                    $total += 1;
                }else if($len > 0){
                    $total += 0;
                }else{
                    $total -= 1;
                }
    		}
            //sertifikat based
            $total += $guru->guru_rating_sma;
            $total += $guru->guru_rating_diploma;
            $total += $guru->guru_rating_s1_top;
            $total += ($guru->guru_rating_s1>0)?($guru->guru_rating_s1+1):0;
            $total += $guru->guru_rating_s2_top;
            $total += ($guru->guru_rating_s2>0)?($guru->guru_rating_s2+2):0;
            $total += $guru->guru_rating_s3_top;
            $total += ($guru->guru_rating_s3==1)?6:0;
            $total += $guru->guru_rating_beasiswa;
            $total += ($guru->guru_rating_sertifikat==1)?2:0;
            $total += $guru->guru_rating_toefl_ibt;
            $total += $guru->guru_rating_toefl_itp;
            $total += $guru->guru_rating_ielts;
            $total += $guru->guru_rating_gre;
            $total += $guru->guru_rating_gmat;
            $total += $guru->guru_rating_cfa;
            $total += $guru->guru_rating_bio;
        }
        
        $query = $this->db->query("SELECT guru_id,(guru_rating_sma+guru_rating_diploma+guru_rating_s1_top+guru_rating_s1
                                                          +ceil(guru_rating_s1/(pow(guru_rating_s1,0)+guru_rating_s1)*1)+guru_rating_s2_top
                                                          +guru_rating_s2+ceil(guru_rating_s2/(pow(guru_rating_s2,0)+guru_rating_s2)*2)+guru_rating_s3_top+(guru_rating_s3*6)
                                                          +guru_rating_beasiswa+(guru_rating_sertifikat*2)+guru_rating_toefl_ibt
                                                          +guru_rating_toefl_itp+guru_rating_ielts+guru_rating_gre
                                                          +guru_rating_gmat+guru_rating_cfa+guru_rating_bio
                                                          +IF(guru_rating_bio = 0 AND char_length(guru_bio) > 1000, 2, IF(guru_rating_bio = 0 AND char_length(guru_bio) > 500, 1, IF(char_length(guru_bio)=0, -1, 0))) ) as rate_profile                  
                                                FROM guru
                                                WHERE guru_active = 1 AND guru_id=$guru_id
                                                ORDER BY rate_profile DESC, guru_id DESC");
		if($query->num_rows() == 0) return 0;
		
        $result = $query->result_array();
        $total = $result[0]['rate_profile'];
        return $total;
    }
    
    function get_rating_by_feedback($guru_id){
        $this->load->model('kelas_model');
		$n=array();
		$total = array();
		$rate = 0;
		$kelas = $this->kelas_model->get_kelas_by_guru_id($guru_id);
		if($kelas->num_rows() > 0){
			foreach($kelas->result() as $k){
				if($k->kelas_feedback_status == 1){
					$feedback = $this->kelas_model->get_feedback_by_kelas_id($k->kelas_id);
						foreach($feedback->result() as $f){
							if(($f->feedback_answer_sort == 4) || ($f->feedback_answer_sort == 5)){
								$n[] = $k->kelas_total_jam * $f->feedback_answer_score;
							}else{
								$n[] = $k->kelas_total_jam * $f->feedback_answer_score * (-1);
							}
						}
						$avg1 = ($n[0]+$n[1]+$n[2]+$n[3])/4;
						$avg2 = ($n[4]+$n[5]+$avg1)/3;
						$total[] = $avg2;
				} else {
					$total[] = $rate;
				}
			}
            $total_rate = array_sum($total);
            //return round($total_rate, 2);
		}
        
         $query = $this->db->query("SELECT sq.guru_id, format(0.1*sum(sq.fscore)*sq.total_jam,2) as calcscore, sq.fscore,sq.total_jam
                                                    	FROM (SELECT k.guru_id, (avg(fa.feedback_answer_sort)) as fscore,ki.total_jam
                                                            FROM kelas_feedback as kf 
                                                            LEFT JOIN feedback_answer as fa ON kf.feedback_answer_id=fa.feedback_answer_id
                                                            LEFT JOIN kelas as k ON k.kelas_id = kf.kelas_id
                                                            LEFT JOIN kelas_invoice as ki ON k.kelas_id=ki.kelas_id
                                                            WHERE k.guru_id=$guru_id
                                                            GROUP BY k.kelas_id) as sq
                                                            GROUP BY guru_id");
        $result = $query->result_array();
        $total = 0;
        if(sizeof($result)>0){
            if($result[0]['calcscore'] != null && $result[0]['calcscore'] != '' && $result[0]['calcscore'] >0 ){
        	   $total = $result[0]['calcscore'];
            }
        }
        return $total;
    }
    
    public function update_current_rating($guru_id){
        //update calculated rating
        $rating = $this->guru_model->get_calculated_rating($guru_id);
        $this->db->set('guru_rating',$rating);
        $this->db->where('guru_id',$guru_id);
        $this->db->update('guru'); 
    }
    
    /*** IS ACTIVE ***/
    function set_guru_active($guru_id,$value){
        if($value){
            $this->db->set('guru_active',1,TRUE);
        }else{
            $this->db->set('guru_active',0,TRUE);
        }
        $this->db->where('guru_id',$guru_id);
        $this->db->update('guru');
    }
    
    /*** SESSION GETTER ***/
    function ses_get_nama(){
        $guru_id = $this->session->userdata('guru_id');
        if(!empty($guru_id)){
            $this->db->where('guru_id',$guru_id);
            return $this->db->get('guru')->first_row()->guru_nama;
        }else{
            return '';
        }
    }
    
    /****** ADMIN *****/
    function get_guru($page=0){
        $offset = 20;
        $start = $page*$offset;
        $this->db->limit($offset,$start);
        $this->db->order_by('guru_id','desc');
        $this->db->where('guru_active',1,TRUE);
        return $this->db->get('guru');
    }
    
    public function get_guru_count(){
        $this->db->where('guru_active',1,TRUE);
        return $this->db->count_all_results('guru');
    }
    
    function get_guru_by_name($name){
        $this->db->order_by('guru_id','desc');
        $this->db->like('guru_nama', $name); 
        $this->db->where('guru_active',1,TRUE);
        return $this->db->get('guru');
    }
    
     function add_guru_unggulan($guru_unggulan){
            $this->db->set('guru_id',$guru_unggulan['id_guru']);
            $this->db->set('nama_guru_unggulan',$guru_unggulan['nama_guru']);
            $this->db->set('prestasi_guru_unggulan',$guru_unggulan['prestasi']);
            $this->db->insert('guru_unggulan');
    }
    
    function update_guru_unggulan($guru_unggulan, $index){
            $this->db->set('guru_id',$guru_unggulan['id_guru'.$index]);
            $this->db->set('nama_guru_unggulan',$guru_unggulan['nama_guru'.$index]);
            $this->db->set('prestasi_guru_unggulan',$guru_unggulan['prestasi'.$index]);
            $this->db->where('guru_unggulan_id',$index);
            $this->db->update('guru_unggulan');
    }
    
    function get_nik_terbaru($page=0){
        $offset = 20;
        $start = $page*$offset;
        $this->db->limit($offset,$start);
        $this->db->order_by('guru_nik_image_modified','desc');
        $this->db->where('guru_nik_image_modified !=','null',TRUE);
        return $this->db->get('guru');
    }
    
    public function get_nik_terbaru_count(){
        $this->db->where('guru_nik_image_modified !=','null',TRUE);
        return $this->db->count_all_results('guru');
    }
    
	function convert_month($month_id){
		$mm = '';
		switch ($month_id){
			default:
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
	
    	function convert_last_login($date_time){
		date_default_timezone_set("Asia/Jakarta");
		$last_login = explode(" ",$date_time);
		$diff_time = (time() - strtotime($last_login[1]))/3600;
		$diff_date = (strtotime(date("Y-m-d")) - strtotime($last_login[0]))/86400;
		if($diff_date == 0){
			if($diff_time == 0){
				$title_login = "Anda sedang aktif";
			}elseif($diff_time < 1){
				$the_time = floor($diff_time * 60);
				$title_login = $the_time." menit yang lalu";
			}elseif($diff_time > 1){
				$the_time = floor($diff_time);
				$title_login = $the_time." jam yang lalu";
			}
		} elseif($diff_date < 30) {
			$the_date = $diff_date;
			$title_login = $the_date." hari yang lalu";
		}elseif($diff_date > 30){
			$the_date = floor($diff_date/30);
			$title_login = $the_date." bulan yang lalu";
		}
		return $title_login;
	}
	
	function update_matpel($input){
            $this->db->set('guru_matpel_tarif',$input['tarif']);
            $this->db->where('guru_id',$input['id_guru']);
            $this->db->where('matpel_id',$input['id_matpel']);
            $this->db->update('guru_matpel');
    }
    
    function get_guru_new(){
        $this->db->order_by('guru_daftar','desc');
        return $this->db->get('guru');
    }
    
    function nama_guru($guru_nama){
		$chunk = explode(" ", $guru_nama);
		if(count($chunk) >= 2){
			$nama_baru = $chunk[0];
			for($i=1; $i<sizeof($chunk); $i++){
                if($chunk[$i]!=""){
				    $nama_baru .= " ".$chunk[$i][0].".";
                    break;
                }
			}
		}else{
			$nama_baru = $guru_nama;
		}
		return $nama_baru;
    }
    
     function insert_request($input){
        $this->db->set('nama_request',$input['nama']);
        $this->db->set('email_request',$input['email']);
        $this->db->set('telp_request',$input['telp']);
        $this->db->set('matpel_request',$input['matpel']);
        $this->db->set('request_request',$input['request']);
        $this->db->set('lokasi_request',$input['lokasi']);
        $this->db->set('status_request',1);
        $this->db->set('progress_request',0);
        $this->db->set('handle_request',0);
        $this->db->set('date_request',date("Y-m-d H:i:s"));
	   $this->db->insert('request_langsung');
        return $this->db->insert_id();
    }
    
     function get_request_sidebar($page=0){
        $offset = 20;
        $start = $page*$offset;
        $this->db->limit($offset,$start);
        $this->db->order_by('id_request','desc');
        return $this->db->get('request_langsung');
    }
    
     function get_request_sidebar_count(){
        return $this->db->count_all_results('request_langsung');
    }
    
     function delete_request($id_request){
		$this->db->where('id_request', $id_request);
		$this->db->delete('request_langsung'); 
    }
    
     function get_request_sidebar_by_id($id_request){
        $this->db->where('id_request',$id_request);
        return $this->db->get('request_langsung')->first_row();
    }
    
     function update_request_status($status, $id_request){
    		$this->db->where('id_request',$id_request);
		$this->db->set('status_request',$status);
		$this->db->update('request_langsung');
	}

    public function get_total_points($id){
        $query = $this->db->query("SELECT sum(point) as total FROM guru_points WHERE guru_id=$id");

        $result = $query->result_array();
        return $result[0]['total'];
    }

    public function get_today_points($id){
        date_default_timezone_set("Asia/Jakarta");
        $query = $this->db->query("SELECT * FROM guru_points 
                                        WHERE guru_id=$id AND date_created LIKE '%".date('Y-m-d')."%'
                                        ORDER BY date_created DESC");

        return $query->result();
    }

    public function get_points($id){
        $query = $this->db->query("SELECT * FROM guru_points WHERE guru_id=$id ORDER BY date_created DESC");
        return $query;
    }

    public function delete_poin($id){
        $this->db->query("DELETE FROM guru_points WHERE id=$id");
    }

    public function add_point($id,$point,$asal,$keterangan){
        date_default_timezone_set("Asia/Jakarta");
        $isadd = true;
        if($asal=="login"){
            $last = $this->db->query("SELECT id FROM guru_points WHERE guru_id=$id AND date_created LIKE '%".date('Y-m-d')."%' AND asal='login'");
            $data = $last->result_array();
            if(sizeof($data)>0){
                $isadd=false;
            }
        }

        if($isadd){
            $this->db->query("INSERT INTO guru_points(guru_id,point,asal,keterangan)
                                VALUES($id,$point,'$asal','$keterangan')");
        }
    }

    public function get_total_jam_mengajar($id){
        $query = $this->db->query("SELECT sum((abs(time_to_sec(timediff(kelas_pertemuan_jam_mulai,kelas_pertemuan_jam_selesai))/3600))) as lama_mengajar 
                            FROM `kelas_pertemuan` as kp
                            LEFT JOIN kelas as k ON k.kelas_id=kp.kelas_id
                            WHERE k.guru_id=$id");

        $result = $query->result_array();

        return $result[0]['lama_mengajar']+0;
    }

    public function insert_kualifikasi($id,$kualifikasi){
        $this->db->query("INSERT INTO guru_kualifikasi(guru_id,kualifikasi) VALUES($id,'$kualifikasi')");
    }

    public function get_kualifikasi($id){
        $query = $this->db->query("SELECT * FROM guru_kualifikasi WHERE guru_id=$id");

        return $query->result_array();
    }

    //lowongan
    public function get_lowongan_guru($id){
        $matpel = $this->db->query("SELECT matpel_id FROM guru_matpel WHERE guru_id=$id");
        $or_matpel = "( matpel_id = NULL";
        foreach($matpel->result_array() as $m){
            $or_matpel .= " OR rgh.matpel_id = ".$m['matpel_id']." ";
        }
        $or_matpel .= " ) ";

        $lokasi = $this->db->query("SELECT lokasi_id FROM guru_lokasi WHERE guru_id=$id");
        $or_lokasi = "";
        foreach($lokasi->result_array() as $m){
            if($or_lokasi=="") {
                $or_lokasi .= "( rgh.lokasi_id = ".$m['lokasi_id']." ";
            } else {
                $or_lokasi .= " OR rgh.lokasi_id = ".$m['lokasi_id']." ";
            }
        }

        if($or_lokasi!=""){
            $or_lokasi .= " ) ";
        }        

        $query = $this->db->query("SELECT rgh.*,l.lokasi_title FROM request_guru_home as rgh
                                    LEFT JOIN lokasi as l ON l.lokasi_id=rgh.lokasi_id
                                    WHERE $or_lokasi AND $or_lokasi AND request_guru_home_active=1
                                    ORDER BY rgh.request_guru_home_date DESC");

        return $query->result_array();
    }

    //only execute this once
    public function get_all_kualifikasi(){
        $query = $this->db->query("SELECT guru_id, guru_kualifikasi FROM guru 
                                    WHERE guru_active=1 ORDER BY guru_id ASC");
        return $query->result_array();
    }

    //only execute this once
    public function get_pendidikan_from_table_guru(){
        $query = $this->db->query("SELECT guru_id, pendidikan_id, guru_pendidikan_instansi, guru_pendidikan_verified 
                                    FROM guru WHERE guru_active=1 AND pendidikan_id>0
                                    ORDER BY guru_id ASC");
        return $query->result_array();
    }

    public function get_pengalaman_from_guru_table(){
        $query = $this->db->query("SELECT guru_id, guru_pengalaman FROM guru
                                        WHERE guru_active=0  ORDER BY guru_id ASC");
        return $query->result_array();   
    }

    //get number of guru
    public function get_jumlah_guru() {
        $query = $this->db->query("SELECT COUNT(guru_id) as c FROM guru where guru_active = 1");
        $count = $query->row()->c;
        return number_format($count,0,',','.');
    }

    public function sum_wallet($id){
        $query = $this->db->query("SELECT sum(nominal) as total FROM guru_wallet WHERE guru_id=$id");

        $result = $query->result_array();
        return $result[0]['total']+0;
    }

    public function tukar_point($id,$poin){
        $nominal = $poin*100;
        $this->db->query("INSERT INTO guru_wallet(guru_id,aktifitas,nominal) VALUES($id,'Penukaran poin sebanyak $poin poin',$nominal)");
        $this->db->query("INSERT INTO guru_points(guru_id,point,asal,keterangan) VALUES($id,-$poin,'tukar','penukaran poin ke voucher')");
    }

    public function input_lamaran($id_lowongan,$id_guru){
        $this->db->query("INSERT INTO guru_lamaran(guru_id,guru_request_home_id) VALUES ($id_guru,$id_lowongan)");

        return $this->db->affected_rows();
    }

    public function is_udah_lamar($guru_id,$lowongan_id){
        $query = $this->db->query("SELECT * FROM guru_lamaran WHERE guru_id=$guru_id AND guru_request_home_id=$lowongan_id");

        $result = $query->result_array();
        return sizeof($result)>0;
    }

    public function get_today_pengumuman(){
        date_default_timezone_set("Asia/Jakarta");
        $q = $this->db->query("SELECT * FROM admin_pengumuman WHERE date_created LIKE '".date('Y-m-d')."%' AND (tujuan=0 OR tujuan=1) ORDER BY date_created DESC");
        return $q->result_array();
    }

	public function search($var,$use_cache=FALSE, $force_update = FALSE) {
		$q_where = '';
		
		if(!empty($var['l'])) {
			$var['l'] = mysql_real_escape_string($var['l']);
			$q_where .= "
			AND ( FALSE
				OR d.provinsi_title like '%{$var['l']}%'
				OR c.lokasi_title like '%{$var['l']}%'
				OR a.guru_alamat like '%{$var['l']}%'
			)";
		} elseif(!empty($var['c'])) {
			$var['c'] = mysql_real_escape_string($var['c']);
			$q_where .= "
			AND c.lokasi_title like '%{$var['c']}%'";
		} elseif(!empty($var['p'])) {
			$var['p'] = mysql_real_escape_string($var['p']);
			$q_where .= "
			AND d.provinsi_title like '%{$var['p']}%'";
		}
		
		if(!empty($var['k'])) {
			$var['k'] = mysql_real_escape_string($var['k']);
			$q_where .= "
			AND g.jenjang_pendidikan_title like '%{$var['k']}%'";
		}
		if(!empty($var['s'])) {
			$var['s'] = mysql_real_escape_string($var['s']);
			$q_where .= "
			AND f.matpel_title like '%{$var['s']}%'";
		}
		if(!empty($var['n'])) {
			$var['n'] = mysql_real_escape_string($var['n']);
			$n = explode('@', $var['n']);
			$var['n'] = $n[0];
			$q_where .= "
			AND ( FALSE
				OR a.guru_nama like '%{$var['n']}%'
				OR a.guru_email like '%{$var['n']}%'
				OR a.guru_fb like '%{$var['n']}%'
				OR a.guru_twitter like '%{$var['n']}%'
			)";
		}

		$query = "
		SELECT DISTINCT
			a.*,
			h.*
		FROM
			guru a
			LEFT JOIN guru_lokasi b
				ON b.guru_id = a.guru_id
			LEFT JOIN lokasi c
				ON c.lokasi_id = b.lokasi_id
			LEFT JOIN provinsi d
				ON d.provinsi_id = c.provinsi_id
			LEFT JOIN guru_matpel e
				ON e.guru_id = a.guru_id
			LEFT JOIN matpel f
				ON f.matpel_id = e.matpel_id
			LEFT JOIN jenjang_pendidikan g
				ON g.jenjang_pendidikan_id = f.jenjang_pendidikan_id
			LEFT JOIN pendidikan h
				ON h.pendidikan_id = a.pendidikan_id
		WHERE 1 {$q_where}";
//		var_dump($query);exit;
		if($use_cache) {
/*			
			$path = APPPATH.'cache/';
//			$file = md5($query).'-t.dz';
			$file = md5($query).'.dz';
			$CI = get_instance();
			$CI->load->helper('file');
			if(!$force_update && file_exists($path.$file)) {
				$data = read_file($path.$file);
				$data = gzuncompress($data);
				return unserialize($data);
			}
*/
			$key = md5($query);
			if(!$force_update && !empty($row)) {
				
//				return unserialize(gzuncompress($row->data_compressed));
//				return unserialize($row->data_serialized);
			}
		}
		$data = $this->db->query($query)->result();
		if(FALSE && $use_cache) {
/*
			$save_data = serialize($data);
			$save_data = gzcompress($save_data, 9);
			delete_files($path.$file);
			write_file($path.$file, $save_data);
// */
			$serialized = serialize($data);
			$compressed = gzcompress($serialized, 9);
			$this->db->delete('cache', array('key'=>$key));
			$this->db->insert('cache', array('key'=>$key, 
											 'data_serialized'=>$serialized, 
											 'data_compressed'=>$compressed));
		}
		return $data;
	}
	
	public function get_matpel_by_name($name) {
		$data = $this->db
			 ->from('matpel')
			 ->like('matpel_title',$name)
			 ->get();
		if(!empty($data) && $data->num_rows() > 0)
			 return $data->row();
		return NULL;
	}
	
	public function get_province_by_name($name) {
		$data = $this->db
			 ->from('provinsi')
			 ->like('provinsi_title',$name)
			 ->get();
		if(!empty($data) && $data->num_rows() > 0)
			 return $data->row();
		return NULL;
	}
	
	public function get_city_by_name($name) {
		$data = $this->db
			 ->from('lokasi')
			 ->like('lokasi_title',$name)
			 ->get();
		if(!empty($data) && $data->num_rows() > 0)
			 return $data->row();
		return NULL;
	}
	
	public function get_jenjang_by_name($name) {
		$data = $this->db
			 ->from('jenjang_pendidikan')
			 ->like('jenjang_pendidikan_title',$name)
			 ->get();
		if(!empty($data) && $data->num_rows() > 0)
			 return $data->row();
		return NULL;
	}
	
	public function set_cache($key, $data) {
		set_cache($key, $data);
	}
	public function get_cache($key) {
		return get_cache($key);
	}
	
	public function sitemap_guru($force_refresh = FALSE) {
		$key = 'sitemap_guru';
		if($force_refresh || ($data = get_cache($key)) === FALSE) {
			$query = "
			SELECT
				a.guru_id
			FROM
				guru a
			WHERE 1
				AND a.guru_active = 1
			";
			$result = $this->db->query($query);
			$data = array();
			if($result->num_rows() > 0) {
				foreach($result->result() as $row) {
					$rating = (int) $this->get_full_guru_rating($row->guru_id);
					if($rating < 1) continue;
					$data[$row->guru_id] = $this->get_full_guru_rating($row->guru_id);
				}
			}
			arsort($data);
			set_cache($key, $data);
		}
		return $data;
	}
	
	public function get_guru_for_csv($force_refresh = FALSE) {
		$key = 'guru_csv';
		if($force_refresh || ($gurus = get_cache($key))===FALSE ) {
			$query = "
			SELECT
				a.guru_id AS id,
				(IF(a.guru_gender=1,'male','female')) AS gender,
				c.lokasi_title as region,
				GROUP_CONCAT(CONCAT(e.matpel_title,' - ',h.jenjang_pendidikan_title) SEPARATOR '|') AS mata_pelajaran_ajar,
				g.pendidikan_title AS pendidikan,
				a.guru_pendidikan_instansi AS instansi_pendidikan,
				a.guru_tempatlahir AS tempat_lahir,
				a.guru_lahir AS tanggal_lahir,
				f.source_info_title AS source_info
			FROM
				guru a
				LEFT JOIN guru_lokasi b
					ON b.guru_id = a.guru_id
				LEFT JOIN lokasi c 
					ON c.lokasi_id = b.lokasi_id
				LEFT JOIN guru_matpel d
					ON d.guru_id = a.guru_id
				LEFT JOIN matpel e
					ON e.matpel_id = d.matpel_id
				LEFT JOIN jenjang_pendidikan h
					ON h.jenjang_pendidikan_id = e.jenjang_pendidikan_id
				LEFT JOIN source_info f
					ON f.source_info_id = a.source_info_id
				LEFT JOIN pendidikan g
					ON g.pendidikan_id = a.pendidikan_id
			WHERE 1
				AND a.guru_active = 1
			GROUP BY a.guru_id";
			$gurus = $this->db->query($query)->result_array();
			foreach($gurus AS &$guru) {
				$guru['rating'] = $this->get_calculated_rating($guru['id']);
			}
			set_cache($key, $gurus);
		}
		return $gurus;
	}
	public function get_kelas_for_csv() {
		$key = 'kelas_csv';
		$query = "
		SELECT
			a.kelas_id,
			a.request_id,
			b.guru_id,
			b.guru_nama,
			b.guru_email,
			c.murid_id,
			c.murid_nama,
			c.murid_email,
			CONCAT(d.matpel_title,' - ', e.jenjang_pendidikan_title) AS matpel,
			CONCAT(f.lokasi_title, ' - ', g.provinsi_title) AS lokasi,
			a.kelas_frekuensi,
			a.kelas_durasi,
			a.kelas_total_jam,
			a.kelas_harga as harga_per_jam,
			a.kelas_total_harga as total_harga,
			a.kelas_pembayaran_murid,
			a.kelas_feedback_status
		FROM
			kelas a
			LEFT JOIN guru b
				ON b.guru_id = a.guru_id
			LEFT JOIN murid c
				ON c.murid_id = a.murid_id
			LEFT JOIN matpel d
				ON d.matpel_id = a.matpel_id
			LEFT JOIN jenjang_pendidikan e 
				ON e.jenjang_pendidikan_id = d.jenjang_pendidikan_id 
			LEFT JOIN lokasi f 
				ON f.lokasi_id = a.lokasi_id
			LEFT JOIN provinsi g 
				ON g.provinsi_id = f.provinsi_id";
		$gurus = $this->db->query($query)->result_array();
		return $gurus;
	}
	/*nebeng!*/
	public function get_murid_for_csv($force_refresh = FALSE) {
		$key = 'murid_csv';
		if($force_refresh || ($gurus = get_cache($key))===FALSE ) {
			$query = "
			SELECT
				a.murid_id AS id,
				a.murid_nama AS nama,
				a.murid_email AS email,
				a.murid_alamat AS alamat,
				a.murid_alamat_domisili AS domisili,
				c.lokasi_title AS lokasi,
				a.murid_lahir AS lahir,
				IF(a.murid_gender=1,'pria','wanita') AS gender ,
				f.source_info_title AS source_info,
				a.murid_daftar AS tanggal_daftar,
				a.murid_call_status AS call_status,
				a.murid_call_progress AS call_progress,
				a.murid_handle_by AS handle_by
			FROM
				murid a
				LEFT JOIN lokasi c 
					ON c.lokasi_id = a.murid_kota
				LEFT JOIN source_info f
					ON f.source_info_id = a.source_info_id
			WHERE 1
				AND a.murid_active = 1
			GROUP BY a.murid_id";
			$gurus = $this->db->query($query)->result_array();
			set_cache($key, $gurus);
		}
		return $gurus;
	}
	
	public function kualifikasi_check() {
		$query = "
		SELECT
			*
		FROM
			guru_kualifikasi
		WHERE sertifikat IS NOT NULL
		";
		$result = $this->db->query($query)->result();
		$data = array();
		foreach($result as $row) {
			$data[$row->guru_id][$row->sertifikat] = array('text'=>$row->kualifikasi,'id'=>$row->id);
		}
		return $data;
	}
	
	public function update_kualifikasi($data, $id) {
		$this->db->update('guru_kualifikasi', $data, array('id'=>$id));
	}
	public function insert_kualifikasi_2($data) {
		$this->db->insert('guru_kualifikasi', $data);
		return $this->db->insert_id();
	}
	public function get_full_guru_rating($guru_id, $force_update = FALSE) {
		$key = 'guru_rating_total_'.$guru_id;
		if($force_update || ($data = $this->get_cache($key)) === FALSE) {
			$r1 = $this->get_calculated_rating($guru_id, $force_update);
			$r2 = $this->get_rating_by_feedback($guru_id, $force_update);
			$data = $r1 + $r2;
			$this->set_cache($key, $data);
		}
		return $data;
	}
    
}
