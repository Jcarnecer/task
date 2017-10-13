<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teams extends CI_Controller {

	
	# Create Team
	public function post($id = null) {
		
		$team_id = 0;
		$members = [];

		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			
			if($id != null) {
				
				$team_id = $id;
				$this->team_model->update_team($id, $this->input->post('name'));
			
			} else
				$team_id = $this->team_model->create_team([
					'name'	=> $this->input->post('name'),
					'admin' => $this->session->user->id
				]);
				
			$members 	= $this->input->post('members[]');
			$members[]	= $this->session->user->email_address;

			$this->team_model->update_members($team_id, $members);
		}

		echo json_encode(['team_id' => $team_id]);
	}


	# Fetch Team
	public function get($id = null)	{
		
		if($id != null)
			echo json_encode(array_merge((array)$this->team_model->get($id), [
				'members' => (array)$this->team_model->get_members($id)
			]));
		else
			echo json_encode($this->team_model->get_all($this->session->user->id));
	}


	public function validate_member() {
        
        $user = $this->user_model->get('email_address', $this->input->post('email'));
        
		if($user !=  null)
            echo json_encode(array_merge((array)$user[0], ['exist' =>  true]));
		else
            echo json_encode(['exist' =>  false]);
	}
	

	public function leave_team($team_id) {
		
		$this->team_model->delete_member($team_id, $this->session->user->id);
	}
}