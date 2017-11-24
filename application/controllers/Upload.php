<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {

    public function __construct() {

        parent::__construct();
    }


    public function do_upload($directory = 'other') {
    
        $config['upload_path']          = base_url('uploads/'.$directory);
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 100;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;

        return $this->upload->do_upload('userfile');

        // if (!$this->upload->do_upload('userfile')) {

        //     $error = array('error' => $this->upload->display_errors());
        //     $this->load->view('upload_form', $error);
        // } else {

        //     $data = array('upload_data' => $this->upload->data());
        //     $this->load->view('upload_success', $data);
        // }
    }
}