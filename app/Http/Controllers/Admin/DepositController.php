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
		return DepositTransaction::with('bank', 'user')
		->where('jenis_transaksi', 'Pesan Saldo')
		->where('created_at', 'LIKE', date('Y-m-d').'%')
		->latest()
		->get();
	}

	private function getOther($year, $month)
	{
		return DepositTransaction::with('bank', 'user')
		->where('jenis_transaksi', 'Pesan Saldo')
		->where('created_at', 'LIKE', date($year.'-'.$month).'%')
		->latest()
		->get();
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
		$depo = DepositTransaction::find($id);
		$r->validate([
			'reason' => $r->status == 2 ? 'required' : '',
			'jumlah_disetujui'=>'required|numeric'. ( $r->jumlah_disetujui >= $depo->deposit  ? '|max:'.$depo->deposit : '') . ($r->status == 1 ? '|min:50000' : ''),
		]);
		$depo->update([
			'status' => $r->status == 2 ? 'Gagal' : 'Approve',
			'reason' => $r->reason,
			'tanggal_approve'=>date('Y-m-d'),
			'jumlah_disetujui'=>$r->status == 2 ? 0 : $r->jumlah_disetujui
		]);
		if($r->status == 1){
			$u = User::find($depo->user_id);
			$u->update([
				'balance' => $u->balance+$depo->jumlah_disetujui
			]);
		}
		$msg 	= 'Selamat pembelian saldo sebesar '.$depo->jumlah_disetujui.' berhasil diverifikasi dan dimasukkan ke dalam saldo anda. <a href="'.route('transaksi-saldo').'">Transaksi Saldo</a>';
		$title 	= 'Beli saldo diterima';
		$type 	= 'success';
		if($r->status != 1){
			$title 	= 'Beli saldo ditolak';
			$msg = 'Pembelian saldo sebesar '.$depo->jumlah_disetujui.' gagal dilakukan. <a href="'.route('transaksi-saldo').'">Transaksi Saldo</a>';
			$type 	= 'danger';
			$user = User::find($depo->user_id);
			$user->balance += $depo->deposit;
			$user->save();
		}
		Notification::create([
			'title' 		=> $title,
			'content'		=> $msg,
			'to_id'			=> $depo->user_id,
			'from_id'		=> Auth::guard('admin')->id(),
			'from_type'		=> '1',
			'type'			=> $type
		]);
		return $r->status == 2 ? 'Pembelian saldo berhasil ditolak' : 'Pembelian saldo berhasil diterima';
	}

	public function claim($year, $month = null)
	{
		if($year == 'today'){
			return DepositClaimLog::with('user')->where('created_at', 'LIKE', date('Y-m-d').'%')->latest()->get();
		}
		return DepositClaimLog::with('user')->where('created_at', 'LIKE', $year.'-'.$month.'%')->latest()->get();
	}

	public function claimVerify(Request $r, DepositTransaction $depo)
	{
		$r->validate([
			'reason'=>'required',
			'jumlah_disetujui'=>'required|numeric'. ( $r->jumlah_disetujui >= $depo->deposit  ? '|max:'.$depo->deposit : '') . ($r->status == 1 ? '|min:50000' : ''),
		]);
		if($r->status == 2){
			$depo->update([
				'status'=>'Gagal',
				'reason'=>$r->reason,
				'jumlah_disetujui'=>0,
				'tanggal_approve'=>date('Y-m-d')
			]);
			$user = User::find($depo->user_id);			
			$user->balance += $depo->deposit;
			$user->save();
			Notification::create([
				'title'=>'Pengambilan saldo ditolak',
				'content'=>'Pengambilan saldo tiket '.$depo->no_tiket.' sebesar '.$depo->jumlah_disetujui.' gagal dilakukan. <a href="'.route('transaksi-saldo').'">Transaksi Saldo</a>',
				'from_id'=>Auth::guard('admin')->id(),
				'to_type'=>'0',
				'to_id'=>$depo->user_id,
				'type'=>'danger'
			]);
		}else{
			$depo->update([
				'status'=>'Approve',
				'jumlah_disetujui'=>$r->jumlah_disetujui,
				'reason'=>$r->reason,
				'tanggal_approve'=>date('Y-m-d')
			]);
			Notification::create([
				'title'=>'Pengambilan saldo diterima',
				'content'=>'Selamat pengambilan saldo tiket '.$depo->no_tiket.' sebesar '.$depo->jumlah_disetujui.' berhasil diterima. <a href="'.route('transaksi-saldo').'">Transaksi Saldo</a>',
				'from_id'=>Auth::guard('admin')->id(),
				'to_type'=>'0',
				'to_id'=>$depo->user_id,
				'type'=>'success'
			]);
		}
		return 'Pengambilan saldo berhasil '.($r->status == 2 ? 'ditolak' : 'diterima');
	}

}
