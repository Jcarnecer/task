<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board_model extends CI_Model {


	# Get Board
	public function get($id) {
		
		$board 				  = $this->db->get_where('kanban_boards', ['id' => $id], 1)->result()[0];
		$board->columns 	  = $this->get_board_columns($board->id);

		return $board;
	}


	# Get All Boards
	public function get_all($team_id, $status = null) {

		$boards = $this->db->get_where('kanban_boards', ['team_id' => $team_id])->result();

		foreach ($boards as $board)
			$board->columns = $this->get_board_columns($board->id);
		
		return $boards;
	}


	public function get_board_columns($id) {

		$CI =& get_instance();
		$CI->load->model('Task_model');

		$columns = $this->db->get_where('kanban_columns', ['board_id' => $id])->result();

		foreach ($columns as $column) {

			$column->tasks = $this->get_kanban_tasks($column->id) {

			}
		}	

		return $column;
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

		return $this->db->insert($key, $details);
	}


	public function update($id, $key, $details) {

		return $this->db->update($key, $details, 'id = $id');
	}
}