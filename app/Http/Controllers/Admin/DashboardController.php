<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DepositTransaction;
use App\BankAccount;
use App\ContentKind;
use App\FeedbackKind;
use App\PageKind;
use App\Slider;
use App\Admin;
use App\PointClaim;
use DB;

class DashboardController extends Controller
{
	public function api()
	{
		$claimed_point = (int) DB::select('SELECT SUM(point * deposit_per_point) as total FROM `point_claims`')[0]->total;
		$depo = DB::table('deposits')->where('status', '1')->sum('deposit');
		$depo_claims = DB::table('deposit_claim_logs')->where('status', '1')->sum('deposit');
		$content_kinds = ContentKind::withCount('contents')->get();
		$feedback_kinds = FeedbackKind::withCount('feedbacks')->get();
		$page_kinds = PageKind::withCount('pages')->get();
		$users = \App\User::all();
		$admin = Admin::all();
		$oper = [
			'content_kinds' 	=> $content_kinds->sortByDesc('contents_count')->values(),
			'page_kinds' 		=> $page_kinds->sortByDesc('pages_count')->values(),
			'feedback_kinds'	=> $feedback_kinds->sortByDesc('feedbacks_count')->values(),
			'others' => [
				[
					'name' => 'Slider',
					'count' => Slider::count()
				],
				[
					'name' => 'Akun Bank',
					'count' => BankAccount::count()
				]
			],
			'users' => [
				[
					'name' => 'Aktif',
					'count' => $users->where('status', '1')->count()
				],
				[
					'name' => 'Menunggu Verifikasi',
					'count' => $users->where('status', '0')->count()
				],
				[
					'name' => 'Banned',
					'count' => $users->where('status', '2')->count()
				],
				[
					'name'	=> 'Member Biasa',
					'count'	=> $users->where('is_premium', '0')->count()
				],
				[
					'name'	=> 'Member Premium',
					'count'	=> $users->where('is_premium', '1')->count()
				],
				[
					'name'	=> 'Admin',
					'count'	=> $admin->where('role', 'admin')->count()
				],
				[
					'name'	=> 'Moderator',
					'count'	=> $admin->where('role', 'moderator')->count()
				]
			],
			'points' => [
				[
					'name'	=> 'Poin telah ditukar saldo',
					'count'	=> $claimed_point
				],
				[
					'name'	=> 'Total poin',
					'count'	=> $users->sum('point')
				],
				[
					'name'	=> 'Poin tukar tertinggi',
					'count'	=> (int) PointClaim::max('point')
				]
			],
			'deposits' => [
				[
					'name'	=> 'Saldo tambah',
					'count'	=> rp($depo)
				],
				[
					'name'	=> 'Saldo kurang',
					'count'	=> rp($depo_claims)
				],
				[
					'name'	=> 'Saldo total user',
					'count'	=> rp((int) $users->sum('balance'))
				]
			],
			'deposit' => DepositTransaction::dashboard()
		];
		return $oper;
	}
}
