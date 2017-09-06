<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task_notes extends CI_Controller {


	public function __construct() {
		parent::__construct();
	}


	public function create($task_id) {
		if($this->input->server('REQUEST_METHOD') == 'POST') {
			$task_note_details = [
				'body' => $this->input->post('body'),
				'task_id' => $task_id
			];
			$this->task_note_model->insert($task_note_details);
		}
		return redirect('tasks');
	}

}
