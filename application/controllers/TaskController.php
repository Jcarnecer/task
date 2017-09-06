<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TaskController extends CI_Controller {


	public function __construct() {
		parent::__construct();
	}


	public function index() {
		$data = [];
		$data['tasks'] = $this->task->get();

		$this->load->view('task/index', $data);
	}

	public function create() {
		$errors = [];

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$task_details = [
				'title' => $_POST['title'],
				'description' => $_POST['description'],
				'due_date' => $_POST['due_date']
			];
			$this->task->insert($task_details);
		}

		$this->load->view('task/create', ['errors' => $errors]);
	}

}
