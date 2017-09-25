<?php 

class User_model extends CI_Model {


    public function insertUser($user_details){
    
        $this->db->insert('users', $user_details);
    }


    public function login($login_details){

        return $this->db->get_where('users', $login_details, 1)->result();
    }


    public function setSession($user){

        $this->session->set_userdata('user', $user);
    }


    public function logout(){

        $this->session->unset_userdata('user');
    }


    public function is_login(){

        return $this->session->has_userdata('user');
    }


    public function get($index, $value) {

        return $this->db->get_where('users', [$index => $value], 1)->result();
    }
}