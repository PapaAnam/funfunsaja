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
			'tiket'=>DepositTransaction::where('jenis_transaksi', 'Pesan Saldo')->where('user_id', Auth::id())->get(),
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
		$dp = DepositTransaction::orderBy('no_tiket', 'desc')->first();
		$data = [
			'user_id' 	=> Auth::id(),
			'jenis_transaksi'=>'Pesan Saldo',
			'no_tiket'=>is_null($dp) ? 1 : ++$dp->no_tiket,
		];
		Activity::create([
			'user_id'	=> Auth::id(),
			'title'		=> 'Pesan saldo',
			'content'	=> 'Memesan saldo sebesar '.number_format($r->deposit,0,',','.')
		]);
		DepositTransaction::create($data+$r->except(['transfer','no_tiket']));
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
			'content'	=> 'Membayar saldo sebesar '.number_format($r->jumlah_transfer,0,',','.')
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
		$r->validate([
			'diambil'	=> 'required|numeric|min:50000|max:99999999',
		]);
		$dp = DepositTransaction::orderBy('no_tiket', 'desc')->first();
		$u = $r->user()->transaksiSaldo()->create([
			'deposit'=>$r->diambil,
			'no_tiket'=>is_null($dp) ? 1 : ++$dp->no_tiket,
			'jenis_transaksi'=>'Ambil Saldo',
			'status'=>'Konfirm',
		]);
		$user = $r->user();
		$user->balance -= $r->diambil;
		$user->save();
		// $u->depoClaimLogs()->create([
		// 	'deposit'	=> $r->diambil
		// ]);
		// $u->balance -= $r->diambil;
		// $u->save();
		$r->user()->activities()->generate('Ambil Saldo', 'Pengambilan saldo sebesar '.number_format($r->diambil,0,',','.'), $r->user()->id);
		return 'Pengambilan saldo berhasil dilakukan. Menunggu verifikasi admin.';
	}

	public function noTiketTerbaru()
	{
		$dp = DepositTransaction::orderBy('no_tiket', 'desc')->first();
		return is_null($dp) ? 1 : ++$dp->no_tiket;
	}
}
