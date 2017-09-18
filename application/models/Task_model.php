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

	public function get($status = null) {
		
		if($status != null)
			$tasks = $this->db->get_where('tasks', ['user_id' => $this->session->user[0]->id, 'status' => $status])->result();
		else
			$tasks = $this->db->get_where('tasks', ['user_id' => $this->session->user[0]->id])->result();
		foreach ($tasks as $task) {
			$task->notes = $this->get_task_notes($task->id);
			$task->tags = $this->get_task_tags($task->id);
			$task->remaining_days = $this->estimate_days($task->id);
		}
		return $tasks;
	}

	#
	# @param $order_by = column name
	# @param $direction = asc/desc
	#
	public function order_by($order_by = 'created_at', $direction = 'asc') {
		return $this->db->order_by($order_by, $direction);
	}

	public function get_task_tags($id = null) {
		return $this->db->select('name')
			->from('tags')
			->join('tasks_tagging', 'tasks_tagging.tags_id = tags.id')
			->where('tasks_tagging.tasks_id',$id)
			->get()
			->result();
	}

	public function get_task_by_id($id) {
		return $this->db->get_where('tasks', ['id' => $id])->result();
	}


	public function get_task_notes($task_id) {
		return $this->db->get_where('task_notes', ['task_id' => $task_id])->result();
	}


	public function insert($task_details) {
		$task_details['status'] = 1;
		$task_details['created_at'] = date('Y-m-d');
		$task_details['updated_at'] = date('Y-m-d');

		return $this->db->insert('tasks', $task_details);
	}


	public function archive($id){
		return $this->db->update('tasks', ['status' => 2, 'completion_date' => date('Y-m-d')], "id = $id");
	}


	public function update($id, $task_details) {
		return $this->db->update('tasks', $task_details, "id = $id");
	}

	public function estimate_days($id) {
		$due_date = date_create($this->db->select('due_date')
			->get_where('tasks', ['id' => $id])
			->row()->due_date);
		$today = date_create(date('Y-m-d'));
		$days = date_diff($today, $due_date)->days;
		if($days == 0)
			return "DUE TODAY!";
		if($days == 1)
			return "$days day remaining";
		if($today>$due_date)
			return "Overdue by $days days";
		return "$days days remaining";
	}
}