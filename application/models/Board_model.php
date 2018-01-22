<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board_model extends CI_Model {


	# Get Board
	public function get_board($id) {
		
		$board				= $this->db->get_where('kb_boards', ['id' => $id], 1)->row();
		$board->columns		= $this->get_all_columns($board->id);

		return $board;
	}


	# Get All Boards
	public function get_all_boards($proj_id, $status = null) {

		$boards = $this->db->get_where('kb_boards', ['proj_id' => $team_id])->result();

		foreach ($boards as $board)
			$board->columns	= $this->get_all_columns($board->id);
		
		return $boards;
	}

	
	# Get Column
	public function get_column($id) {

		$column = $this->db->get_where('kb_columns', ['id' => $id], 1)->result()[0];

		return $column;
	}
	

	# Get All Columns
	public function get_all_columns($id) {

		$columns = $this->db->where('board_id', $id)
					->order_by('position', 'asc')
					->get('kb_columns')
					->result();

		return $columns;
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


	public function delete($key, $field, $value) {
		
		$this->db->delete($key, [$field => $value]);
	}


	public function delete_multiple($key, $field, $values) {
		
		$this->db->where_in($field, $values)->delete($key);
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