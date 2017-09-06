<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TaskNoteController extends CI_Controller {


	public function __construct() {
		parent::__construct();
	}


	public function create($task_id) {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$task_note_details = [
				'body' => $_POST['body'],
				'task_id' => $task_id
			];
			$this->task_note->insert($task_note_details);
		}
		return redirect('tasks');
	}

}
