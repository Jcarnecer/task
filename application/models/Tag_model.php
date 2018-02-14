<?php

class Tag_model extends BaseModel {

	protected $_table = "kb_tags";


	public function __construct() {
		parent::__construct();
	}

	public function get_id($name) {
		
		return $this->tag->get_by('name', $name)['id'];
	}


	public function insert_tag($id, $updated_tags) {
		
		$tags = array_column($this->tag->get_all(), 'name');

		foreach($updated_tags as $updated_tag) {

			$insert_id = null;
			
			if(!in_array($updated_tag, $tags)) {
			
				$insert_id = $this->tag->insert(['name' => $updated_tag]);
			}

			if(!in_array($updated_tag, $this->get_ttag($id))) {

				$this->ttag->insert([
					'tag_id'  => $insert_id,
					'task_id' => $id
				]);
			}
		}
	}


	public function update_tag($id, $updated_tags) {
		
		$this->insert_tag($id, $updated_tags);
		
		foreach($this->get_ttag($id) as $old_tag)
			if(!in_array($old_tag, $updated_tags))
				$this->ttag->delete(['task_id' => $id, 'tag_id' => $this->get_id($old_tag)]);
	}


	public function get_ttag($id) {

		$ttags = $this->ttag->with('tag')->get_many_by('task_id', $id);
		$names = [];
		
		if(isset($ttags))
			foreach ($ttags as $ttag)
				$names[] = $ttag['tag']['name'];

		return $names;
	}
}