<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ttag_model extends BaseModel {

	public $belongs_to = ['tag' => ['model' => 'Tag_model', 'primary_key' => 'tag_id']];
	protected $_table = "kb_ttags";

	public function __construct() {
		parent::__construct();
	}
}