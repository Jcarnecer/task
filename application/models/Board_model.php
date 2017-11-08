<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board_model extends CI_Model {


	# Get Board
	public function get_board($id) {
		
		$board				= $this->db->get_where('kanban_boards', ['id' => $id], 1)->result()[0];
		$board->columns		= $this->get_all_columns($board->id);

		return $board;
	}


	# Get All Boards
	public function get_all_boards($team_id, $status = null) {

		$boards = $this->db->get_where('kanban_boards', ['team_id' => $team_id])->result();

		foreach ($boards as $board)
			$board->columns	= $this->get_all_columns($board->id);
		
		return $boards;
	}

	
	# Get Column
	public function get_column($id) {

		$column = $this->db->get_where('kanban_columns', ['id' => $id], 1)->result()[0];

		return $column;
	}
	

	# Get All Columns
	public function get_all_columns($id) {

		$columns = $this->db->where('board_id', $id)
					->order_by('position', 'asc')
					->get('kanban_columns')
					->result();

		return $columns;
	}


	public function get_task($id) {

		$task = $this->db->get_where('kanban_tasks', ['id' => $id], 1)->result()[0];

		return $task;
	}


	public function get_all_tasks($id) {
		
		$tasks = $this->db->get_where('kanban_tasks', ['column_id' => $id])->result();

		return $tasks;
	}


	#	$key : table name
	#	$details : must be complete
	public function insert($key, $details) {

		$this->db->insert($key, $details);
		return $this->db->insert_id();
	}


	public function update($id, $key, $details) {

		return $this->db->update($key, $details, ['id' => $id]);
	}


	public function update_multiple($key, $batch_details, $pivot) {
		
		$this->db->update_batch($key, $batch_details, $pivot);
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