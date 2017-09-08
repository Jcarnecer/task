<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Team_task_model extends Task_model {

	public $team_id;

	public function get() {
		$tasks = $this->db->get('team_tasks')->result();
		foreach ($tasks as $task) {
			$task->notes = $this->get_task_notes($task->id);
		}
		return $tasks;
	}

	public function get_task_by_id($id) {
		return $this->db->get_where('team_tasks', ['id' => $id])->result();
	}

	public function get_task_notes($task_id) {
		return $this->db->get_where('team_task_notes', ['task_id' => $task_id])->result();
	}

	public function get_archived(){
		return $this->db->get_where('team_tasks', ['team_id' => 1, 'status' => 2])->result();
	}

	public function insert($task_details) {
		$task_details['team_id'] = 1;
		$task_details['due_date'] = date('Y-m-d');
		$task_details['status'] = 1;
		$task_details['created_at'] = date('Y-m-d');
		$task_details['updated_at'] = date('Y-m-d');

		$this->db->insert('tasks', $task_details);
	}

	
	public function archive($id){
		return $this->db->update('team_tasks', ['status' => 2], "id = $id");
	}

	public function update($key, $task_id, $val) {
		switch($key) {
			case 'title':
				return $this->db->update('tasks', [$key => $val], "id = $task_id"); break;
			case 'description':
				return $this->db->update('tasks', [$key => $val], "id = $task_id"); break;
			default: return;
		}
		
	}
}