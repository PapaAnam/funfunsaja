<?php 

namespace App\Helpers;

trait Api {

	private function _generate($filter)
	{
		return $this->model()->where('created_at', 'LIKE', $filter.'%')->latest()->get();
	}

	private function _today()
	{
		return $this->_generate(date('Y-m-d'));
	}

	public function today()
	{
		return [
			'today' 	=> $this->_today(),
			'other'		=> []
		];
	}

	public function filter($year, $month)
	{
		return [
			'today' 	=> $this->_today(),
			'other'		=> $this->_generate($year.'-'.$month)
		];
	}

}