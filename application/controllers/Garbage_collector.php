<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Garbage_collector extends CI_Controller {


	public function __construct() {
	
		parent :: __construct();
	}


	public function index() {

		$teams = $this->team_model->get_all();

		foreach ($teams as $team) {
			
			$members = $this->team_model->check_team($team->id);

			if($members == null) {

				$this->task_model->prune_tasks($team->id);
				$this->team_model->delete_team($team->id);
			}
		}
	}
}