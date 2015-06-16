<?php

class Main_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function get_table($name){
        return $this->db->get($name);
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
    
    function get_location_full_list() {
		$provinsi = $this->get_provinsi_list();
		$data = array();
		foreach($provinsi as $prov) {
			$loc = $this->get_lokasi($prov->provinsi_id)->result();
			$dt = array(
				'id'		=>(int)$prov->provinsi_id,
				'title'		=>$prov->provinsi_title,
				'data'		=>array()
			);
			foreach($loc as $locc) {
				$dt['data'][] = array(
					'id'		=>(int)$locc->lokasi_id,
					'title'		=>$locc->lokasi_title,
				);
			}
			$data[$prov->provinsi_id] = $dt;
		}
		return $data;
	}
	
	function get_provinsi_list() {
		return $this->db->get('provinsi')->result();
	}
	
	function get_provinsi_name($provinsi_id) {
		return $this->db->where('provinsi_id',$provinsi_id)->get('provinsi')->row()->provinsi_title;
	}
    
	function get_lokasi_name($lokasi_id) {
		return $this->db->where('lokasi_id',$lokasi_id)->get('lokasi')->row()->lokasi_title;
	}

    function get_provinsi(){
        $query = $this->db->query("SELECT * FROM provinsi ORDER BY provinsi_id ASC");
        return $query->result_array();
    }
    
    function get_lokasi($prov_id){
        $this->db->order_by('lokasi_title','asc');
        $this->db->where('provinsi_id',$prov_id);
        return $this->db->get('lokasi');
    }
    
    function get_request_guru($id=null){
        $this->db->join('lokasi','request_guru_home.lokasi_id = lokasi.lokasi_id','left outer');
        $this->db->limit(6);
        $this->db->order_by('request_guru_home_date','desc');
        //$this->db->where('request_guru_home_active',1);
        if(!empty($id)){
            $this->db->where('request_guru_home_id',$id);
        }
        return $this->db->get('request_guru_home');
    }
    function get_all_request_guru(){
        $this->db->join('lokasi','request_guru_home.lokasi_id = lokasi.lokasi_id','left outer');
        $this->db->order_by('request_guru_home_id','desc');
        //$this->db->where('request_guru_home_active',1);
        return $this->db->get('request_guru_home');
    }
    
     function get_request_guru_by_limit($limit){
        $this->db->join('lokasi','request_guru_home.lokasi_id = lokasi.lokasi_id','left outer');
        $this->db->order_by('request_guru_home_date','desc');
        //$this->db->where('request_guru_home_active',1);
        return $this->db->get('request_guru_home', 5, $limit);
    }
    
     function get_request_guru_by_id($id){
        $this->db->join('lokasi','request_guru_home.lokasi_id = lokasi.lokasi_id','left outer');
        $this->db->where('request_guru_home_id',$id);
	   $result = $this->db->get('request_guru_home');
        return $result->first_row();
    }
    
     function set_vacancy_request_guru_home($request_guru_id, $guru_id){
        $this->db->set('guru_id',$guru_id);
        $this->db->set('guru_request_home_id',$request_guru_id);
        $this->db->insert('guru_lamaran');
	   return $this->db->insert_id();
    }
    
     function get_vacancy_request_guru_home($guru_id){
		$this->db->where('guru_id',$guru_id);
	   return $this->db->get('guru_lamaran');
    }
    
     function get_vacancy_by_request($request_guru__home_id, $guru_id){
		$this->db->where('guru_request_home_id',$request_guru__home_id);
		$this->db->where('guru_id',$guru_id);
		$result = $this->db->get('guru_lamaran');
		return $result->first_row();
    }
    
    function get_tweet(){
        $_access_token = '49005834-3rJ1I9B9O2XS19rTJ13tkiYpeqYg89HRzB8MgvmvI';
        $_secret_access_token = '5EPjklOEcrgFUu4iTAvurqsL1r7CMBoDz5L8AeJY1E';
        $this->tweet->enable_debug(TRUE);
        $tokens = array('oauth_token' => $_access_token, 'oauth_token_secret' => $_secret_access_token);
        $this->tweet->set_tokens($tokens);
        $options = array('count' => 5,'screen_name'=>'ruangguru');
        return $this->tweet->call('get', 'statuses/user_timeline',$options);
    }
    
    function get_blog_post(){
        $this->db->where('post_status','publish');
        $this->db->where('post_type','post');
        $this->db->limit(5);
        $result = $this->db->get('wp_posts');
        $blog_post = array();
        $idx = 0;
        //get image for each content
        foreach ($result->result() as $post) {
            $blog_post[$idx]['content'] = $post;
            $this->db->flush_cache();
            $this->db->where('post_status','inherit');
            $this->db->where('post_type', 'attachment');
            $this->db->where('post_parent', $post->ID);
            $image = $this->db->get('wp_posts');
            //if have image in content
            if($image->num_rows() > 0){
                $image = $image->first_row();
                $blog_post[$idx]['image'] = $image;
                $thumb_year=date("Y",strtotime($image->post_date));
                $thumb_month = date("m", strtotime($image->post_date));
                $thumb_ext = substr($image->guid, strlen($image->guid) - 3, 3);
                $thumb_name = $image->post_name;
                $file_name = $thumb_name.".".$thumb_ext;
                $blog_post[$idx]['image']->file_name = $file_name;
                //create thumbnail if not exist
                if(!file_exists("./images/blog/".$file_name)){
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = "./blog/wp-content/uploads/{$thumb_year}/{$thumb_month}/{$thumb_name}-150x150.{$thumb_ext}";
                    $config['new_image'] = "./images/blog/".$file_name;
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 55;
                    $config['height'] = 55;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                }
            }else{
                $blog_post[$idx]['image'] = null;
            }
            $idx++;
        }
        return $blog_post;
    }
    
     public function delete_lamaran_request_by_guru($id, $id_guru){
        $this->db->where('guru_request_home_id',$id);
        $this->db->where('guru_id',$id_guru);
        $this->db->delete('guru_lamaran');
    }
    
     public function insert_subscribers($input){
        $this->db->set('subscriber_nama',$input['nama']);
        $this->db->set('subscriber_email',$input['email']);
        $this->db->insert('subscribe');
    }
    
     public function get_subscribers($email){
        $this->db->where('subscriber_email',$email);
        $result = $this->db->get('subscribe');
        return $result->first_row();
    }
    
    /* POSTS */
    public function get_posts(){
		return $this->db->get('blog');
    }
    
     public function add_post($input){
        $this->db->set('blog_title',$input['title']);
        $this->db->set('blog_content',$input['konten']);
        $this->db->set('blog_image',$input['file']);
        $this->db->set('blog_status',$input['status']);
        $this->db->insert('blog');
    }
    
     public function get_posts_by_id($id){
		$this->db->where('blog_id',$id);
		return $this->db->get('blog')->first_row();
    }
    
     public function delete_post($id){
        $this->db->where('blog_id',$id);
        $this->db->delete('blog');
    }
    
     public function edit_post($input, $id){
        $this->db->set('blog_title',$input['title']);
        $this->db->set('blog_content',$input['konten']);
        $this->db->set('blog_image',$input['file']);
        $this->db->set('blog_status',$input['status']);
        $this->db->where('blog_id',$id);
        $this->db->update('blog');
    }

    public function cari_provinsi_by_nama($nama_provinsi){
        $nama = str_replace("-", " ", $nama_provinsi);
        $query = $this->db->query("SELECT provinsi_id FROM provinsi WHERE provinsi_title LIKE '%$nama%' LIMIT 1");
        $result = $query->result_array();
        if(sizeof($result)>0){
            return $result[0]['provinsi_id'];
        } else {
            return 0;
        }
    }

    public function cari_kota_by_nama($nama_kota){
        $nama = str_replace("-", " ", $nama_kota);
        $query = $this->db->query("SELECT lokasi_id FROM lokasi WHERE lokasi_title LIKE '%$nama%' LIMIT 1");
        $result = $query->result_array();
        if(sizeof($result)>0){
            return $result[0]['lokasi_id'];
        } else {
            return 0;
        }
    }
    
    public function cari_matpel_by_nama($matpel){
        $nama = preg_replace("/[^\da-z]/i", " ", $matpel);
        $matpel = explode(" ", $nama);
        $where = "";
        foreach($matpel as $m){
            if(strlen($m)>0){
                if(strlen($where)>0){
                    $where .= " AND matpel_title LIKE '%$m%' ";
                } else {
                    $where = " matpel_title LIKE '%$m%' ";
                }
            }
        }

        $query = $this->db->query("SELECT matpel_id,jenjang_pendidikan_id FROM matpel WHERE $where ");
        $result = $query->result_array();
        if(sizeof($result)>0){
            return $result;
        } else {
            return null;
        }
    }

    public function cari_matpel_by_nama_dan_kategori($jenjang,$matpel){
        $nama = preg_replace("/[^\da-z]/i", " ", $matpel);
        $matpel = explode(" ", $nama);
        $where = "";
        foreach($matpel as $m){
            if(strlen($where)>0){
                $where .= " AND matpel_title LIKE '%$m%' ";
            } else {
                $where = " matpel_title LIKE '%$m%' ";
            }
        }

        $query = $this->db->query("SELECT matpel_id,jenjang_pendidikan_id FROM matpel WHERE $where AND jenjang_pendidikan_id=$jenjang");
        $result = $query->result_array();
        if(sizeof($result)>0){
            return $result[0]['matpel_id'];
        } else {
            return 0;
        }
    }

    public function cari_jenjang_by_nama($jenjang){
        $nama = preg_replace("/[^\da-z]/i", " ", $jenjang);
        $matpel = explode(" ", $nama);
        $where = "";
        foreach($matpel as $m){
            if(strlen($where)>0){
                $where .= " AND jenjang_pendidikan_title LIKE '%$m%' ";
            } else {
                $where = " jenjang_pendidikan_title LIKE '%$m%' ";
            }
        }

        $query = $this->db->query("SELECT jenjang_pendidikan_id FROM jenjang_pendidikan WHERE $where");
        $result = $query->result_array();
        if(sizeof($result)>0){
            return $result[0]['jenjang_pendidikan_id'];
        } else {
            return 0;
        }
    }
}