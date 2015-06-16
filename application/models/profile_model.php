<?php

class Profile_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function check_guru($email,$id,$password){
        if(!empty($email)){
            $this->db->where('guru_email',$email);
        }
        if(!empty($id)){
            $this->db->where('guru_id',$id);
        }
        if(!empty($password)){
            $this->db->where('guru_password',md5($password));
        }
        $this->db->select('guru_id');
        $result = $this->db->get('guru');
        if($result->num_rows > 0 ){
            return true;
        }else{
            return false;
        }
    }

    /*THIS PART IS NEW*/

    public function clear_history_pendidikan($id){
        $this->db->query("DELETE FROM guru_history_pendidikan WHERE guru_id=$id");
    }

    public function add_history_pendidikan($id,$pendidikan,$instansi,$isverified=0){
        $this->db->query("INSERT INTO guru_history_pendidikan(guru_id,pendidikan_id,instansi,isverified) VALUES($id,$pendidikan,'$instansi',$isverified)");
    }

    public function get_history_pendidikan($id){
        $query = $this->db->query("SELECT ghp.*,p.pendidikan_title
                                    FROM guru_history_pendidikan as ghp
                                    LEFT JOIN pendidikan as p on ghp.pendidikan_id=p.pendidikan_id
                                    WHERE guru_id=$id");
        return $query->result_array();
    }

    public function get_pendidikan_terakhir($id){
        $query = $this->db->query("SELECT ghp.*,p.pendidikan_title
                                    FROM guru_history_pendidikan as ghp
                                    LEFT JOIN pendidikan as p on ghp.pendidikan_id=p.pendidikan_id
                                    WHERE ghp.guru_id=$id
                                    ORDER BY p.index DESC
                                    LIMIT 1");
        $result = $query->result_array();
        if(sizeof($result)>0){
            $hasil = $result[0];
            $pendidikan = "";
            $pendidikan .= $hasil['pendidikan_title']." - ".$hasil['instansi'];

            return $pendidikan;
        } else {
            return null;
        }
    }

    public function get_pendidikan_saat_ini($id){
        $query = $this->db->query("SELECT ghp.*,p.pendidikan_title
                                    FROM guru_history_pendidikan as ghp
                                    LEFT JOIN pendidikan as p on ghp.pendidikan_id=p.pendidikan_id
                                    WHERE ghp.guru_id=$id
                                    ORDER BY p.index DESC
                                    LIMIT 1");

        $result = $query->result_array();
        if(sizeof($result)>0){
            $hasil = $result[0];
            $pendidikan = "";
            $pendidikan .= $hasil['pendidikan_title']." - ".$hasil['guru_pendidikan_instansi'];

            return $pendidikan;
        } else {
            return null;
        }
    }

    public function get_jenjang($id){
        $query = $this->db->query("SELECT jp.jenjang_pendidikan_id, jp.jenjang_pendidikan_title
                                        FROM guru_matpel as gm
                                        LEFT JOIN matpel as m ON m.matpel_id=gm.matpel_id
                                        LEFT JOIN jenjang_pendidikan as jp ON jp.jenjang_pendidikan_id=m.jenjang_pendidikan_id
                                    WHERE gm.guru_id=$id
                                    GROUP BY jp.jenjang_pendidikan_id
                                    ORDER BY jp.jenjang_pendidikan_index ASC");

        return $query->result_array();
    }

    public function get_tarif_guru($id,$matpel=null){
        $where = "";
        if($matpel != "" && $matpel != null && $matpel!=0){
            $where = " AND gm.matpel_id=$matpel ";
        }
        $query = $this->db->query("SELECT gm.matpel_id,gm.guru_matpel_tarif,m.matpel_title,jp.jenjang_pendidikan_title
                                    FROM guru_matpel as gm
                                    LEFT JOIN matpel as m ON m.matpel_id=gm.matpel_id
                                    LEFT JOIN jenjang_pendidikan as jp ON jp.jenjang_pendidikan_id=m.jenjang_pendidikan_id
                                    WHERE gm.guru_id=$id $where
                                    ORDER BY jp.jenjang_pendidikan_index ASC, m.matpel_title ASC");

        return $query->result_array();
    }

    public function get_tarif_guru_with_jenjang($id,$jenjang){
        $query = $this->db->query("SELECT gm.matpel_id,gm.guru_matpel_tarif,m.matpel_title,jp.jenjang_pendidikan_title
                                    FROM guru_matpel as gm
                                    LEFT JOIN matpel as m ON m.matpel_id=gm.matpel_id
                                    LEFT JOIN jenjang_pendidikan as jp ON jp.jenjang_pendidikan_id=m.jenjang_pendidikan_id
                                    WHERE gm.guru_id=$id AND m.jenjang_pendidikan_id=$jenjang
                                    ORDER BY m.matpel_title ASC");

        return $query->result_array();
    }

    public function get_tarif_matpel($id_guru,$id_matpel){
        $query = $this->db->query("SELECT gm.matpel_id,gm.guru_matpel_tarif,m.matpel_title,jp.jenjang_pendidikan_title
                                    FROM guru_matpel as gm
                                    LEFT JOIN matpel as m ON m.matpel_id=gm.matpel_id
                                    LEFT JOIN jenjang_pendidikan as jp ON jp.jenjang_pendidikan_id=m.jenjang_pendidikan_id
                                    WHERE gm.guru_id=$id_guru AND gm.matpel_id=$id_matpel");

        $result = $query->result_array();
        if(sizeof($result)>0) {
            return $result[0]['guru_matpel_tarif'];
        } else {
            return 0;
        }
    }

    public function get_tarif_subject($id_guru,$id_jenjang=null,$id_matpel=null){
        $where = "WHERE gm.guru_id=$id_guru";
        if($id_jenjang!=null && $id_jenjang!="" && $id_jenjang!=0){
            $where .= " AND m.jenjang_pendidikan_id=$id_jenjang";
        }
        if($id_matpel!=null && $id_matpel!="" && $id_matpel!=0){
            $where .= " AND m.matpel_id=$id_matpel";
        }
        $query = $this->db->query("SELECT MAX(gm.guru_matpel_tarif) as max_tarif, MIN(gm.guru_matpel_tarif) as min_tarif
                                    FROM guru_matpel as gm
                                    LEFT JOIN matpel as m ON gm.matpel_id=m.matpel_id
                                    LEFT JOIN jenjang_pendidikan as jp ON jp.jenjang_pendidikan_id=m.jenjang_pendidikan_id
                                    $where
                                    GROUP BY gm.guru_id");

        $result = $query->result_array();
        if(sizeof($result)>0){
            return $result[0];
        } else {
            return null;
        }
    }

    public function get_mk_teratas($id_guru,$id_jenjang=NULL,$id_matpel=NULL){
        $where = "WHERE gm.guru_id=$id_guru";
        if($id_jenjang!=null && $id_jenjang!="" && $id_jenjang!=0){
            $where .= " AND m.jenjang_pendidikan_id=$id_jenjang";
        }
        if($id_matpel!=null && $id_matpel!="" && $id_matpel!=0){
            $where .= " AND m.matpel_id=$id_matpel";
        }
        $query = $this->db->query("SELECT m.matpel_title, jp.jenjang_pendidikan_title, gm.guru_matpel_tarif
                                    FROM guru_matpel as gm
                                    LEFT JOIN matpel as m ON gm.matpel_id=m.matpel_id
                                    LEFT JOIN jenjang_pendidikan as jp ON jp.jenjang_pendidikan_id=m.jenjang_pendidikan_id
                                    $where
                                    GROUP BY m.matpel_id
                                    ORDER BY jp.jenjang_pendidikan_id DESC
                                    LIMIT 3");

        return $query->result_array();
    }

    public function get_total_mk($id_guru) {

        $query = $this->db->query("SELECT matpel_id
                                    FROM guru_matpel WHERE guru_id=$id_guru");

        return count($query->result_array());
    }

    public function get_jenjang_teratas($id_guru,$id_jenjang=NULL){
        $where = "WHERE gm.guru_id=$id_guru";
        if($id_jenjang!=null && $id_jenjang!="" && $id_jenjang!=0){
            $where .= " AND m.jenjang_pendidikan_id=$id_jenjang";
        }
        $query = $this->db->query("SELECT jp.jenjang_pendidikan_title
                                    FROM guru_matpel as gm
                                    LEFT JOIN matpel as m ON gm.matpel_id=m.matpel_id
                                    LEFT JOIN jenjang_pendidikan as jp ON jp.jenjang_pendidikan_id=m.jenjang_pendidikan_id
                                    $where
                                    GROUP BY jp.jenjang_pendidikan_id
                                    ORDER BY jp.jenjang_pendidikan_id DESC
                                    LIMIT 3");

        return $query->result_array();
    }

    public function get_koordinat_guru($id_guru){
        return null;
    }

    /*UNTIL THIS PART*/

    /*** PROFILE ***/
    function get_profile_guru($guru_id){
        $this->db->where('guru_id',$guru_id,TRUE);
        $this->db->join('kategori','guru.kategori_id=kategori.kategori_id','left');
        $this->db->join('pendidikan','guru.pendidikan_id=pendidikan.pendidikan_id','left');
        $rows = $this->db->get('guru');
        
        if($rows->num_rows() > 0 ){
            $result = $rows->first_row();
            $result->lokasi = $this->get_lokasi_mengajar($guru_id);
            $result->matpel = $this->get_mata_pelajaran($guru_id);
            $result->jadwal = $this->get_jadwal_map($guru_id);
            $result->tarif = $this->get_tarif_guru($guru_id);
            return $result;
        }else{
            return null;
        }
    }
    function get_lokasi_mengajar($guru_id){
        $result = "";
        $this->db->where('guru_id',$guru_id,TRUE);
        $this->db->join('lokasi','guru_lokasi.lokasi_id=lokasi.lokasi_id');
        $this->db->join('provinsi','lokasi.provinsi_id=provinsi.provinsi_id');
        $rows = $this->db->get('guru_lokasi');
        foreach($rows->result() as $row){
            $result .= $row->lokasi_title . ", ";
        }
        return substr($result, 0, strlen($result) -2);
    }
    function get_mata_pelajaran($guru_id){
        $this->db->where('guru_id',$guru_id,TRUE);
        $this->db->join('matpel','guru_matpel.matpel_id=matpel.matpel_id');
        $this->db->join('jenjang_pendidikan','matpel.jenjang_pendidikan_id = jenjang_pendidikan.jenjang_pendidikan_id');
        return $this->db->get('guru_matpel');
    }

    /*** BIODATA ***/
      function update_video($guru_id,$video,$jenis_video){
        $this->db->set('guru_video',$video);
        $this->db->set('guru_jenis_video',$jenis_video);
        $this->db->where('guru_id',$guru_id);
        $this->db->update('guru');
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }

    function update_pass($guru_id,$oldpass,$pass){
        $this->db->set('guru_password',md5($pass));
        $this->db->where('guru_password',md5($oldpass));
        $this->db->where('guru_id',$guru_id);
        $this->db->update('guru');
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }

    function update_biodata($id_guru,$input){
        if(!empty($input['nik_image']) && $input['nik_image'] != ""){
            $this->db->set('guru_nik_image',$input['nik_image']);
        }

        unset($input['nik_image']);
        $this->db->set('kategori_id',$input['kategori']);
        unset($input['ketegori']);
        $this->db->set('tagline',$input['tagline']);
        unset($input['tagline']);
        $this->db->set('pendidikan_id',$input['pendidikan_id']);
        unset($input['pendidikan_id']);
        $this->db->set('bank_id',$input['bank_id']);
        unset($input['bank_id']);
        $this->db->set('guru_bank_rekening',$input['nomor_rekening']);
        unset($input['nomor_rekening']);
        $this->db->set('guru_bank_pemilik',$input['nama_rekening']);
        unset($input['nama_rekening']);
        
        foreach ($input as $guru_input) {
            if(empty($guru_input)) continue;
            $key = 'guru_'.array_search($guru_input, $input);
            $this->db->set($key,$guru_input);
        }
/*
        $this->db->set('guru_nama',$input['nama']);
        $this->db->set('guru_gender',$input['gender']);
        $this->db->set('pendidikan_id',$input['pendidikan_id']);
        $this->db->set('guru_pendidikan_instansi',$input['pendidikan_instansi']);
        $this->db->set('guru_tempatlahir',$input['tempatlahir']);
        $this->db->set('guru_lahir',$input['lahir']);
        $this->db->set('guru_hp',$input['hp']);
        $this->db->set('guru_hp_2',$input['hp_2']);
        $this->db->set('guru_telp_rumah',$input['telp_rumah']);
        $this->db->set('guru_telp_kantor',$input['telp_kantor']);
        $this->db->set('guru_alamat',$input['alamat']);
        $this->db->set('guru_alamat_domisili',$input['alamat_domisili']);
        $this->db->set('kategori_id',$input['kategori']);
        $this->db->set('tagline',$input['tagline']);
        $this->db->set('guru_referral',$input['referral']);
        $this->db->set('bank_id',$input['bank_id']);
        $this->db->set('guru_bank_rekening',$input['nomor_rekening']);
        $this->db->set('guru_bank_pemilik',$input['nama_rekening']);
        $this->db->set('guru_nik',$input['nik']);
        $this->db->set('guru_npwp',$input['npwp']);
*/
        $this->db->where('guru_id',$id_guru);
        $this->db->update('guru');
    }

    function update_biodata_admin($id_guru,$input){
        $this->db->set('guru_nama',$input['nama']);
        $this->db->set('guru_gender',$input['gender']);
        $this->db->set('guru_hp',$input['hp']);
        $this->db->set('guru_hp_2',$input['hp_2']);
        $this->db->set('guru_telp_rumah',$input['telp_rumah']);
        $this->db->set('guru_telp_kantor',$input['telp_kantor']);
        $this->db->set('guru_tempatlahir',$input['tempatlahir']);
        $this->db->set('guru_nik',$input['nik']);
        $this->db->set('guru_lahir',$input['lahir']);
        $this->db->set('guru_alamat',$input['alamat']);
        $this->db->set('guru_alamat_domisili',$input['alamat_domisili']);
        $this->db->set('guru_referral',$input['referral']);
        $this->db->set('guru_fb',$input['fb']);
        $this->db->set('guru_twitter',$input['twitter']);
        $this->db->set('bank_id',$input['bank']);
        $this->db->set('guru_bank_rekening',$input['rekening']);
        $this->db->set('guru_bank_pemilik',$input['pemilik']);
        $this->db->set('guru_npwp',$input['npwp']);

        $this->db->where('guru_id',$id_guru);
        $this->db->update('guru');
    }

    function update_guru_sosmed($guru_id,$fb,$twitter){
        $this->db->query("UPDATE guru SET guru_fb='$fb',guru_twitter='$twitter' WHERE guru_id=$guru_id");
    }

    /*** PERSONAL MESSAGE/BIO ***/
    function update_pekerjaan($id, $pekerjaan){
        $this->db->query("UPDATE guru SET kategori_id = $pekerjaan WHERE guru_id=$id");
    }

    function update_bio_singkat($id,$bio_singkat){
        $this->db->query("UPDATE guru SET bio_singkat='$bio_singkat' WHERE guru_id=$id");
    }

    function update_personal($id_guru,$input){
    	   $total_bio = strlen($input);
	   if($total_bio <= 500){
		$this->db->set('guru_rating_bio',0);
	   }elseif($total_bio > 500 && $total_bio <= 1000){
		$this->db->set('guru_rating_bio',1);
	   }elseif($total_bio > 1000){
	   	$this->db->set('guru_rating_bio',2);
	   }
        $this->db->set('guru_bio',$input);
        $this->db->where('guru_id',$id_guru);
        $this->db->update('guru');

        //update rating
        $this->load->model('guru_model');
        $this->guru_model->update_current_rating($id_guru);
    }

    /*** PENGALAMAN MENGAJAR ***/
    function reset_guru_pengalaman($id){
        $this->db->query("DELETE FROM guru_pengalaman WHERE guru_id=$id");
    }

    function insert_guru_pengalaman($id_guru,$pengalaman){
        $this->db->query("INSERT INTO guru_pengalaman(guru_id,pengalaman) VALUES ($id_guru,'$pengalaman')");
    }

    function get_guru_pengalaman($id){
        $query = $this->db->query("SELECT * FROM guru_pengalaman WHERE guru_id=$id");
        return $query->result_array();
    }

    function update_pengalaman($id_guru,$input){
        $this->db->set('guru_pengalaman',$input);
        $this->db->where('guru_id',$id_guru);
        $this->db->update('guru');
    }

     /*** METODE MENGAJAR ***/
    function update_metode($input, $id_guru){
        $this->db->set('guru_metode',$input);
        $this->db->where('guru_id',$id_guru);
        $this->db->update('guru');
    }

    /*** MATA PELAJARAN ***/
    function get_matpel_count(){
        return $this->db->query("SELECT COUNT(matpel_id) AS count FROM matpel")->first_row()->count;
    }
    function get_map_matpel($guru_id){
        $this->db->where('guru_id',$guru_id);
        $result = $this->db->get('guru_matpel');
        $array = array($this->get_matpel_count());
        foreach($result->result() as $matpel){
            $array[$matpel->matpel_id] = true;
        }
        return $array;
    }
    function get_array_matpel($guru_id){
        $array = array();
        $this->db->where('guru_id',$guru_id);
        $result = $this->db->get('guru_matpel');
        if($result->num_rows() > 0){
            foreach($result->result() as $row){
                $array[] = $row->matpel_id;
            }
        }
        return $array;
    }
    function update_guru_matpel($guru_id,$input){
        $current_matpel = $this->get_array_matpel($guru_id);
        $del_matpel = array_diff($current_matpel, $input);
        $ins_matpel = array_diff($input, $current_matpel);
        //deleteing matpel
        $this->delete_guru_matpel($guru_id,$del_matpel);
        //inserting matpel
        foreach($ins_matpel as $value) {
            $this->db->set('matpel_id', $value);
            $this->db->set('guru_id', $guru_id);
            $this->db->insert('guru_matpel');
        }
        return (count($ins_matpel)>0)?true:false;
    }
    function delete_guru_matpel($guru_id,$arr_matpel){
        if(!empty($arr_matpel)){
            $this->db->where_in('matpel_id',$arr_matpel);
            $this->db->where('guru_id',$guru_id);
            $this->db->delete('guru_matpel');
        }
    }

    function reset_guru_matpel($id){
        $this->db->query("DELETE FROM guru_matpel WHERE guru_id=$id");
    }

    function add_guru_matpel($guru_id,$matpel,$tarif){
        $this->db->set('guru_id',$guru_id,true);
        $this->db->set('matpel_id',$matpel,true);
        $this->db->set('guru_matpel_tarif',$tarif,true);
        $this->db->insert('guru_matpel');
    }

    function get_list_matpel($guru_id){
        $this->db->join('matpel','matpel.matpel_id = guru_matpel.matpel_id');
        $this->db->join('jenjang_pendidikan','jenjang_pendidikan.jenjang_pendidikan_id = matpel.jenjang_pendidikan_id');
        $this->db->where('guru_id',$guru_id);
        $result = $this->db->get('guru_matpel');
        return $result->result();
    }

    function get_matpel($pend_id,$guru_id=null){
        $this->db->select('guru_matpel.guru_matpel_tarif');
        $this->db->select('matpel.*');
        if(!empty($guru_id)){
            $this->db->join('guru_matpel','guru_matpel.matpel_id=matpel.matpel_id and guru_matpel.guru_id='.$guru_id,'left');
            $this->db->where('guru_matpel.matpel_id',null);
        }
        $this->db->where('jenjang_pendidikan_id',$pend_id);
        return $this->db->get('matpel');
    }

    /*** TARIF MATA PELAJARAN ***/
    function update_tarif($guru_id,$matpel_id,$tarif){
        $this->db->query("UPDATE guru_matpel SET guru_matpel_tarif=$tarif WHERE guru_id=$guru_id AND matpel_id=$matpel_id");
    }

    function update_guru_tarif($guru_id,$input){
        foreach($input as $key => $value) {
            $this->db->set('guru_matpel_tarif', $value);
            $this->db->where('matpel_id', $key);
            $this->db->where('guru_id', $guru_id);
            $this->db->update('guru_matpel');
        }
    }

    /*** LOKASI ***/
    function get_lokasi_count(){
        return $this->db->query("SELECT COUNT(lokasi_id) AS count FROM lokasi")->first_row()->count;
    }
    function get_array_lokasi($guru_id){
        $this->db->where('guru_id',$guru_id);
        $result = $this->db->get('guru_lokasi');
        $array = array();
        foreach($result->result() as $lokasi){
            $array[$lokasi->lokasi_id] = true;
        }
        return $array;
    }
    function update_guru_lokasi($guru_id,$input){
        $this->delete_guru_lokasi($guru_id);
        foreach($input as $value) {
            $this->db->set('lokasi_id', $value);
            $this->db->set('guru_id', $guru_id);
            $this->db->insert('guru_lokasi');
        }
    }
    function delete_guru_lokasi($guru_id){
        $this->db->where('guru_id',$guru_id);
        $this->db->delete('guru_lokasi');
    }

    /*** JADWAL ***/
    function get_jadwal_map($guru_id){
        $this->db->where('guru_id',$guru_id);
        $result = $this->db->get('guru_jadwal');
        $array = array();
        foreach($result->result() as $value){
            $array[$value->guru_jadwal_day][$value->guru_jadwal_hour] = true;
        }
        return $array;
    }

    function update_guru_jadwal($guru_id,$input){
        $this->delete_guru_jadwal($guru_id);
        foreach($input as $day => $arr_hour){
            foreach($arr_hour as $hour => $value){
                $this->db->set('guru_id',$guru_id);
                $this->db->set('guru_jadwal_day',$day);
                $this->db->set('guru_jadwal_hour',$hour);
                $this->db->insert('guru_jadwal');
            }
        }
    }
    function delete_guru_jadwal($guru_id){
        $this->db->where('guru_id',$guru_id);
        $this->db->delete('guru_jadwal');
    }

    /*** KUALIFIKASI ***/
    function get_kualifikasi($guru_id){
        $this->db->select('guru_kualifikasi');
        $this->db->where('guru_id',$guru_id);
        $result = $this->db->get('guru');
        if($result->num_rows()>0){
            return $result->first_row();
        }else{
            return null;
        }
    }

    function get_guru_kualifikasi($id){
        $query = $this->db->query("SELECT * FROM guru_kualifikasi WHERE guru_id=$id");
        return $query->result_array();
    }

    function get_sertifikat($guru_id){
        $this->db->where('guru_id',$guru_id);
        $result = $this->db->get('guru_sertifikat');
        return $result;
    }

    function reset_guru_kualifikasi($guru_id){
        $this->db->query("DELETE FROM guru_kualifikasi WHERE guru_id=$guru_id");
    }

    function insert_guru_kualifikasi($guru_id,$kualifikasi){
        $this->db->query("INSERT INTO guru_kualifikasi(guru_id,kualifikasi) VALUES ($guru_id,'$kualifikasi')");
        return $this->db->insert_id();
    }

    function update_guru_kualifikasi($id,$kualifikasi){
        $this->db->query("UPDATE guru_kualifikasi SET kualifikasi='$kualifikasi' WHERE id=$id");
    }

    function update_file_guru_kualifikasi($kualifikasi_id,$file){
        $this->db->query("UPDATE guru_kualifikasi SET sertifikat='$file' WHERE id=$kualifikasi_id");
    }

    function insert_guru_sertifikat($guru_id,$input){
        $this->db->set('guru_sertifikat_title',$input['title']);
        $this->db->set('guru_sertifikat_file',$input['file']);
        $this->db->set('guru_id',$guru_id);
        $this->db->insert('guru_sertifikat');
    }

    function delete_guru_sertifikat_file($guru_id,$sertifikat_id){
        $this->db->where('guru_id',$guru_id);
        $this->db->where('id',$sertifikat_id);
        $result = $this->db->get('guru_kualifikasi');
        if($result->num_rows()>0){
            $file = $result->first_row();
            if(strlen($file->sertifikat)>0 && file_exists('./files/sertifikat/'.$file->sertifikat)) {
                unlink('./files/sertifikat/'.$file->sertifikat);
            }
        }
    }

    function delete_guru_sertifikat($guru_id,$sertifikat_id){
        $this->delete_guru_sertifikat_file($guru_id,$sertifikat_id);
        $this->db->where('guru_id',$guru_id);
        $this->db->where('id',$sertifikat_id);
        $this->db->delete('guru_kualifikasi');
    }

    /*** UPDATE ***/
    function update_guru($guru_id,$input){
        if(!empty($input['kualifikasi'])){
            $this->db->set('guru_kualifikasi',$input['kualifikasi']);
        }
        if(!empty($input['pengalaman'])){
            $this->db->set('guru_pengalaman',$input['pengalaman']);
        }
        if(!empty($input['personal_message'])){
            $this->db->set('guru_bio',$input['personal_message']);
        }
        $this->db->where('guru_id',$guru_id);
        $this->db->update('guru');
    }

    /*** BANK ***/
    function get_guru_bank_by_id($id){
        $this->db->select('bank.*');
        $this->db->select('guru.guru_bank_rekening');
        $this->db->select('guru.guru_bank_pemilik');
        $this->db->join('bank','guru.bank_id=bank.bank_id');
        $this->db->where('guru_id',$id);
        return $this->db->get('guru')->first_row();
    }

    function get_bank(){
        return $this->db->get('bank');
    }

    function update_bank($id,$input){
        $this->db->set('bank_id',$input['bank']);
        $this->db->set('guru_bank_rekening',$input['rekening']);
        $this->db->set('guru_bank_pemilik',$input['pemilik']);
        $this->db->where('guru_id',$id);
        $this->db->update('guru');
    }

    function get_guru_feedback($id){
        $query = $this->db->query("SELECT kf.*,fa.*,fq.*,k.kelas_testimoni,k.kelas_status,k.kelas_total_jam,k.kelas_mulai,
                                            m.murid_nama,mp.matpel_title,ki.total_jam,avg(feedback_answer_sort) as scores
                                      FROM kelas_feedback as kf
                                      LEFT JOIN feedback_answer as fa ON kf.feedback_answer_id=fa.feedback_answer_id
                                      LEFT JOIN feedback_question as fq ON fa.feedback_question_id=fq.feedback_question_id
                                      LEFT JOIN kelas as k ON k.kelas_id = kf.kelas_id
                                      LEFT JOIN murid as m ON m.murid_id = k.murid_id
                                      LEFT JOIN matpel as mp ON k.matpel_id=mp.matpel_id
                                      LEFT JOIN kelas_invoice as ki ON k.kelas_id=ki.kelas_id
                                      WHERE k.guru_id=$id
                                      GROUP BY k.kelas_id
                                      ORDER BY k.kelas_mulai DESC");
        return $query->result_array();
    }

    function review_guru($id){
        $query = $this->db->query("SELECT k.guru_id,k.murid_id,m.murid_nama,m.murid_gender,
                                        format(avg(fa.feedback_answer_sort),2) as feedback_score,
                                        k.kelas_testimoni,mp.matpel_title
                                    FROM kelas_feedback as kf
                                    LEFT JOIN feedback_answer as fa ON kf.feedback_answer_id=fa.feedback_answer_id
                                    LEFT JOIN kelas as k ON k.kelas_id = kf.kelas_id
                                    LEFT JOIN murid as m ON m.murid_id = k.murid_id
                                    LEFT JOIN matpel as mp ON mp.matpel_id=k.matpel_id
                                    WHERE k.guru_id=$id
                                    GROUP BY k.kelas_id
                                    ORDER BY k.kelas_mulai DESC");

        $result = $query->result_array();

        for($i=0; $i<sizeof($result); $i++) {
            $nama_panjang = $result[$i]['murid_nama'];
            $chunk = explode(" ", $nama_panjang);
            if(count($chunk) >= 2){
                $nama_baru = $chunk[0];
                for($j=1; $j<sizeof($chunk); $j++){
                    if($chunk[$j]!=""){
                        $nama_baru .= " ".$chunk[$j][0].".";
                        break;
                    }
                }
            }else{
                $nama_baru = $nama_panjang;
            }
            $result[$i]['murid_nama'] = $nama_baru;
        }

        return $result;
    }

    public function get_profile_percentage($id){
        $query = $this->db->query("SELECT * FROM guru WHERE guru_id=$id");
        $private_bio = $query->result_array();
        $sum = 0;
        $count = 0;
        foreach($private_bio as $bio){
            if($bio['guru_email']!=null && $bio['guru_email']!="") $count++; $sum++;
            if($bio['guru_nama']!=null && $bio['guru_nama']!="") $count++; $sum++;
            if($bio['guru_gender']!=null && $bio['guru_gender']!=0) $count++; $sum++;
            if($bio['guru_tempatlahir']!=null && $bio['guru_tempatlahir']!="") $count++; $sum++;
            if($bio['guru_lahir']!=null && $bio['guru_lahir']!="0000-00-00" && $bio['guru_lahir']!="") $count++; $sum++;
            if($bio['guru_hp']!=null && $bio['guru_hp']!="") $count++; $sum++;
            if($bio['guru_hp_2']!=null && $bio['guru_hp_2']!="") $count++; $sum++;
            if($bio['guru_telp_rumah']!=null && $bio['guru_telp_rumah']!="") $count++; $sum++;
            if($bio['guru_telp_kantor']!=null && $bio['guru_telp_kantor']!="") $count++; $sum++;
            if($bio['guru_alamat']!=null && $bio['guru_alamat']!="") $count++; $sum++;
            if($bio['guru_alamat_domisili']!=null && $bio['guru_alamat_domisili']!="") $count++; $sum++;
            if($bio['guru_fb']!=null && $bio['guru_fb']!="") $count++; $sum++;
            if($bio['guru_twitter']!=null && $bio['guru_twitter']!="") $count++; $sum++;
            if($bio['guru_bio']!=null && $bio['guru_bio']!="") $count++; $sum++;
            if($bio['guru_pengalaman']!=null && $bio['guru_pengalaman']!="") $count++; $sum++;

            $query = $this->db->query("SELECT * FROM guru_history_pendidikan WHERE guru_id=$id");
            if(sizeof($query->result_array())>0) $count++; $sum++;

            $query = $this->db->query("SELECT * FROM guru_kualifikasi WHERE guru_id=$id");
            if(sizeof($query->result_array())>0) $count++; $sum++;

            $query = $this->db->query("SELECT * FROM guru_lokasi WHERE guru_id=$id");
            if(sizeof($query->result_array())>0) $count++; $sum++;

            $query = $this->db->query("SELECT * FROM guru_matpel WHERE guru_id=$id");
            if(sizeof($query->result_array())>0) $count++; $sum++;

            break;
        }

        return round(($count/$sum)*100);
    }

    public function delete_sertifikat($id){
        $this->db->query("DELETE FROM guru_kualifikasi WHERE id=$id");
    }
    
    public function update_file_npwp_guru($id,$file,$verified=0){
        $tgl = date('Y-m-d H:i:s');
        $this->db->query("UPDATE guru SET guru_npwp_image='$file', guru_npwp_verified=$verified, guru_npwp_update='$tgl' WHERE guru_id=$id");
    }
    
    public function update_file_ket_pajak_guru($id,$file,$verified=0){
        $tgl = date('Y-m-d H:i:s');
        $this->db->query("UPDATE guru SET guru_ket_pajak_image='$file', guru_ket_pajak_verified=$verified, 
                            guru_ket_pajak_updated='$tgl' WHERE guru_id=$id");
    }
    
    public function update_file_nik_guru($id,$file,$verified=0){
        $tgl = date('Y-m-d H:i:s');
        $this->db->query("UPDATE guru SET guru_nik_image='$file', guru_nik_verified=$verified, 
                            guru_nik_image_modified='$tgl' WHERE guru_id=$id");
    }
}
