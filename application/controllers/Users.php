<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    
    public function __construct() {

		parent::__construct();
    }
    

    public function get($user_id) {
        
        $user = $this->user->as_object()->get($user_id);

        echo json_encode([
            'first_name'    => $user->first_name,
            'last_name'     => $user->last_name,
            'email_address' => $user->email_address,
            'avatar_url'    => $user->avatar_url
        ]);
    }
}