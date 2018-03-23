<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreBankAccount;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BankAccount;

class BankAccountController extends Controller
{
    public function api()
	{
		return BankAccount::all();
	}

	public function store(StoreBankAccount $r)
	{
		BankAccount::create($r->all());
		return response('Akun bank berhasil ditambahkan');
	}

	public function update($id, StoreBankAccount $r)
	{
		$slider = BankAccount::find($id);
		$slider->update($r->all());
		return response('Akun bank berhasil diperbarui');
	}

	public function delete($id)
	{
		BankAccount::find($id)->delete();
		return response('Akun bank berhasil dihapus');
	}
}
