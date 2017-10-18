<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends CI_Controller {


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


				if($this->input->post('actors[]') != null)

					$this->task_model->add_actors($task_id, $this->input->post('actors[]'));
				else

					$this->task_model->add_actors($task_id, []);
			} else {

				$task_id = $this->task_model->insert($task_details);
				
				if($this->input->post('tags[]') != null)

					$this->tag_model->insert($task_id, $this->input->post('tags[]'));
					

				if($this->input->post('actors[]') != null)
				
					$this->task_model->add_actors($task_id, $this->input->post('actors[]'));
			}
		}
	}


	# Fetch Task
	public function get($author_id, $task_id = null) {
		
		if($task_id != null){

			echo json_encode($this->task_model->get($task_id));

		} else {
			
			echo json_encode($this->task_model->get_all($author_id));
		}
	}


	# Notes
	public function post_notes($task_id) {
		
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


	# Mark as Done
	public function mark_as_done($task_id) {
		
		$this->task_model->update_status($task_id, ARCHIVE);
	}


	# Change Task Columnn
	public function change_column($task_id)	{

		$column = $this->input->post('column');

		switch ($column) {

			case 'todoPanel':
				$this->task_model->update_status($task_id, ACTIVE);
				break;
			case 'doingPanel':
				$this->task_model->update_status($task_id, IN_PROGRESS);
				break;
			case 'donePanel':
				$this->task_model->update_status($task_id, ARCHIVE);
				break;
		}
		
		// $actor 	= $this->session->user->id;
		// echo json_encode(['id' => $task_id, 'column' => $column, 'actor' => $actor]);
	}


	# Actors for Team Task
	public function assign_actors($task_id) {
		
		$members = $this->input->post('actors[]');
		$this->task_model->add_actors($task_id, $members);
	}


	# Get User Team Tasks
	public function get_user_team_task($user_id) {
		echo json_encode($this->task_model->get_user_team_task($user_id));
	}
}