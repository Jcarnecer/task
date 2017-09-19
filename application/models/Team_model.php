<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Team_model extends CI_Model {

	public $team;


	public function get_id($name) {

		return $this->db->select('id')->get_where('teams', ['name' => $name])->row()->id;
	}


	public function get() {

		return $this->db->select('*')
			->from('teams')
			->join('teams_mapping', 'teams_mapping.teams_id = teams.id')
			->where('teams_mapping.users_id', $this->session->user[0]->id)
			->get()
			->result();
	}


	public function add_team($details) {

		$teams =  $this->db->get('teams')->result();
		$mapping_details['users_id'] = $details['users_id'];
		
		foreach ($teams as $team) {
			
			if($team->name == $details['name']) {
				
				$mapping_details['teams_id'] = $this->get_id($details['name']);
				
				return $this->db->insert('teams_mapping', $mapping_details);
			}
		}

		$this->db->insert('teams', ['id' => "TMP" . $this->utilities->generate_id(8), 'name' => $details['name']]);
		$mapping_details['teams_id'] = $this->get_id($details['name']);
		
		return $this->db->insert('teams_mapping', $mapping_details);
	}


	public function add_peers($details) {

		$peers =  $details['peers'];
		$peer_id = $this->db->select('id')->where_in('email_address', explode("\r\n",$peers))->from('users')->get()->result();

		foreach ($peer_id as $id) {
			
			$this->db->insert('teams_mapping', [
				'teams_id' => $details['teams_id'],
				'users_id' => $id->id
			]);
		}
	}
}