<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Views extends CI_Controller {
    

    public function __construct() {
        parent :: __construct();	
        if ($this->session->has_userdata("author_id")) {
        	$this->session->unset_userdata('author_id');
        }

        if (!$this->session->has_userdata("user")) {
        	return redirect(LOGIN_URL);
        }
    }


    public function personal() {
		$data['author_id']		= $this->session->user->id;
		$data['user_id']		= $this->session->user->id;
		$data['user_name']		= $this->session->user->first_name.' '.$this->session->user->last_name;
		$data['first_name']		= $this->session->user->first_name;
        $data['email']			= $this->session->user->email_address;
        $data['avatar_url']		= $this->session->user->avatar_url;
		$data['projects']		= $this->project->get_many_by_user($this->session->user->id);
		$data['colors']			= unserialize(COLORS);
		$data['task_type']		= 'personal';
		$data['company_user']	= $this->user_model->get_all($this->session->user->company_id);

		$this->load->view('include/header', $data);
		$this->load->view('include/modal', $data);
		$this->load->view('include/tutorial');
		$this->load->view('task/personal', $data);
		$this->load->view('include/footer', $data);
	}


	public function project($id) {
		
		$data['author_id'] 			= $id;
		$data['user_id']			= $this->session->user->id;
		$data['user_name']			= $this->session->user->first_name.' '.$this->session->user->last_name;
        $data['email'] 				= $this->session->user->email_address;
        $data['avatar_url']			= $this->session->user->avatar_url;
        $data['projects']			= $this->project->get_many_by_user($this->session->user->id);
		$data['colors'] 			= unserialize(COLORS);
		$data['task_type']	    	= 'project';
		$data['project'] 			= new stdClass();
		$data['project']			= $this->project->get($id);
		$data['project']->members 	= $this->project->get_members($id);
		$data['company_user']		= $this->user_model->get_all($this->session->user->company_id);
		
		$this->load->view('include/header', $data);
		$this->load->view('include/modal', $data);
		$this->load->view('include/tutorial');
		$this->load->view('task/project', $data);
		$this->load->view('include/footer', $data);
    }
}