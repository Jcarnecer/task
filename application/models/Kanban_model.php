<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kanban_model extends CI_Model {


	# Get Board
	public function get_board($id) {
		
		$board				= $this->db->get_where('kb_boards', ['id' => $id])->row();
		$board->columns		= $this->get_all_columns($board->id);

		return $board;
	}


	# Get Board
	public function get_board_by($where) {
		
		$board				= $this->db->get_where('kb_boards', $where)->row();

		if($board != null) {

			$board->columns		= $this->get_all_columns($board->id);
		}

		return $board;
	}


	# Create Board
	public function insert_board($data) {

		$this->db->insert('kb_boards', $data);
		$id = $this->db->insert_id();

		$this->initiate_board($id);
		return $id;
	}


	# Update Board
	public function update_board($id, $data) {

		return $this->db->update('kb_boards', $data, ['id' => $id]);
	}


	# Delete Board
	public function delete_board($id) {
		
		return $this->db->delete('kb_columns', ['board_id' => $id]) && $this->db->delete('kb_boards', ['id' => $id]);
	}


	# Initialize Board
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

		return $this->db->insert_batch('kb_columns', $columns);
	}

	
	# Get Column
	public function get_column($id) {

		return $this->db->get_where('kb_columns', ['id' => $id])->row();
	}
	

	# Get All Columns
	public function get_all_columns($id) {

		return $this->db->where('board_id', $id)
			->order_by('position', 'asc')
			->get('kb_columns')
			->result();
	}


	# Insert Column
	public function insert_column($data) {

		$this->db->insert('kb_columns', $data);
		return $this->db->insert_id();
	}

	
	# Update Column
	public function update_column($id, $data) {

		return $this->db->update('kb_columns', $data, ['id' => $id]);
	}


	# Update Multiple Columns
	public function update_many_columns($data) {

		return $this->db->update_batch('kb_columns', $data, 'id');
	}


	# Delete Column
	public function delete_column($id) {
		
		return $this->db->delete('kb_columns', ['id' => $id]);
	}
}