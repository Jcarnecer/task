<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_model extends CI_Model {


	public function get($proj_id) {

		
		return $this->db->get_where('pj_projects', ['id' => $proj_id])->row();
	}


	public function get_id($title) {

		return $this->db->select('id')->get_where('pj_projects', ['title' => $title])->row()->id;
	}


	public function get_many_by_user($user_id = null) {

		if($user_id != null) {
		
			return $this->db->select('*')
				->from('pj_projects as t1')
				->join('pj_members as t2', 't2.project_id = t1.id')
				->where('t2.user_id', $user_id)
				->get()
				->result();
		} else {
		
			return $this->db->select('id')->from('pj_projects')->get()->result();
		}
	}


	public function get_all($proj_id) {

		return $this->db->select('t1.*')
			->from('pj_projects as t1')
			->join('pj_members as t2', 't2.project_id = t1.id')
			->where(['t2.project_id' => $proj_id])
			->get()
			->result();
	}


	public function insert($data) {

		$data['id'] = $this->utilities->unique_id('pj_projects', 8);
		$this->db->insert('pj_projects', $data);

		return $data['id'];
	}


	public function update($proj_id, $data) {

		return  $this->db->update('pj_projects', $data, ['id' => $proj_id]);
	}


	public function delete($id) {

		return $this->db->delete('pj_projects', ['id' => $id]);
	}


	public function check_project($proj_id, $user_id = null) {
		
		if($user_id != null) {

			return $this->db->get_where('pj_members', ['project_id' => $proj_id, 'user_id' => $user_id])->result();
		} else {

			return $this->db->get_where('pj_members', ['project_id' => $proj_id])->result();
		}
	}


	public function get_members($proj_id) {

		return $this->db->select('*')
			->from('users as t1')
			->join('pj_members as t2', 't2.user_id = t1.id') #inner?
			->where('t2.project_id', $proj_id)
			->get()
			->result();
	}


	public function update_members($proj_id, $users) {
		
		$new_member_ids = array_column($this->db->select('id')->from('users')->where_in('email_address', $users)->get()->result_array(), 'id');
		$old_member_ids = array_column($this->db->select('user_id')->from('pj_members')->where('project_id', $proj_id)->get()->result_array(), 'user_id');

		foreach ($new_member_ids as $id) {
			
			if(!in_array($id, $old_member_ids)) {
				
				$this->db->insert('pj_members', [
					'project_id' => $proj_id,
					'user_id' => $id
				]);
			}
		}

		foreach ($old_member_ids as $id) {
			
			if(!in_array($id, $new_member_ids)) {
			
				$this->db->delete('pj_members', [
					'project_id' => $proj_id,
					'user_id' => $id
				]);
			}
		}
	}


	public function delete_member($proj_id, $user_id) {
		
		$this->db->delete('pj_members', [
			'project_id' => $proj_id,
			'user_id' => $user_id
		]);
	}
}