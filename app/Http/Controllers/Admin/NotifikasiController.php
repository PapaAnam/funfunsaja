<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notification;

class NotifikasiController extends Controller
{

	public function index(Request $request)
	{
		$waktu = $request->query('waktu');
		if(is_null($waktu)){
			return Notification::member()->with('usermember')->where('created_at', '>=', date('Y-m-d'))->get();
		}
		if($waktu == 'hari-ini'){
			return Notification::member()->with('usermember')->where('created_at', 'LIKE', date('Y-m-d').'%')->get();
		}
		if($waktu == 'hari-kemarin'){
			return Notification::member()->with('usermember')->where('created_at', 'LIKE', date('Y-m-d', strtotime('-1 days')).'%')->get();
		}
		if($waktu == 'minggu-ini'){
			$w = (int) date('w');
			$awalMinggu = date('Y-m-d', strtotime('-'.$w.' days'));
			return Notification::member()->with('usermember')
			->where('created_at', '>=', $awalMinggu)
			->get();
		}
		if($waktu == 'minggu-kemarin'){
			$w = (int) date('w');
			$w += 7;
			$awalMinggu = date('Y-m-d', strtotime('-'.$w.' days'));
			$akhirMinggu = date('Y-m-d', strtotime('-'.($w-6).' days'));
			return Notification::member()->with('usermember')
			->whereBetween('created_at', [$awalMinggu, $akhirMinggu])
			->get();
		}
		if($waktu == 'bulan-ini'){
			return Notification::member()->with('usermember')->where('created_at', '>=', date('Y-m-1'))->get();
		}
		if($waktu == 'bulan-kemarin'){
			$awalBulanKemarin 	= date('Y-m-1', strtotime('-1 months'));
			$awalBulanIni 		= date('Y-m-1');
			$akhirBulanKemarin 	= date('Y-m-d', strtotime($awalBulanIni.' -1 days'));
			return Notification::member()->with('usermember')
			->whereBetween('created_at', [$awalBulanKemarin, $akhirBulanKemarin])
			->get();
		}
		if($waktu == 'tahun-ini'){
			return Notification::member()->with('usermember')
			->where('created_at', '>=', date('Y-1-1'))
			->get();
		}
		if($waktu == 'tahun-kemarin'){
			$awalTahunKemarin 	= date('Y-1-1', strtotime('-1 years'));
			$akhirTahunKemarin 	= date('Y-12-31', strtotime('-1 years'));
			return Notification::member()->with('usermember')
			->whereBetween('created_at', [
				$awalTahunKemarin, $akhirTahunKemarin
			])
			->get();
		}
		if(strpos($waktu, '/') != -1){
			$waktu = explode('/', $waktu);
			return Notification::member()->with('usermember')
			->whereMonth('created_at', (int) $waktu[1])
			->whereYear('created_at', (int) $waktu[0])
			->get();
		}
		return Notification::member()->with('usermember')->where('created_at', '>=', date('Y-m-d'))->get();
	}

}
