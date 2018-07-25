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
			'tiket'=>DepositTransaction::where('status', 'Order')->where('user_id', Auth::id())->get(),
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

	public function pesanSaldo(Request $r)
	{
		$r->validate([
			'deposit'=>'required|numeric|min:50000'
		]);
		$data = [
			'user_id' 	=> Auth::id(),
			'jenis_transaksi'=>'Pesan Saldo'
		];
		Activity::create([
			'user_id'	=> Auth::id(),
			'title'		=> 'Pesan saldo',
			'content'	=> 'Memesan saldo sebesar '.$r->deposit
		]);
		DepositTransaction::create($data+$r->except(['transfer']));
		return response('Pesan saldo berhasil dilakukan. Ditunggu pembayarannya');
	}

	public function bayarSaldo(Request $r)
	{
		$r->validate([
			'no_tiket'=>'required',
			'sender_name' => 'required|string',
            'sender_bill' => 'required',
            'send_time' => 'required|date_format:d/m/Y H:i',
            'proof' => 'required|file|max:2000|mimes:jpeg,png',
            'jumlah_transfer'=>'required|numeric|min:50000'
		], [
			'sender_bill.required'=>'No rekening pengirim wajib diisi'
		]);
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
			'send_time' => $send_time,
			'status'=>'Konfirm'
		];
		Activity::create([
			'user_id'	=> Auth::id(),
			'title'		=> 'Bayar saldo',
			'content'	=> 'Membayar saldo sebesar '.$r->jumlah_transfer
		]);
		DepositTransaction::find((Int) $r->no_tiket)->update($data+$r->except(['no_tiket']));
		return response('Bayar saldo berhasil dilakukan. Tunggu verifikasi dari admin');
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
