<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends CI_Controller {


	public function __construct() {
		parent::__construct();
	}


	public function index() {
		$data = [];
		$data['tasks'] = $this->task_model->get();
		$data['team_tasks'] = $this->team_task_model->get();

		$this->load->view('task/index', $data);
	}

	public function create() {
		$errors = [];

		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$task_details = [
				'title' => $this->input->post('title'),
				'description' => $this->input->post('description'),
				'due_date' => $this->input->post('due_date')
			];
			$this->task_model->insert($task_details);
		}

		$this->load->view('task/create', ['errors' => $errors]);
	}

	public function create_team_task() {
		$errors = [];

		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$task_details = [
				'title' => $this->input->post('title'),
				'description' => $this->input->post('description'),
				'due_date' => $this->input->post('due_date')
			];
			$this->team_task_model->insert($task_details);
		}

		$this->load->view('task/create', ['errors' => $errors]);
	}

}
