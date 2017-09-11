<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends CI_Controller {

	const ACTIVE = 1;
	const ARCHIVED = 2;

	public function __construct() {
		parent::__construct();
	}


	public function index() {
		$data = [];
		$data['tasks'] = $this->task_model->get(self::ACTIVE);

		return $this->load->view('task', $data);
	}


	public function create() {
		$data['tasks'] = $this->task_model->get();
		$data['errors'] = [];

		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$task_details = [
				'title' => $this->input->post('title'),
				'description' => $this->input->post('description'),
				'due_date' => date('Y-m-d', strtotime($this->input->post('due_date'))),
				'color' => $this->input->post('color') ? $this->input->post('color') : 'ffffff'
			];
			$this->task_model->insert($task_details);
		}

		// $this->load->view('task', $data);
		redirect('tasks');
	}


	public function view($id = null) {
		if($id == null)
			$this->index();
		else {
			$data['task_details'] = $this->task_model->get_task_by_id($id);
			$this->load->view('task/personal/view_one', $data); # view not yet created please create the view salamat po (~o.o)~
		}
	}


	public function fetch_archived(){
		return $this->task_model->get(self::ARCHIVED);
	}


	public function mark_as_done($id = null) {
		if($id == null)
			$this->index();
		else{
			$this->task_model->archive($id);
		}
		redirect('tasks');
	}


	public function update($id = null) {

		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->task_model->update(
				$this->input->post('key'),
				$this->input->post('task_id'),
				$this->input->post('val')
			);
		}

	}
}
