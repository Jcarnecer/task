<?php

class Tag_model extends CI_Model {


	public function get_id($name) {
		
		return $this->db->select('id')
			->from('kb_tags')
			->where('name', $name)
			->get()
			->row()->id;
	}


	public function insert($id, $updated_tags) {
		
		$tags = array_column($this->db->get('kb_tags')->result_array(), 'name');

		foreach($updated_tags as $updated_tag) {
			
			if(!in_array($updated_tag, $tags)) {
			
				$this->db->insert('kb_tags', [
					'name' => $updated_tag
				]);
			}

			if(!in_array($updated_tag, $this->get($id))) {

				$this->db->insert('kb_ttags', [
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
				$this->db->delete('kb_ttags', ['task_id' => $id, 'tag_id' => $this->get_id($old_tag)]);
	}


	public function get($id) {

		$names = [];
		$tags  =  $this->db->select('name')
			->from('kb_tags as t1')
			->join('kb_ttags as t2', 't2.tag_id = t2.id')
			->where('t2.task_id', $id)
			->get()
			->result();

		foreach ($tags as $tag)
			$names[] = $tag->name;
		
		return $names;
	}
}