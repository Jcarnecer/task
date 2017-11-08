<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Boards extends CI_Controller {


	#dynamic post
	public function post($key, $reference_id = null, $update_id = null) {

		if ($this->input->server('REQUEST_METHOD') == 'POST') {

			switch ($key) {

				case 'kanban_boards':

					$board_details = [
						'name'		 => $this->input->post('name'),
						'team_id'	 => $reference_id
					];

					break;

				case 'kanban_columns':

					$column_details = [
						'name'		  => $this->input->post('name'),
						'position'	  => $this->input->post('position'),
						'board_id'	  => $reference_id
					];
					
					break;

				case 'kanban_tasks':

					$task_details  = [
						'id'		 => $update_id != null ? $update_id : $reference_id,
						'column_id'	 => $this->input->post('column_id')
					];

					break;
			}

			if ($update_id != null) {
				
				$this->board_model->update($update_id, $key, $board_details);
			} else {
				
				$this->board_model->insert($key, $board_details);
			}
		}

	}


	# Board
	public function post_board($team_id, $board_id = null) {
	
		if ($this->input->server('REQUEST_METHOD') == 'POST') {

			$board_details = [
				'name'		 => $this->input->post('name'),
				'team_id'	 => $team_id
			];
			#get details here

			if ($board_id != null) {
				
				$this->board_model->update($board_id, 'kanban_boards', $board_details);
			} else {
				
				$board_id = $this->board_model->insert('kanban_boards', $board_details);
				$this->board_model->initiate_board($board_id);
			}
		}
	}


	public function get_board($team_id, $board_id = null) {
		
		if ($board_id != null) {
			
			echo json_encode((array)$this->board_model->get_board($board_id));
		} else {
			
			echo json_encode((array)($this->board_model->get_all_boards($team_id)[0]));
		}
	}


	# Column
	public function post_column($board_id, $column_id = null) {
	
		if ($this->input->server('REQUEST_METHOD') == 'POST') {

			$column_details	= [
				'name'		 => trim(strip_tags($this->input->post('name'))),
				'position'	 => $this->input->post('position'),
				'board_id'	 => $board_id
			];
			#get details here

			if ($column_id != null) {
				
				$this->board_model->update($column_id, 'kanban_columns', $column_details);

			} else {
				
				echo json_encode($this->board_model->insert('kanban_columns', $column_details));
			}
		}
	}


	public function get_column($board_id, $column_id = null) {
		
		if ($column_id != null) {

			echo json_encode((array)$this->board_model->get_column($column_id));
		} else {
			
			echo json_encode((array)$this->board_model->get_all_columns($board_id));
		}
	}


	public function post_task($id = null) {

		if ($this->input->server('REQUEST_METHOD') == 'POST') {

			$task_details  = [
				'id'		 => $id,
				'column_id'	 => $this->input->post('column_id')
			];
			#get details here

			if ($id != null) {
				
				$this->board_model->update($id, 'kanban_tasks', $task_details);

			} else {
				
				$this->board_model->insert('kanban_tasks', $task_details);
			}
		}
	}


	public function change_columns_position() {
		
		if ($this->input->server('REQUEST_METHOD') == 'POST') {

			$this->board_model->update_multiple('kanban_columns', $this->input->post('column_update'), 'id');
		}
	}
}