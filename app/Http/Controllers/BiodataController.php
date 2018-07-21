<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ContentKind;
use App\Traits\RightMenu;
use App\Traits\UserOper;
use App\UserBiodata;

class BiodataController extends Controller
{

	use UserOper, RightMenu;

	public function edit(Request $r)
	{
		return view('profil-saya.biodata.ubah', $this->useroper($r));
	}

	public function update(Request $r)
	{
		$r->validate([
			'skill'=>'required',
			'passion'=>'required',
			'hobby'=>'required',
			'language'=>'required',
			'character'=>'required',
		]);
		$r->user()->biodata()->update(['status'=>'0']);
		$r->user()->biodata()->create([
			'skill'=>implode(',', $r->skill),
			'passion'=>implode(',', $r->passion),
			'hobby'=>implode(',', $r->hobby),
			'language'=>implode(',', $r->language),
			'character'=>implode(',', $r->character),
			'status'=>'1'
		]);
		return 'Biodata berhasil diperbarui';
	}

	public function getUserAktif(Request $r)
	{
		$data = $r->user()->biodata()->where('status', '1')->first();
		return is_null($data) ? 'nothing' : $data;
	}

	private function getColumn($columnName)
	{
		$skills = UserBiodata::where('status', '1')->get()->pluck($columnName)->toArray();
		return collect(explode(',', implode(',', $skills)))->map(function($item){
			return trim($item);
		})->unique()->values()->all();
	}

	public function getSkill(Request $r)
	{
		return $this->getColumn('skill');
	}

	public function getPassion(Request $r)
	{
		return $this->getColumn('passion');
	}

	public function getHobi(Request $r)
	{
		return $this->getColumn('hobby');
	}

	public function getBahasa(Request $r)
	{
		return $this->getColumn('language');
	}

	public function getKarakter(Request $r)
	{
		return $this->getColumn('character');
	}


}
