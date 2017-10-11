<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Team_model extends CI_Model {

	public $team;


	public function get_id($name) {

		return $this->db->select('id')->get_where('teams', ['name' => $name])->row()->id;
	}


	public function get_all($user_id = null) {

		if($user_id != null)
			return $this->db->select('*')
				->from('teams')
				->join('teams_mapping', 'teams_mapping.team_id = teams.id')
				->where('teams_mapping.user_id', $user_id)
				->get()
				->result();
		else
			return $this->db->select('id')->from('teams')->get()->result();
	}


	public function get($team_id) {

		return $this->db->get_where('teams', ['id' => $team_id], 1)->result()[0];
	}


	public function get_members($team_id) {

		return $this->db->select('*')
			->from('users')
			->join('teams_mapping', 'teams_mapping.user_id = users.id') #inner?
			->where('teams_mapping.team_id', $team_id)
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
		$old_member_ids = array_column($this->db->select('user_id')->from('teams_mapping')->where('team_id', $team_id)->get()->result_array(), 'user_id');

		foreach ($new_member_ids as $id) {
			
			if(!in_array($id, $old_member_ids)) {
				
				$this->db->insert('teams_mapping', [
					'team_id' => $team_id,
					'user_id' => $id
				]);
			}
		}

		foreach ($old_member_ids as $id) {
			
			if(!in_array($id, $new_member_ids)) {
			
				$this->db->delete('teams_mapping', [
					'team_id' => $team_id,
					'user_id' => $id
				]);
			}
		}
	}


	public function delete_member($team_id, $user_id) {
		
		$this->db->delete('teams_mapping', [
			'team_id' => $team_id,
			'user_id' => $user_id
		]);
	}


	public function delete_team($id) {

		$this->db->delete('teams', ['id' => $id]);
	}


	public function check_team($id) {
		
		return $this->db->get_where('teams_mapping', ['team_id' => $id])->result();
	}
}