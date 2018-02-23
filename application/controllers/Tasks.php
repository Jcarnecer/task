<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends CI_Controller {

	# Fetch Task
	public function get() {

		$task_id = $this->input->get('id');
		echo json_encode($this->task->get($task_id));
	}
	
	
	# Fetch All Board Tasks
	public function get_all()
	{
 		header("Access-Control-Allow-Origin: *");
		echo json_encode($this->task->get_all($this->input->get('author_id'), 1));
	}
	
	
	# Create Task
	public function insert() {
	
		$due_date = date('Y-m-d', strtotime($this->input->post('due_date')));

		if($due_date == date('Y-m-d', strtotime('1970-01-01'))) {

			$due_date = date('Y-m-d');
		}

		$task_details	= [
			'title'		  	=> $this->input->post('title'),
			'description' 	=> $this->input->post('description'),
			'due_date'	  	=> $due_date,
			'color'		  	=> $this->input->post('color'),
			'user_id'	  	=> $this->input->post('author_id'),
			'column_id'		=> $this->input->post('column_id')
		];

		$task_id = $this->task->insert($task_details);
		
		if($this->input->post('tags[]') != null) {

			$this->tag_model->insert($task_id, $this->input->post('tags[]'));
		}

		if($this->input->post('actors[]') != null){

			$this->task->add_actors($task_id, $this->input->post('actors[]'));
		}
	}


	# Update Task
	public function update()
	{
		$task_id = $this->input->post('id');
		$due_date = date('Y-m-d', strtotime($this->input->post('due_date')));

		if($due_date == date('Y-m-d', strtotime('1970-01-01'))) {

			$due_date = date('Y-m-d');
		}

		$task_details = [
			'title'		  	=> $this->input->post('title'),
			'description' 	=> $this->input->post('description'),
			'due_date'	  	=> $due_date,
			'color'		  	=> $this->input->post('color'),
		];

		$this->task->update($task_id, $task_details);
		
		if($this->input->post('tags[]') != null) {

			$this->tag_model->update($task_id, $this->input->post('tags[]'));
		} else {

			$this->tag_model->update($task_id, []);
		}

		if($this->input->post('actors[]') != null) {

			$this->task->add_actors($task_id, $this->input->post('actors[]'));
		} else {

			$this->task->add_actors($task_id, []);
		}
	}


	# Update Task
	public function change_column()
	{
		$task_id = $this->input->post('id');
		
		$task_details = [
			'column_id'		=> $this->input->post('column_id')
		];

		$data['response'] = $this->task->update($task_id, $task_details);
		
		echo json_encode($data);
	}


	# Archive Task
	public function archive() {

		$task_id = $this->input->post('id');
		$data['response'] = $this->task->update($task_id, ['status' => ARCHIVE]);
		
		echo json_encode($data);
	}

	
	# Get Task Notes
	public function get_notes($task_id) {
		
		echo json_encode($this->task->get_notes($task_id));
	}


	# Create Notes
	public function insert_notes() {
		
		$note_details 	= [
			'task_id'	  => $task_id,
			'body'		  => $this->input->post('note'),
			'created_at'  => date('Y-m-d'),
			'user_id'	  => $this->session->user->id
		];

		$data['response'] = $this->task->add_notes($task_id, $note_details);

		echo json_encode($data);
	}


	# Actors for Team Task
	public function assign_actors($task_id) {
		
		$data['response'] = $this->task->add_actors($task_id, $this->input->post('actors[]'));

		echo json_encode($data);
	}


	# Get User Team Tasks
	public function get_task_by_actor() {

		echo json_encode($this->task->get_by_actor($this->input->get('actor_id')));
	}
}