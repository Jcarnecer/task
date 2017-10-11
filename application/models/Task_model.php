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
	

	# Get Task By ID
	public function get($id) {
		
		$task 				  = $this->db->get_where('tasks', ['id' => $id])->result()[0];
		$task->notes 		  = $this->get_task_notes($task->id);
		$task->tags 		  = $this->get_task_tags($task->id);
		$task->remaining_days = $this->estimate_days($task->id);

		return $task;
	}


	# Get All Task
	public function get_all($author_id, $status = null) {

		if($status != null)
			$tasks = $this->db->get_where('tasks', ['user_id' => $author_id, 'status' => $status])->result();
		else
			$tasks = $this->db->get_where('tasks', ['user_id' => $author_id])->result();

		foreach ($tasks as $task) {

			$task->notes 		  = $this->get_task_notes($task->id);
			$task->tags 		  = $this->get_task_tags($task->id);
			$task->remaining_days = $this->estimate_days($task->id);
		}
		
		return $tasks;
	}


	# @param $order_by = column name
	# @param $direction = asc/desc
	public function order_by($order_by = 'created_at', $direction = 'asc') {

		return $this->db->order_by($order_by, $direction);
	}


	# Get Task Tags
	public function get_task_tags($id = null) {

		return $this->db->select('name')
			->from('tags')
			->join('tasks_tagging', 'tasks_tagging.tags_id = tags.id')
			->where('tasks_tagging.tasks_id', $id)
			->get()
			->result();
	}


	# Add Task Notes
	public function add_task_notes($task_id, $note_details) {

		$this->db->insert('task_notes', $note_details);
	}


	# Get Task Notes
	public function get_task_notes($task_id) {

		return $this->db->get_where('task_notes', ['task_id' => $task_id])->result();
	}


	# Add Task returning ID
	public function insert($task_details) {

		$task_details['status'] = 1;
		$task_details['created_at'] = date('Y-m-d');
		$task_details['updated_at'] = date('Y-m-d');

		$this->db->insert('tasks', $task_details);

		return $this->db->insert_id();
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
		$days  = date_diff($today, $due_date)->days;
		
		
		if($today>$due_date) {

			if($days == 1)
				return "<font color='red'>Overdue by $days day</font>";
			else
				return "<font color='red'>Overdue by $days days</font>";
		} else if($days == 1)
			return "$days day remaining";
		  else if($days == 0)
			return "<font color='red'>DUE TODAY!</font>";
		
		return "$days days remaining";
	}


	public function prune_tasks($id) {
		
		foreach($this->db->get_where('tasks', ['user_id' => $id])->result() as $task){
			
			$this->db->delete('task_notes', ['task_id' => $task->id]);
			$this->db->delete('tasks_tagging', ['tasks_id' => $task->id]);
		}

		$this->db->delete('tasks', ['user_id' => $id]);
	}
	

	public function add_actors($task_id, $users) {
		
		$new_member_ids = array_column($this->db->select('id')->from('users')->where_in('email_address', $users)->get()->result_array(), 'id');
		$old_member_ids = array_column($this->db->select('users_id')->from('tasks_assignment')->where('tasks_id', $task_id)->get()->result_array(), 'users_id');

		foreach ($new_member_ids as $id) {
			
			if(!in_array($id, $old_member_ids)) {
				
				$this->db->insert('tasks_assignment', [
					'tasks_id' => $task_id,
					'user_id' => $id
				]);
			}
		}

		foreach ($old_member_ids as $id) {
			
			if(!in_array($id, $new_member_ids)) {
			
				$this->db->delete('teams_mapping', [
					'teams_id' => $team_id,
					'user_id' => $id
				]);
			}
		}
	}
}