<?php

class Team_task_note_model extends Task_note_model {
	

	public function get($task_id) {
		return $this->db->get_where('team_task_notes', ['task_id' => $task_id])->result();
	}

	public function insert($task_note_details) {
		$task_note_details['user_id'] = 1;
		$task_note_details['created_at'] = date('Y-m-d');

		$this->db->insert('team_task_notes', $task_note_details);
	}

}