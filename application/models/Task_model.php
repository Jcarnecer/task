<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task_model extends CI_Model {

	public $title;
	public $details;
	public $user_id;
	public $color;
	public $status;
	public $created_by;
	public $created_at;
	public $updated_at;

	public function get() {
		$tasks = $this->db->get('tasks')->result();
		foreach ($tasks as $task) {
			$task->notes = $this->get_task_notes($task->id);
		}
		return $tasks;
	}

	public function get_task_by_id($id) {
		return $this->db->get_where('tasks', ['id'])->result();
	}

	public function get_task_notes($task_id) {
		return $this->db->get_where('task_notes', ['task_id' => $task_id])->result();
	}


	public function insert($task_details) {
		$task_details['user_id'] = 1;
		$task_details['due_date'] = date('Y-m-d');
		$task_details['status'] = 1;
		$task_details['created_at'] = date('Y-m-d');
		$task_details['updated_at'] = date('Y-m-d');

		$this->db->insert('tasks', $task_details);
	}

	#function update
	
}