<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Feedback;
use App\Notification;
use Auth;

class ModerasiMasukanController extends Controller
{

	public function index(Request $r)
	{
		$date = $r->query('date');
		$month = $r->query('month');
		$year = $r->query('year');
		if($date){
			return Feedback::whereDate('created_at', $date)->latest()->get();
		}
		if($month && $year){
			return Feedback::whereMonth('created_at', $month)->whereYear('created_at', $year)->latest()->get();
		}
		return Feedback::all();
	}

	public function preview($url)
	{
		$data = Feedback::where('url', $url)->first();
		return view('admin.moderasi.masukan.preview', [
			'd'=>$data,
		]);
	}

	public function terima($id)
	{
		$masukan = Feedback::find($id);
		$masukan->update([
			'status'=>'published',
		]);
		$masukan = Feedback::find($id);
		Notification::create([
			'title'=>'Masukan dipublikasi',
			'content'=>'Selamat masukan anda dengan judul '.$masukan->title.' telah dipublikasi. <a href="'.$masukan->full_url.'">Lihat</a>',
			'from_id'=>Auth::guard('admin')->id(),
			'to_type'=>'0',
			'to_id'=>$masukan->user_id,
			'type'=>'success'
		]);
		return redirect()->route('moderasi-masukan.preview', [$masukan->url])->with('success_msg', 'Masukan berhasil diterima');
	}

	public function tolak($id)
	{
		$masukan = Feedback::find($id);
		$masukan->update([
			'status'=>'published',
		]);
		$masukan = Feedback::find($id);
		Notification::create([
			'title'=>'Masukan ditolak',
			'content'=>'Mohon maaf masukan dengan judul '.$masukan->title.' telah ditolak.',
			'from_id'=>Auth::guard('admin')->id(),
			'to_type'=>'0',
			'to_id'=>$masukan->user_id,
			'type'=>'danger'
		]);
		return redirect()->route('moderasi-masukan.preview', [$masukan->url])->with('success_msg', 'Masukan berhasil ditolak');
	}

}
