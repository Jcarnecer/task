<?php
if (!defined('BASEPATH')) exit('No direct access allowed');


class Utilities {

	private $CI;


	public function __construct() {
		$this->CI =& get_instance();
	}


	public function generate_id($length){
    	$token = "";
	    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
	    $codeAlphabet.= "0123456789";
	    $max = strlen($codeAlphabet); // edited

	    for ($i=0; $i < $length; $i++) {

	        $token .= $codeAlphabet[$this->random_int(0, $max-1)];

	    }

    	return $token;
	}


	public function random_int($min, $max) {
	    $range = $max - $min;

	    if ($range < 1)
	    	return $min; 

	    $log = ceil(log($range, 2));
	    $bytes = (int) ($log / 8) + 1; 
	    $bits = (int) $log + 1; 
	    $filter = (int) (1 << $bits) - 1; 

	    do {

	        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
	        $rnd = $rnd & $filter; 

	    } while ($rnd > $range);

	    return $min + $rnd;
	}
}