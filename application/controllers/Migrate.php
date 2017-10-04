<?php

class Migrate extends CI_Controller {


    public function __construct() {

        parent :: __construct();
        $this->load->library('migration');
    }


    public function index($key=null, $ver=null) {
        $result = "";

        switch ($key) {
            case 'lat':
                $result = $this->migration->latest();
                break;
            case 'up':
                $result = $this->migration->version($ver);
                break;
            default:
                $result = $this->migration->current();
                break;
        }

        if ($result === FALSE)
            show_error($this->migration->error_string());
        else 
            echo "Version $result";
    }
}