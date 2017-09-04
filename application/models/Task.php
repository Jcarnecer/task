<?php

class Task extends CI_Model {

	public $title;
	public $user_id;
	public $status; # [1] Active [2] Completed [3] Archived
	public $created_by;
	public $created_at;
	public $updated_at;
	
}