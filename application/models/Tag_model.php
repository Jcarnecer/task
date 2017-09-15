<?php

class Tag_model extends CI_Model {
	
	public $name;

	public function add_tag($details) {
		
		$tags = $this->db->get('tags')->result();
		foreach ($tags as $tag) {
			if($tag->name == $details['name']) {
				return $this->db->insert('tasks_tagging', [
					'tasks_id' => $details['tasks_id'],
					'tags_id' => $tag->id
				]);
			}
		}
		
		$this->db->insert('tags', ['name' => $details['name']]);
		$tagging_details = [
			'tasks_id' => $details['tasks_id'],
			'tags_id' => $this->get_id($details['name'])
		];
		return $this->db->insert('tasks_tagging', $tagging_details);
	}

	public function get_id($name) {
		return $this->db->select('id')
			->from('tags')
			->where('name', $name)
			->get()
			->row()->id;
	}

	public function del_tag($tagging_details) {
		$tasks_tagging =[
			'tasks_id' => $tagging_details['tasks_id'],
			'tags_id' => $this->get_id($tagging_details['name'])
		];
		return $this->db->delete('tasks_tagging', $tasks_tagging);
	}
}