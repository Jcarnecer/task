<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teams extends CI_Controller {


	public function __construct() {
		parent::__construct();
	}


	public function create_team() {
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$team_details = [
				'name' => $this->input->post('name'),
				'users_id' => $this->session->user[0]->id
			];
			$this->team_model->add_team($team_details);

			redirect('tasks/test');
		}
	}


	public function index() {
		$data['teams'] = $this->team_model->get();
		$this->load->view('test/index', $data);
	}


	public function add_mates() {
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$peers = [];
			$peers = $this->input->post('peers'); #must get array from post
			$team_details = [
				'teams_id' => $this->input->post('team_id'),
				'peers' => $peers
			];

			$this->team_model->add_peers($team_details);
		}
	}
}
