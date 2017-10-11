<?php

class Task_note_model extends CI_Model {
	
	public $body;
	public $task_id;
	public $user_id;
	public $created_at;


	public function get($task_id) {

		return $this->db->get_where('task_notes', ['task_id' => $task_id])->result();
	}


	public function insert($task_note_details) {
		
		$task_note_details['user_id']	 = 1;
		$task_note_details['created_at'] = date('Y-m-d');

		$this->db->insert('task_notes', $task_note_details);
	}

}