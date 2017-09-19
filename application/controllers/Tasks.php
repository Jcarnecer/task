<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends CI_Controller {

	const ACTIVE = 1;
	const ARCHIVED = 2;

	public function __construct() {
		parent::__construct();
	}


	public function index() {

		if (!$this->user_model->is_login()) {
			return redirect('users/login');
		}
		$data['teams'] = $data['teams'] = $this->team_model->get();
		
		$this->load->view('task/header', $data);
		$this->load->view('task/body');
		$this->load->view('task/footer');
		// $this->load->view('test');
	}

	public function post($id = null) {
		$task_id = 0;
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$task_details = [
				'title' => $this->input->post('title'),
				'description' => $this->input->post('description'),
				'due_date' => date('Y-m-d', strtotime($this->input->post('due_date'))),
				'color' => $this->input->post('color'),
				'user_id' => $this->session->user[0]->id
			];

			if($id != null) {
				$this->task_model->update($id, $task_details);
				if($this->input->post('tags[]') != null)
					$this->tag_model->update($id, $this->input->post('tags[]'));
				else
					$this->tag_model->update($id, []);
			}
			else {
				$task_id = $this->task_model->insert($task_details);
				if($this->input->post('tags[]') != null)
					$this->tag_model->insert($task_id, $this->input->post('tags[]'));
			}
		}
	}

	public function post_team($id = null) {

		$data['teams'] = $this->team_model->get();

		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$task_details = [
				'title' => $this->input->post('title'),
				'description' => $this->input->post('description'),
				'due_date' => date('Y-m-d', strtotime($this->input->post('due_date'))),
				'color' => $this->input->post('color'),
				'user_id' => $this->input->post('team_id')
			];
			if($id != null)
				$this->task_model->update($id, $task_details);
			else
				$this->task_model->insert($task_details);
		}

		redirect('teams');
	}

	public function get($id = null) {
		if($id != null){
			echo json_encode(array_merge($this->task_model->get_task_by_id($id), ['tags' => $this->tag_model->get($id)]));
		}
		else{
			// echo json_encode(array_merge($this->task_model->get(self::ACTIVE), $this->task_model->get(self::ARCHIVED)));
			echo json_encode($this->task_model->get(self::ACTIVE));
			// echo json_encode($this->task_model->get(self::ARCHIVED));
		}
	}


	public function get_team_task() {
		echo json_encode($this->task_model->get_team_task(self::ACTIVE));
	}


	public function view($id = null) {
		if($id == null)
			$this->index();
		else {
			$data['task_details'] = $this->task_model->get_task_by_id($id);
			$this->load->view('task/personal/view_one', $data); # view not yet created please create the view salamat po (~o.o)~
		}
	}


	public function fetch() {
		echo json_encode($this->task_model->get(self::ACTIVE), TRUE);
	}


	public function fetch_archived(){
		return $this->task_model->get(self::ARCHIVED);
	}


	public function mark_as_done($id) {
		$this->task_model->archive($id);
		//redirect('tasks/test'); #for testing
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

	public function test($id=1) {
		$data['tasks'] = $this->task_model->get($id);
		$data['status'] = $id;
		$this->load->view('task/header');
		$this->load->view('modal');
		$this->load->view('task/index', $data);
	}
}
