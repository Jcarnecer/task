<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    
    public function __construct() {

		parent::__construct();
    }
    

    public function get($user_id) {
        
        $user = $this->user_model->get('id', $user_id)[0];

        echo json_encode([
            'first_name'    => $user->first_name,
            'last_name'     => $user->last_name,
            'email_address' => $user->email_address,
            'avatar_url'    => $user->avatar_url
        ]);
    }


    public function login() {

        if($this->user_model->is_login()){
            
            return redirect('tasks/');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          
            $login_details    = [
                "email_address" => $_POST["email_address"],
                "password"      => $_POST["user_password"]
            ];

            $user = $this->user_model->login($login_details);
            
            if($user != null) {
                
                $this->session->set_userdata('user', $user);
                redirect();
            }
        }

        return $this->load->view('users/login');
    }


    public function register() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
            $user_details      = [
                "id"             => "USR" . $this->utilities->generate_id(8),
                "first_name"     => ucfirst($_POST["first_name"]),
                "last_name"      => $_POST["last_name"],
                "password"       => $_POST["user_password"],
                "company_id"     => 'astrid-technologies',
                "email_address"  => $_POST["email_address"]
            ];

            $this->user_model->insertUser($user_details);
        }
        
        return $this->load->view('users/register');
    }


    public function logout() {

        $this->user_model->logout();
        
        return redirect('users/login');
    }
}