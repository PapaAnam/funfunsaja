<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DepositTransaction;
use App\DepositClaimLog;
use App\Notification;
use App\Activity;
use App\User;
use Auth;

class DepositController extends Controller
{

	private function getToday()
	{
		return DepositTransaction::with('bank', 'user')->where('created_at', 'LIKE', date('Y-m-d').'%')->latest()->get();
	}

	private function getOther($year, $month)
	{
		return DepositTransaction::with('bank', 'user')->where('created_at', 'LIKE', date($year.'-'.$month).'%')->latest()->get();
	}

	public function today()
	{
		return [
			'today' => $this->getToday(),
			'other'	=> [],
		];
	}

	public function filter($year, $month)
	{
		return [
			'today' => $this->getToday(),
			'other'	=> $this->getOther($year, $month),
		];
	}

	public function index()
	{
		$deposits = DepositTransaction::with(['user'])->where('status', '0')->latest()->get()
		->map(function($item, $key){
			$item->username = $item->user->username;
			return collect($item)->except('user');
		});
		$oper = [
			'data' => $deposits
		];
		return view('admin.deposit.index', $oper);
	}

	public function detail($id)
	{
		$deposit = DepositTransaction::with(['user', 'bank'])->where('status', '0')->where('id', $id)->latest()->get()
		->map(function($item, $key){
			$item->username = $item->user->username;
			return collect($item)->except('user');
		})->first();
		if(!$deposit)
			abort(404);
		// return $deposit;
		$oper = [
			'data' => $deposit
		];
		return view('admin.deposit.detail', $oper);
	}

	public function verif($id, Request $r)
	{
		$r->validate([
			'reason' => $r->status == 2 ? 'required' : ''
		]);
		$depo = DepositTransaction::find($id);
		$depo->update([
			'status' => $r->status,
			'reason' => $r->reason
		]);
		if($r->status == 1){
			$u = User::find($depo->user_id);
			$u->update([
				'balance' => $u->saldo+$depo->deposit
			]);
		}
		$msg 	= 'Selamat pembelian deposit sebesar '.$depo->deposit.' berhasil diverifikasi dan dimasukkan ke dalam saldo anda. <a href="'.route('my_deposit').'">Deposit Saya</a>';
		$title 	= 'Deposit diterima';
		$type 	= 'success';
		if($r->status != 1){
			$title 	= 'Deposit ditolak';
			$msg = 'Pembelian deposit sebesar '.$depo->deposit.' gagal dilakukan. <a href="'.route('my_deposit').'">Deposit Saya</a>';
			$type 	= 'danger';
		}
		Notification::create([
			'title' 		=> $title,
			'content'		=> $msg,
			'to_id'			=> $depo->user_id,
			'from_id'		=> Auth::guard('admin')->id(),
			'from_type'		=> '1',
			'type'			=> $type
		]);
		return $r->status == 2 ? 'Transaksi saldo berhasil ditolak' : 'Transaksi saldo berhasil diverifikasi';
	}

	public function claim($year, $month = null)
	{
		if($year == 'today'){
			return DepositClaimLog::with('user')->where('created_at', 'LIKE', date('Y-m-d').'%')->latest()->get();
		}
		return DepositClaimLog::with('user')->where('created_at', 'LIKE', $year.'-'.$month.'%')->latest()->get();
	}

	public function claimVerify(Request $r, DepositClaimLog $depo)
	{
		$depo->update([
			'status' => '1'
		]);
		return 'Pengambilan saldo berhasil diverifikasi';
	}

}