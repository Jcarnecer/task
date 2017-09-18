<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends CI_Controller {

	const ACTIVE = 1;
	const ARCHIVED = 2;

	public function __construct() {
		parent::__construct();
	}


	public function index() {
		$this->load->view('task/header');
		$this->load->view('task/body');
		$this->load->view('task/footer');
		// $this->load->view('test');
	}


	public function test() {
		$text = [
			'text' => $this->input->post('text')
		];
		print_r($text);
		print_r($this->input->post('tags[]'));
	}


	public function post($id = null) {
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$task_details = [
				'title' => $this->input->post('title'),
				'description' => $this->input->post('description'),
				'due_date' => date('Y-m-d', strtotime($this->input->post('due_date'))),
				'color' => $this->input->post('color')
			];

			if($id != null) {
				$this->task_model->update($id, $task_details);
				if($this->input->post('tags[]') != null)
					$this->tag_model->update($id, $this->input->post('tags[]'));
			}
			else {
				// $this->task_model->insert($task_details);
				if($this->input->post('tags[]') != null)
					$this->tag_model->insert($this->task_model->insert($task_details), $this->input->post('tags[]'));
			}
		}
	}


	public function get($id = null) {
		if($id != null){
			echo json_encode(array_merge($this->task_model->get_task_by_id($id), ['tags' => $this->tag_model->get($id)]));
		}
		else{
			echo json_encode(array_merge($this->task_model->get(self::ACTIVE), $this->task_model->get(self::ARCHIVED)));
			// echo json_encode($this->task_model->get(self::ACTIVE));
			// echo json_encode($this->task_model->get(self::ARCHIVED));
		}
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

	// public function postOrder() {
		
	// }
}
