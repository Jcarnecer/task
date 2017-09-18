<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tags extends CI_Controller {


	public function __construct() {
		parent::__construct();
	}


	public function create_team($id) {
		$team_details = [
			'name' => strtolower($this->input->post('name')),
			'users_id' => $id
		];
		$this->team_model->add_team($team_details);

		redirect('tasks/test');
	}


	public function add_mates($id) {
		$peers = [];
		$peers = $this->input->post('peers'); #must get array from post
		$team_details = [
			'teams_id' => $id,
			'peers' => $peers
		];

		$this->team_model->add_peers($team_details);
	}
}
