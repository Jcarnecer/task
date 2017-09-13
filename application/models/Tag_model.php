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
}