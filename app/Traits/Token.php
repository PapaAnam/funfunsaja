<?php 

namespace App\Traits;

trait Token {
	
	protected function generateToken()
	{
		return str_random(3).array_random(range(0,9)).array_random(range(0,9)).str_random(2).array_random(['$', '#', '*', '%', '&', '@']).str_random(2);
	}

}