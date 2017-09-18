<?php

class Tag_model extends CI_Model {
	
	public $name;


	public function create_new_tag($tag_details) {
		$this->db->insert('tags', $tag_details);
	}

	public function add_tag($tagging_details) {
		$tags = $this->db->get('tags')->result();
		foreach ($tags as $tag) {
			if($tag->name == $tagging_details['name']) {
				return $this->db->insert('tasks_tagging', [
					'tasks_id' => $tagging_details['tasks_id'],
					'tags_id' => $tag->id
				]);
			}
		}
		
		$this->create_new_tag(['name' => $tagging_details['name']]);
		return $this->db->insert('tasks_tagging', [
				'tasks_id' => $tagging_details['tasks_id'],
				'tags_id' => $this->get_id($tagging_details['name'])
			]);
	}


	public function get_id($name) {
		return $this->db->select('id')
			->from('tags')
			->where('name', $name)
			->get()
			->result()[0]->id;
	}

	
	public function del_tag($tagging_details) {
		$tasks_tagging =[
			'tasks_id' => $tagging_details['tasks_id'],
			'tags_id' => $this->get_id($tagging_details['name'])
		];
		return $this->db->delete('tasks_tagging', $tasks_tagging);
	}


	public function insert($id, $updated_tags) {
		$tags = array_column($this->db->get('tags')->result_array(), 'name');

		foreach($updated_tags as $updated_tag) {
			if(!in_array($updated_tag, $tags)) {
				$this->db->insert('tags', [
					'name' => $updated_tag
				]);
			}

			$this->db->insert('tasks_tagging', [
				'tags_id' => $this->db->select('id')
							->where('name', $updated_tag)
							->get('tags')
							->result_array()[0]['id'],
				'tasks_id' => $id
			]);
		}
	}


	public function update($id, $updated_tags) {
		$tags = array_column($this->db->get('tags')->result_array(), 'name');
		$old_tags = $this->get($id);

		foreach($updated_tags as $updated_tag) {
			if(!in_array($updated_tag, $tags)) {
				$this->db->insert('tags', [
					'name' => $updated_tag
				]);
			}

			if(!in_array($updated_tag, $old_tags)) {
				$this->db->insert('tasks_tagging', [
					'tags_id' => $this->db->select('id')
								->where('name', $updated_tag)
								->get('tags')
								->result_array()[0]['id'],
					'tasks_id' => $id
				]);	
			}
		}

		foreach($old_tags as $old_tag) {
			if(!in_array($old_tag, $updated_tags)) {
				$this->db->delete('tasks_tagging', [
					'tags_id' => $this->db->select('id')
								->where('name', $old_tag)
								->get('tags')
								->result_array()[0]['id'],
					'tasks_id' => $id
				]);
			}
		}
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