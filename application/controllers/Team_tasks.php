<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Team_tasks extends CI_Controller {


	public function __construct() {
		parent::__construct();
	}

	public function creat_task() {
		$errors = [];

		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$task_details = [
				'title' => $this->input->post('title'),
				'description' => $this->input->post('description'),
				'due_date' => date('Y-m-d', strtotime($this->input->post('due_date'))),
				'color' => $this->input->post('color') ? $this->input->post('color') : 'ffffff'
			];
			$this->team_task_model->insert($task_details);
		}

		$this->load->view('task', ['errors' => $errors]);
	}

	public function view_task($id = null) {
		if($id == null)
			$this->index();
		else {
			$data['task_details'] = $this->team_task_model->get_task_by_id($id);
			$this->load->view('task/team/view_one',$data); # view not yet created please create the view salamat po (~o.o)~
		}
    }
    
    public function fetch_archived(){
		return $this->team_task_model->get_archived();
	}

    public function mark_as_done($id = null) {
		if($id == null)
			$this->index();
		else{
			$this->team_task_model->update($id);
		}
	}

}
