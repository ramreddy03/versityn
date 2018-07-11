<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Name: ShareController
* Author : Ram 
* Version : 1.0 
*/

class ShareController extends CI_Controller {

	public function __construct()
	{
			parent::__construct();
			$this->load->database();
			$this->baseurl = $this->config->item('base_url'); #base url path
			$this->sessiondata = $this->session->userdata('prtsesdata');
      		if($this->sessiondata['logged_in'] != 1){ ## Login Checking
      			 redirect('/login/index');
      		}
	}

	//Save the Shared Post as a new post with shared label
	public function newShare()
	{ 
		$post_id = ($this->input->post('selected_post_data_2', TRUE)) / MULTIPLIER;
		$shared_post_text = $this->input->post('selected_post_data_1', TRUE);
		$data = $this->replicatePost($post_id, $shared_post_text);
		echo $data;
	}
	//Replicate Post data and save as a new post data
	public function replicatePost($post_id, $shared_post_text)
	{
		$qry = $this->db->get_where('studentspost_docs', array('id' => $post_id));
		if($qry->num_rows() > 0){
			$qry = $qry->row();
			$qry->post_type = 'Shared';
			$qry->shared_post_text = $shared_post_text;
			$qry->liked_ids = '';
			$update_parent_share_counter = $qry->share_counter + 1;
			$qry->share_counter = 0;
			$qry->adddate =  date('Y-m-d H:i:s');
			$files = $qry->randname;
			if(!empty($files)){
				$renamed = $this->copyFiles($files, $qry->studentid);
				if($renamed != 'failed'){
					$qry->randname = $renamed;
				}
			}
			unset($qry->id);
			$qry->studentid = $this->sessiondata['userid'];
			if($this->db->insert('studentspost_docs', $qry)){
			$update = $this->db->set('share_counter', $update_parent_share_counter);
			$update = 	$this->db->where('id', $post_id);
			$update = 	$this->db->update('studentspost_docs');
				return 'success';
			} else { return "failed"; }
		}
	 else
	    { return "failed"; }
	}

	//Copy existing files to same / another folder
	public function copyFiles($files, $std_id)
	{
		if(!empty($files)){
			$files_arr = explode(",", $files);
			foreach ($files_arr as $image) {
				$uploads_dir = 'uploads';
				//old file data
				$old_folder = $this->studentUserName($std_id); 
				$old_upload_path = './'.$uploads_dir.'/'.$old_folder.'/';
				$old_file =  $old_upload_path.$image;
				$ext = pathinfo($old_file, PATHINFO_EXTENSION);                
				//new file
				$foldername = $this->sessiondata['username'];
				$uploadpath = './'.$uploads_dir.'/'.$foldername.'/';
				//Check directory available or not. if not create one with 0777 permissions 
				if (!file_exists($uploadpath)) {
					mkdir($uploadpath, 0777, TRUE);
				}
				$newfile_name = $this->sessiondata['username'].(rand());
				$newfile = $uploadpath.md5($newfile_name).".".$ext;
				if (!copy($old_file, $newfile)) {
					return 'failed';					
				} else {
					$newfile_arr[] = md5($newfile_name).".".$ext;
				}
			}
			return implode(',', $newfile_arr);
			
		}
	}
	//Get Username based on student Id
 	public function studentUserName($id)
	{
		$qry = $this->db->get_where('students', array('id' => $id));
		$qry = $qry->row();
		return $qry->username;
	}


} /* End of ShareController Class*/