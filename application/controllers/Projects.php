<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends CI_Controller {

	# Fetch Projects
	public function get()	{
		
		$project 			= $this->project->get($this->input->get('id'));
		$project->members 	= $this->project->get_members($this->input->get('id'));
		
		echo json_encode($project);
	}
	
	
	# Fetch All Projects
	public function get_all()
	{
		echo json_encode($this->project->get_many_by_user($this->session->user->id));
	}


	public function get_member()
	{
		echo json_encode($this->project->get_member_by_email($this->input->get('email_address')));
	}

	
	# Create Project
	public function insert() {
		
		$proj_id	= $this->project->insert([
			'name'			=> $this->input->post('name'),
			'admin' 		=> $this->session->user->id,
			'company_id' 	=> $this->session->user->company_id
		]);
				
		$members 	= $this->input->post('members[]');
		$members[]	= $this->session->user->email_address;

		$this->project->update_members($proj_id, $members);

		echo json_encode(['project_id' => $proj_id]);
	}


	# Update Project
	public function update()
	{
		$proj_id	= $this->input->post('id');

		$members 	= $this->input->post('members[]');
		$members[]	= $this->session->user->email_address;
		
		$this->project->update($proj_id, ['name' => $this->input->post('name')]);
		$this->project->update_members($proj_id, $members);
	}


	# Check if user is a member
	public function validate_member() {
        
		$user 		= $this->user_model->get_by(['email_address' => $this->input->post('email'), 'company_id' => $this->session->user->company_id]);
		$proj_id 	= $this->input->post('proj_id');

		if($user != null) {
			
			if($proj_id != null) {

				$user->exists = $this->project->check_project($proj_id, $user->id) != null;
			} else {
				
				$user->exists = true;
			}
			echo json_encode($user);
		} else {

			echo json_encode(['exist' =>  false]);
		}
	}


	public function email_invite() {
		
		$config['protocol']    	= 'smtp';
        $config['smtp_host']    = 'ssl://smtp.gmail.com';
        $config['smtp_port']    = '465';
        $config['smtp_timeout'] = '7';
        $config['smtp_user']    = 'admin@gmail.com'; // Admin Account
        $config['smtp_pass']    = 'password'; // Admin Password
        $config['charset']    	= 'utf-8';
        $config['newline']    	= "\r\n";
        $config['mailtype'] 	= 'text'; // or html
        $config['validation'] 	= TRUE; // bool whether to validate email or not      

        $this->email->initialize($config);

        $this->email->from('mygmail@gmail.com', 'myname');
        $this->email->to('target@gmail.com'); 

        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');  

        $this->email->send();

        echo $this->email->print_debugger();

        $this->load->view('email_view');
	}
	

	# Leave Projects
	public function leave_project() {
		
		$this->project->delete_member($this->input->post('proj_id'), $this->session->user->id);
	}
}
