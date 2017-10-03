<?php

class Migrate extends CI_Controller
{

        public function index()
        {
                $this->load->library('migration');

                if ($this->migration->current() === FALSE)
                {
                        show_error($this->migration->error_string());
                } else 
                	echo "Version up to date";
                echo $this->migration->current();
                echo $this->migration->latest();
                echo $this->migration->version(0);

        }

}