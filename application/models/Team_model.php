<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Team_model extends CI_Model {

	public $team;


	public function get_id($name) {

		return $this->db->select('id')->get_where('teams', ['name' => $name])->row()->id;
	}


	public function get_all($user_id) {

		return $this->db->select('*')
			->from('teams')
			->join('teams_mapping', 'teams_mapping.teams_id = teams.id')
			->where('teams_mapping.users_id', $user_id)
			->get()
			->result();
	}


	public function get($team_id) {

		return $this->db->get_where('teams', ['id' => $team_id], 1)->result();
	}


	public function get_members($team_id) {

		return $this->db->select('*')
			->from('users')
			->join('teams_mapping', 'teams_mapping.users_id = users.id') #inner?
			->where('teams_mapping.teams_id', $team_id)
			->get()
			->result();
	}


	public function create_team($team_details) {

		$team_details['id'] = $this->utilities->unique_id('teams', 8);
		$this->db->insert('teams', $team_details);

		return $team_details['id'];
	}


	public function update_team($team_id, $new_name) {

		if($this->db->select('name')->from('teams')->where('id', $team_id)->get()->result()[0]->name != $new_name)
			$this->db->where('id', $team_id)->update('teams', ['name' => $new_name]);
	}


	public function update_members($team_id, $users) {
		
		$new_member_ids = array_column($this->db->select('id')->from('users')->where_in('email_address', $users)->get()->result_array(), 'id');
		$old_member_ids = array_column($this->db->select('users_id')->from('teams_mapping')->where('teams_id', $team_id)->get()->result_array(), 'users_id');

		foreach ($new_member_ids as $id) {
			
			if(!in_array($id, $old_member_ids)) {
				
				$this->db->insert('teams_mapping', [
					'teams_id' => $team_id,
					'users_id' => $id
				]);
			}
		}

		foreach ($old_member_ids as $id) {
			
			if(!in_array($id, $new_member_ids)) {
			
				$this->db->delete('teams_mapping', [
					'teams_id' => $team_id,
					'users_id' => $id
				]);
			}
		}
	}
}