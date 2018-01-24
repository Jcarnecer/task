<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Boards extends CI_Controller {
	
	# Get Board
	public function get_board_by_project() {
		
		$proj_id = $this->input->get('author_id');

		$result = $this->kanban->get_board_by(['project_id' => $proj_id]);
		
		if($result == null) {
			
			$board_details = [
				'name'			=> 'Default',
				'project_id'	=> $this->input->get('author_id')
			];

			$result = $this->kanban->get_board($this->kanban->insert_board($board_details));
		}

		echo json_encode($result);
	}


	# Create Board
	public function insert_board() {

		$board_details = [
			'name'			=> 'Default',
			'project_id'	=> $this->input->post('author_id')
		];

		$data['response'] = $this->kanban->insert_board($board_details);

		echo json_encode($data);
	}


	# Update Board
	public function update_board($board_id)
	{
		$board_details = [
			'name'		=> $this->input->post('name'),
		];

		$data['response'] = $this->kanban->update_board($board_id, $board_details);

		echo json_encode($data);	
	}


	# Get Column
	public function get_column() {
		
		echo json_encode($this->kanban->get_column($this->input->get('id')));
	}
	

	# Get All Board Columns
	public function get_all_columns()
	{
		echo json_encode($this->kanban->get_all_columns($this->input->get('board_id')));
	}


	# Create Column
	public function insert_column() {

		$board_id = $this->input->post('board_id');

		$column_details = [
			'name'		  => $this->input->post('name'),
			'position'	  => $this->input->post('position'),
			'board_id'	  => $this->input->post('board_id')
		];

		$data['response'] = $this->kanban->insert_column($column_details);

		echo json_encode($data);
	}


	# Update Column
	public function update_column()
	{
		$column_id = $this->input->post('id');

		$column_details = [
			'name'		  => $this->input->post('name'),
			'position'	  => $this->input->post('position')
		];

		$data['response'] = $this->kanban->update_column($column_id, $column_details);

		echo json_encode($data);
	}

	
	# Update Mulitple Columns
	public function update_many_columns() {
		
		$data['response'] = $this->kanban->update_many_columns($this->input->post('column_update'));

		echo json_encode($data);
	}


	# Delete Column
	public function delete_column() {
		
		$column_id = $this->input->post('id');

		$this->task->delete_by(['column_id' => $column_id]);

		$data['response'] = $this->kanban->delete_column($column_id);

		echo json_encode($data);
	}
}