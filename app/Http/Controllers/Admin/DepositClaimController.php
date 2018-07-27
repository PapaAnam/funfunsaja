<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Api;
use App\DepositTransaction;

class DepositClaimController extends Controller
{
    use Api;

    protected function model()
    {
    	return DepositTransaction::with('user')->where('jenis_transaksi', 'Ambil Saldo');
    }
}
