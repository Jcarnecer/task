<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board_model extends CI_Model {


	# Get Board
	public function get_board($id) {
		
		$board 				  = $this->db->get_where('kanban_boards', ['id' => $id], 1)->result()[0];
		$board->columns 	  = $this->get_board_columns($board->id);

		return $board;
	}


	# Get All Boards
	public function get_all_boards($team_id, $status = null) {

		$boards = $this->db->get_where('kanban_boards', ['team_id' => $team_id])->result();

		foreach ($boards as $board)
			$board->columns = $this->db->get_where('kanban_columns', ['board_id' => $board->id])->result();
		
		return $boards;
	}

	
	# Get Column
	public function get_column($id) {

		$column = $this->db->get_where('kanban_columns', ['id' => $id], 1)->result()[0];

		return $column;
	}
	

	# Get All Columns
	public function get_all_columns($id) {

		$columns = $this->db->get_where('kanban_columns', ['board_id' => $id])->result();

		return $columns;
	}


	public function get_kanban_tasks($id) {

		$tasks = $this->db->select('*')
				->from('tasks')
				->join('kanban_tasks', 'kanban_tasks.id = tasks.id')
				->where('kanban_tasks.column_id', $id);

		foreach ($tasks as $task) {

			$task->notes 		  = $CI->Task_model->get_task_notes($task->id);
			$task->actors 		  = $CI->Task_model->get_task_actors($task->id);
			$task->tags 		  = $CI->Task_model->get_task_tags($task->id);
			$task->remaining_days = $CI->Task_model->estimate_days($task->id);
		}

		return $tasks;
	}

	#
	#	$key : table name
	#	$details : must be complete
	#
	public function insert($key, $details) {

		// $details['id'] = $this->utilities->unique_id($key, 8);
		$this->db->insert($key, $details);
		return $this->db->insert_id();
	}


	public function update($id, $key, $details) {

		return $this->db->update($key, $details, "id = $id");
	}


	public function initiate_board($board_id) {
		
		$columns = [
			[
				'name' 		=> 'Open',
				'position' 	=> '1',
				'board_id'	=> $board_id
			],
			[
				'name' 		=> 'In Progress', 
				'position' 	=> '2',
				'board_id'	=> $board_id
			],
			[
				'name' 		=> 'Done', 
				'position'  => '3',
				'board_id'	=> $board_id
			]
		];

		$this->db->insert_batch('kanban_columns', $columns);
	}
}