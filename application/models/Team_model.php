<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Team_model {

	public $team;


	public function get_id($name) {
		return $this->db->select('id')->get_where('team', ['name' => $name])->row()->id;
	}

	public function add_team($details) {
		$teams =  $this->db->get('teams')->result();

		$mapping_details['user_id'] = $details['users_id'];
		foreach ($teams as $team) {
			if($team->name == $details['name']) {
				$mapping_details['teams_id'] = $this->get_id($details['name']);
				return $this->db->insert('teams_mapping', $mapping_details);
			}
		}
		$this->db->insert('team', ['name' => $details['name']]);
		$mapping_details['teams_id'] = $this->get_id($details['name']);
		return $this->db->insert('teams_mapping', $mapping_details);
	}

	public function add_peers($details) {
		$peers = $details['peers'];
		foreach ($peers as $peer) {
			$this->db->insert('teams_mapping', [
				'teams_id' => $details['teams_id'],
				'user_id' => $peer->user_id
			]);
		}
	}
}