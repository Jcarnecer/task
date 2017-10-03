<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends CI_Controller {

	const ACTIVE = 1;
	const ARCHIVED = 2;

	private $color = ['#ffffff', '#ff8a80', '#ffd180', '#ffff8d', '#ccff90', '#a7ffeb', '#80d8ff', '#cfd8dc'];

	
	public function __construct() {
	
		parent :: __construct();	
		$this->session->unset_userdata('author_id');

		if (!$this->user_model->is_login()) {
		
			redirect('users/login');
		}
	}


	public function index($page = 'home') {
		
		$data['author_id'] = $this->session->user[0]->id;
        $data['email'] = $this->session->user[0]->email_address;
		$data['teams'] = $this->team_model->get_all($this->session->user[0]->id);
		$data['colors'] = $this->color;

		$this->load->view('task/header', $data);
		$this->load->view('modal', $data);
		$this->load->view("task/$page", $data);
		$this->load->view('task/footer', $data);
	}


	public function team($id) {
		
		$data['author_id'] = $id;
        $data['email'] = $this->session->user[0]->email_address;
        $data['teams'] = $this->team_model->get_all($this->session->user[0]->id);
		$data['colors'] = ['#ffffff', '#ff8a80', '#ffd180', '#ffff8d', '#ccff90', '#a7ffeb', '#80d8ff', '#cfd8dc'];
		$data['team'] = new stdClass();
		$data['team']->id = $id;
		$data['team']->name = $this->team_model->get($id)[0]->name;
		$data['team']->members = $this->team_model->get_members($id);
		
		$this->load->view('task/header', $data);
		$this->load->view('modal', $data);
		$this->load->view("task/team", $data);
		$this->load->view('task/footer', $data);
	}


	public function post($author_id, $task_id = null) {
	
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$due_date = date('Y-m-d', strtotime($this->input->post('due_date')));
			if($due_date == date('Y-m-d', strtotime('1970-01-01')))
				$due_date = date('Y-m-d');
			$task_details = [
				'title' => $this->input->post('title'),
				'description' => $this->input->post('description'),
				'due_date' => date('Y-m-d'),
				'color' => $this->input->post('color'),
				'user_id' => $author_id
			];

			if($task_id != null) {
				
				$this->task_model->update($task_id, $task_details);
				
				if($this->input->post('tags[]') != null)
					$this->tag_model->update($task_id, $this->input->post('tags[]'));
				else
					$this->tag_model->update($task_id, []);

			} else {

				$task_id = $this->task_model->insert($task_details);
				
				if($this->input->post('tags[]') != null)
					$this->tag_model->insert($task_id, $this->input->post('tags[]'));
			}
		}
	}


	public function get($author_id, $task_id = null) {
		
		if($task_id != null){

			echo json_encode($this->task_model->get($task_id));

		} else {
			
			echo json_encode($this->task_model->get_all($author_id, (self::ACTIVE)));
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


	public function post_note($task_id)	{
		
		$note_details = [
			'task_id' => $task_id,
			'body' => $this->input->post('notes'),
			'created_at' => date('Y-m-d'),
			'user_id' => $this->session->user[0]->id
		];

		$this->task_model->add_task_notes($task_id, $note_details);
	}

	
	public function get_note($task_id) {
		
		echo json_encode($this->task_model->get_task_notes($task_id));
	}


	public function mark_as_done($task_id) {
		
		$this->task_model->archive($task_id);
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


	public function test($id = 1) {

		$data['tasks'] = $this->task_model->get($id);
		$data['status'] = $id;
		
		$this->load->view('task/header');
		$this->load->view('modal');
		$this->load->view('task/index', $data);
	}
}
