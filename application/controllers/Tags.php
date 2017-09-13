<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tags extends CI_Controller {


	public function __construct() {
		parent::__construct();
	}


	public function add_tag($id) {
		$tagging_details = [
			'tasks_id' => $id,
			'name' => $this->input->post('name')
		];
		$this->tag_model->add_tag($tagging_details);

		redirect('tasks');
	}


	public function del_tag($id) {
		$tagging_details = [
			'tasks_id' => $id,
			'name' => $this->input->post('name')
		];
		$this->tag_model->del_tag($tagging_details);
		redirect('tasks');
	}

}
