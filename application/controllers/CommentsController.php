<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Name: CommentsController
* Author : Ram 
* Version : 1.0 
*/

class CommentsController extends CI_Controller {


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

//DB Fields: `post_id`, `user_id`, `comment`, `created_at`, `updated_at`
	public function newComment()
	{
		$post_id = ($this->input->post('selected_post_data_1', TRUE)) / MULTIPLIER;
		$comment = $this->input->post('selected_post_data_2', TRUE);

		$data = array(
		        'post_id' => $post_id ,
		        'user_id' => $this->sessiondata['userid'] ,
		        'comment' => $comment,
		        'created_at' => date('Y-m-d H:i:s'),
		        'updated_at' =>  date('Y-m-d H:i:s')
			);
		if($this->db->insert('post_comments', $data)){
			$arr = $this->getComments($post_id);
			$arr['status'] = 'success';
			echo json_encode($arr);
		}

	}

	public function getComments($id)
	{
		$qry = $this->db->get_where('post_comments', array('post_id' => $id));
		if($qry->num_rows > 0 ){
			foreach ($qry->result() as $value) {
			$htm_array .= "<div><label>".$this->studentname($value->user_id)."</label>: ".$value->comment."</div>";
			}
			return array('comments' => $htm_array, 'count'=> $qry->num_rows());
		} else {
			$htm_array = "<label>No Comments Available. Be the First One To Post a Comment</label>";
			return array('comments' => $htm_array, 'count'=> $qry->num_rows());
		}
		
	}

	public function loadComments()
	{
		$post_id = ($this->input->post('selected_post_data_1', TRUE)) / MULTIPLIER;
		if(!empty($post_id)){
			$arr = $this->getComments($post_id);
			$arr['status'] = 'success';
			echo json_encode($arr);
		}
	}

	public function studentname($id)
	{
		$qry = $this->db->get_where('students', array('id' => $id));
		$qry = $qry->row();
		return ucwords($qry->firstname." ".$qry->lastname);
	}
	/**
	*
	*/
	public function deletePost()
	{
		$post_id = ($this->input->post('selected_post_data_1', TRUE)) / MULTIPLIER;
		$std_id = $this->sessiondata['userid'];

		//delete all files related to this post
		$qry = $this->db->get_where('studentspost_docs', array('id' => $post_id, 'studentid' => $std_id));
		if ($qry->num_rows()) {				
			$qry = $qry->row();
			if(!empty($qry->randname)){
				$delete_files = $this->deleteFiles($qry->randname);
			} else {
				$delete_files = 'success';
			}
			log_message("info", "delete_files".$delete_files);
			//Delete Post data posted by student
			if($delete_files === 'success'){
				$del_qry = $this->db->delete('studentspost_docs', array('id' => $post_id));
				if($del_qry) {
					//Delete all Comments realted to this post
					$delete_comments = $this->db->delete('post_comments', array('post_id' => $post_id));
					$array = array('status' => 'success', 'message' => 'Deleted Successfully. Redirecting...');
				} else {
					$array = array('status' => 'failed', 'message' => 'Oops! Post Deletion Failed.');
				}
			} else {
					$array = array('status' => 'failed', 'message' => 'Oops! Something Went Wrong');
			}
	} else {
		$array = array('status' => 'failed', 'message' => 'You Cannot Delete Your Friend Post');		
	}
	echo json_encode($array);
	}

	public function deleteFiles($files)
	{
		if(!empty($files)){
			$files_arr = explode(",", $files);
			foreach ($files_arr as $image) {
				$uploads_dir = 'uploads';
				//old file data
				$foldername = $this->sessiondata['username'];
				$old_upload_path = './'.$uploads_dir.'/'.$foldername.'/';
				$filepath =  $old_upload_path.$image;
				if(unlink($filepath)) {
					$status = 'success';
				} else { $status = 'failed'; }				
			}
			return $status;			
		}	
	}
	public function editPost()
	{
		$post_id = ($this->input->post('selected_post_data_1', TRUE)) / MULTIPLIER;
		$post = $this->input->post('selected_post_data_2', TRUE);
		$std_id = $this->sessiondata['userid'];

		//delete all files related to this post
		$qry = $this->db->get_where('studentspost_docs', array('id' => $post_id, 'studentid' => $std_id));
		if($qry->num_rows() > 0 ) {
			$update = $this->db->set('post', $post);
			$update = 	$this->db->where('id', $post_id);
			$update = 	$this->db->update('studentspost_docs');
			if($update) {
				$array = array('status' => 'success', 'message' => 'Post Edited Successfully. Redirecting...');
			} else
			 {
			 	$array = array('status' => 'failed', 'message' => 'Oops! Something Went Wrong. Try Again Later');
			 }
		} else {
			$array = array('status' => 'failed', 'message' => 'You Cannot Edit Your Friend Post');
		}
		echo json_encode($array);
	}
}