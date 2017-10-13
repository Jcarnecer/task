<?php

class Tag_model extends CI_Model {


	public function get_id($name) {
		
		return $this->db->select('id')
			->from('tags')
			->where('name', $name)
			->get()
			->row()->id;
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
					'tag_id'  => $this->get_id($updated_tag),
					'task_id' => $id
				]);
			}
		}
	}


	public function update($id, $updated_tags) {
		
		$this->insert($id, $updated_tags);
		
		foreach($this->get($id) as $old_tag)
			if(!in_array($old_tag, $updated_tags))
				$this->db->delete('tasks_tagging', ['task_id' => $id, 'tag_id' => $this->get_id($old_tag)]);
	}


	public function get($id) {

		$names = [];
		$tags  =  $this->db->select('name')
			->from('tags')
			->join('tasks_tagging', 'tasks_tagging.tag_id = tags.id')
			->where('tasks_tagging.task_id', $id)
			->get()
			->result();

		foreach ($tags as $tag)
			$names[] = $tag->name;
		
		return $names;
	}
}