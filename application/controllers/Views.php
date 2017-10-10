<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Views extends CI_Controller {
    
    private $color = ['#ffffff', '#ff8a80', '#ffd180', '#ffff8d', '#ccff90', '#a7ffeb', '#80d8ff', '#cfd8dc'];


    public function __construct() {
        
        parent :: __construct();	
        $this->session->unset_userdata('author_id');

        if (!$this->user_model->is_login()) {
        
            redirect('users/login');
        }
    }


    public function personal() {
		
		$data['author_id'] = $this->session->user[0]->id;
        $data['email'] = $this->session->user[0]->email_address;
		$data['teams'] = $this->team_model->get_all($this->session->user[0]->id);
		$data['colors'] = $this->color;

		$this->load->view('include/header', $data);
		$this->load->view('include/modal', $data);
		$this->load->view('task/personal', $data);
		$this->load->view('include/footer', $data);
	}


	public function team($id) {
		
		$data['author_id'] = $id;
        $data['email'] = $this->session->user[0]->email_address;
        $data['teams'] = $this->team_model->get_all($this->session->user[0]->id);
		$data['colors'] = ['#ffffff', '#ff8a80', '#ffd180', '#ffff8d', '#ccff90', '#a7ffeb', '#80d8ff', '#cfd8dc'];
		$data['team'] = new stdClass();
		$data['team']->id = $id;
		$data['team']->name = $this->team_model->get($id)[0]->name;
		$data['team']->members = $this->team_model->get_members($id);
		
		$this->load->view('include/header', $data);
		$this->load->view('include/modal', $data);
		$this->load->view('task/team', $data);
		$this->load->view('include/footer', $data);
    }
}