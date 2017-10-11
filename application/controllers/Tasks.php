<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends CI_Controller {

	const ARCHIVED = 2;
	const INACTIVE = 3;
	const IN_PROGRESS = 4;


	# Create Task
	public function post($author_id, $task_id = null) {
	
		if ($this->input->server('REQUEST_METHOD') == 'POST') {

			$due_date = date('Y-m-d', strtotime($this->input->post('due_date')));

			if($due_date == date('Y-m-d', strtotime('1970-01-01')))
				$due_date = date('Y-m-d');

			$task_details	= [
				'title'		  => $this->input->post('title'),
				'description' => $this->input->post('description'),
				'due_date'	  => $due_date,
				'color'		  => $this->input->post('color'),
				'user_id'	  => $author_id
			];

			if($task_id != null) {
				
				$this->task_model->update($task_id, $task_details);
				
				if($this->input->post('tags[]') != null)
					$this->tag_model->update($task_id, $this->input->post('tags[]'));
				else
					$this->tag_model->update($task_id, []);
			} else {

				$task_id = $this->task_model->insert($task_details);
				
				if($this->input->post('tags[]') != null)
					$this->tag_model->insert($task_id, $this->input->post('tags[]'));
			}
		}
	}


	# Fetch Task
	public function get($author_id, $task_id = null) {
		
		if($task_id != null){

			echo json_encode($this->task_model->get($task_id));

		} else {
			
			echo json_encode($this->task_model->get_all($author_id, (ACTIVE)));
		}
	}


	# Notes
	public function post_notes($task_id)	{
		
		$note_details 	= [
			'task_id'	  => $task_id,
			'body'		  => $this->input->post('notes'),
			'created_at'  => date('Y-m-d'),
			'user_id'	  => $this->session->user->id
		];

		$this->task_model->add_task_notes($task_id, $note_details);
	}

	
	public function get_notes($task_id) {
		
		echo json_encode($this->task_model->get_task_notes($task_id));
	}


	# Tags
	public function post_tags($id, $tags){
		
		$this->tag_model->update_tags($id, $tags);
	}


	public function get_tags($id){

		echo json_encode($this->tag_model->get_by_id($id));
	}


	# Mark as Done
	public function mark_as_done($task_id) {
		
		$this->task_model->archive($task_id);
	}


	# Update Task
	public function update($id = null) {

		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			
			$this->task_model->update(
				$this->input->post('key'),
				$this->input->post('task_id'),
				$this->input->post('val')
			);
		}
	}


	# Actors for Team Task
	public function assign_actors($task_id) {
		$members = $this->input->post('members[]');
		$this->task_model->add_actors($task_id, $members);
	}
}
