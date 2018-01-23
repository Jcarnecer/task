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
		
		$task 				  	= $this->db->get_where('kb_tasks', ['id' => $id])->row();
		$task->due_date_long	= date('F d, Y', strtotime($task->due_date));
		$task->notes 		  	= $this->get_notes($task->id);
		$task->actors 		  	= $this->get_actors($task->id);
		$task->tags 		  	= $this->get_tags($task->id);
		$task->remaining_days	= $this->estimate_days($task->id);

		return $task;
	}


	# Get All Task
	public function get_all($author_id, $status = null) {

		if($status != null)
			$tasks = $this->db->get_where('kb_tasks', ['user_id' => $author_id, 'status' => $status])->result();
		else
			$tasks = $this->db->get_where('kb_tasks', ['user_id' => $author_id])->result();

		foreach ($tasks as $index => $task) {

			$tasks[$index]->due_date_long	= date('F d, Y', strtotime($task->due_date));
			$tasks[$index]->notes 		  	= $this->get_notes($task->id);
			$tasks[$index]->actors			= $this->get_actors($task->id);
			$tasks[$index]->tags 		  	= $this->get_tags($task->id);
			$tasks[$index]->remaining_days	= $this->estimate_days($task->id);
		}
		
		return $tasks;
	}
	
	
	# Get User Team Tasks
	public function get_by_actor($user_id) {
		
		return $this->db->select('*')
			->from('kb_tasks as t1')
			->join('kb_tactors as t2', 't2.task_id = t1.id')
			->where('t2.user_id', $user_id)
			->get()
			->result();
	}


	# Get Task Actors
	public function get_actors($task_id) {
		
		return $this->db->select('t1.*, t2.first_name, t2.last_name')
			->from('users as t1')
			->join('kb_tactors as t2', 't2.user_id = t1.id')
			->where('t2.task_id', $task_id)
			->get()
			->result();
	}


	# Get Task Tags
	public function get_tags($task_id) {

		return $this->db->select('name')
			->from('kb_tags as t1')
			->join('kb_ttags as t2', 't2.tag_id = t1.id')
			->where('t2.task_id', $task_id)
			->get()
			->result();
	}


	# Get Task Notes
	public function get_notes($task_id) {

		return $this->db->get_where('kb_notes', ['task_id' => $task_id])->result();
	}
	

	# Return Estimated Days
	public function estimate_days($id) {
		
		$due_date 	= date_create($this->db->get_where('kb_tasks', ['id' => $id])->row()->due_date);
		$today 		= date_create(date('Y-m-d'));
		$days  		= date_diff($today, $due_date)->days;

		if($today > $due_date) {
			$days = $days * -1;
		}
		
		return $days;
	}


	# Add Task returning ID
	public function insert($data) {

		$data['status'] = 1;
		$data['created_at'] = date('Y-m-d');
		$data['updated_at'] = date('Y-m-d');

		$this->db->insert('kb_tasks', $data);

		return $this->db->insert_id();
	}


	public function update($id, $data) {

		return $this->db->update('kb_tasks', $data, ['id' => $id]);
	}

	# Delete Task
	public function delete($task_id) {
		
		$this->db->delete('kb_notes', ['task_id' => $task_id]);
		$this->db->delete('kb_ttags', ['task_id' => $task_id]);
		$this->db->delete('kb_tactors', ['task_id' => $task_id]);

		return $this->db->delete('kb_tasks', ['id' => $task_id]);
	}

	# Delete Task by condition (Used on delete_column)
	public function delete_by($where) {
		
		$tasks = $this->db->get_where('kb_tasks', $where);

		foreach($tasks as $task) {

			$this->db->delete('kb_notes', ['task_id' => $task->id]);
			$this->db->delete('kb_ttags', ['task_id' => $task->id]);
			$this->db->delete('kb_tactors', ['task_id' => $task->id]);
		}
		
		$this->db->delete('kb_tasks', $where);
	}


	# Add Task Actors
	public function add_actors($task_id, $users) {
		
		if(count($users) == 0){

			$new_member_ids = [];
		} else {

			$new_member_ids = array_column($this->db->select('id')->from('users')->where_in('email_address', $users)->get()->result_array(), 'id');
		}
			
		$old_member_ids = array_column($this->db->select('user_id')->from('kb_tactors')->where('task_id', $task_id)->get()->result_array(), 'user_id');

		foreach ($new_member_ids as $id) {
			
			if(!in_array($id, $old_member_ids)) {
				
				$this->db->insert('kb_tactors', [
					'task_id' => $task_id,
					'user_id' => $id
				]);
			}
		}

		foreach ($old_member_ids as $id) {
			
			if(!in_array($id, $new_member_ids)) {
			
				$this->db->delete('kb_tactors', [
					'task_id' => $task_id,
					'user_id' => $id
				]);
			}
		}
	}


	# Add Task Notes
	public function add_notes($data) {

		return $this->db->insert('kb_notes', $data);
	}


	# @param $order_by = column name
	# @param $direction = asc/desc
	public function order_by($order_by = 'created_at', $direction = 'asc') {

		return $this->db->order_by($order_by, $direction);
	}


	# FOR KANBAN BOARD STATUS UPDATE
	public function update_status($id, $key) {

		return $this->db->update('kb_tasks', ['status' => $key, 'completion_date' => date('Y-m-d')], ['id' => $id]);
	}


	public function prune_tasks($user_id) {
		
		foreach($this->db->get_where('kb_tasks', ['user_id' => $user_id])->result() as $task){
			
			$this->db->delete('kb_notes', ['task_id' => $task->id]);
			$this->db->delete('kb_ttags', ['task_id' => $task->id]);
			$this->db->delete('kb_tactors', ['task_id' => $task->id]);
		}

		$this->db->delete('kb_tasks', ['user_id' => $user_id]);
	}
}