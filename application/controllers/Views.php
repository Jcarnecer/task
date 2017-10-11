<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Views extends CI_Controller {
    
    
    public function __construct() {
        
        parent :: __construct();	
        $this->session->unset_userdata('author_id');

        if (!$this->user_model->is_login()) {
        
            redirect('users/login');
        }
    }


    public function personal() {
		
		$data['author_id']	= $this->session->user->id;
        $data['email']		= $this->session->user->email_address;
		$data['teams']		= $this->team_model->get_all($this->session->user->id);
		$data['colors']		= unserialize(COLORS);

		$this->load->view('include/header', $data);
		$this->load->view('include/modal', $data);
		$this->load->view('task/personal', $data);
		$this->load->view('include/footer', $data);
	}


	public function team($id) {
		
		$data['author_id'] 		= $id;
        $data['email'] 			= $this->session->user->email_address;
        $data['teams']			= $this->team_model->get_all($this->session->user->id);
		$data['colors'] 		= unserialize(COLORS);
		$data['team'] 			= new stdClass();
		$data['team']->id 		= $id;
		$data['team']->name 	= $this->team_model->get($id)->name;
		$data['team']->members 	= $this->team_model->get_members($id);
		
		$this->load->view('include/header', $data);
		$this->load->view('include/modal', $data);
		$this->load->view('task/team', $data);
		$this->load->view('include/footer', $data);
    }
}