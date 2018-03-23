<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreDepositTransaction;
use App\DepositTransaction;
use App\BankAccount;
use App\Activity;
use Auth;

class DepositTransactionController extends Controller
{
	public function index(Request $r)
	{
		$deposits 	= DepositTransaction::mine(Auth::id());
		$receivers 	= BankAccount::all();
		$claim_logs	= $r->user()->depoClaimLogs()->latest()->paginate(10);
		$oper = [
			'data' 			=> $deposits,
			'receivers' 	=> $receivers,
			'claim_logs'	=> $claim_logs,
		];
		return view('balance_transactions.index', $oper);
	}

	public function claimView(Request $r)
	{
		$deposits 	= DepositTransaction::mine(Auth::id());
		$receivers 	= BankAccount::all();
		$claim_logs	= $r->user()->depoClaimLogs()->latest()->paginate(10);
		$oper = [
			'data' 			=> $deposits,
			'receivers' 	=> $receivers,
			'claim_logs'	=> $claim_logs,
		];
		return view('balance_transactions.claim_view', $oper);
	}

	public function store(StoreDepositTransaction $r)
	{
		$send_time = substr($r->send_time, 6, 4).'-'.substr($r->send_time, 3, 2).'-'.substr($r->send_time, 0, 2).' '.substr($r->send_time, 11, 5).':00';
		if($send_time > now()){
			return response([
				'errors' => [
					'send_time' => ['Waktu transfer tidak valid']
				]
			], 422);
		}
		$proof = $r->file('proof')->store('public/deposit-transactions');
		$data = [
			'proof' 	=> str_replace('public/', '', $proof),
			'user_id' 	=> Auth::id(),
			'status' 	=> '0',
			'send_time' => $send_time
		];
		Activity::create([
			'user_id'	=> Auth::id(),
			'title'		=> 'Beli Deposit',
			'content'	=> 'Membeli deposit sebesar '.$r->deposit
		]);
		DepositTransaction::create($data+$r->except(['transfer']));
		return response('Beli saldo berhasil dilakukan. Tunggu verifikasi dari admin');
	}

	public function delete(DepositTransaction $depo)
	{
		$d = $depo;
		Activity::create([
			'user_id'	=> Auth::id(),
			'title'		=> 'Deposit dibatalkan',
			'content'	=> 'Membatalkan deposit sebesar '.$d->deposit
		]);
		$d->delete();
		return response('Deposit berhasil dibatalkan');
	}

	public function claim(Request $r)
	{
		$u = $r->user();
		$r->validate([
			'diambil'	=> 'required|numeric|min:0|max:'.$u->balance,
		]);
		$u->depoClaimLogs()->create([
			'deposit'	=> $r->diambil
		]);
		$u->balance -= $r->diambil;
		$u->save();
		$u->activities()->generate('Ambil Saldo', 'Pengambilan saldo sebesar '.$r->diambil, $u->id);
		return 'Pengambilan saldo berhasil dilakukan. Menunggu verifikasi admin.';
	}
}
