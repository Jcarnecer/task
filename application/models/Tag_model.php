<?php

class Tag_model extends CI_Model {
	
	public $name;


	public function get_id($name) {
		
		return $this->db->select('id')
			->from('tags')
			->where('name', $name)
			->get()
			->row()->id;
	}

	
	public function del_tag($id, $name) {
		
		$tasks_tagging = [
			'tasks_id' => $id,
			'tags_id' => $this->get_id($name)
		];

		return $this->db->delete('tasks_tagging', [
			'tasks_id' => $id,
			'tags_id' => $this->get_id($name)
		]);
	}


	public function insert($id, $updated_tags) {
		
		$tags = array_column($this->db->get('tags')->result_array(), 'name');

		foreach($updated_tags as $updated_tag) {
			
			if(!in_array($updated_tag, $tags)) {
			
				$this->db->insert('tags', [
					'name' => $updated_tag
				]);
			}

			if(!in_array($updated_tag, $this->get($id))) {

				$this->db->insert('tasks_tagging', [
					'tags_id' => $this->get_id($updated_tag),
					'tasks_id' => $id
				]);
			}
		}
	}


	public function update($id, $updated_tags) {
		
		
		$this->insert($id, $updated_tags);
		
		foreach($this->get($id) as $old_tag)
			if(!in_array($old_tag, $updated_tags))

				return $this->db->delete('tasks_tagging', ['tasks_id' => $id, 'tags_id' => $this->get_id($old_tag)]);
	}


	public function get($id) {

		$tags = [];
		$task_tags = $this->db->where('tasks_id', $id)->get('tasks_tagging')->result_array();

		foreach($task_tags as $task_tag) {

			$tags[$task_tag['tags_id']] = $this->db->select('name')->where('id', $task_tag['tags_id'])->get('tags')->result_array()[0]['name'];
		}

		return $tags;
	}
}