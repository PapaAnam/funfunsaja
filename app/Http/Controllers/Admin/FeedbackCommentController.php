<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\FeedbackComment;
use App\Notification;
use Auth;
use App\Activity;

class FeedbackCommentController extends Controller
{
	private function generate($filter)
	{
		return FeedbackComment::with('user', 'post')->where('created_at', 'LIKE', $filter.'%')->latest()->get();
	}

	private function today()
	{
		return $this->generate(date('Y-m-d'));
	}

	public function index()
	{
		return [
			'today' 	=> $this->today(),
			'other'		=> []
		];
	}

	public function filterTime($year, $month)
	{
		return [
			'today' 	=> $this->today(),
			'other'		=> $this->generate($year.'-'.$month)
		];
	}

	public function publish(FeedbackComment $comment)
	{
		$comment->update([
			'status'	=> '1'
		]);
		Notification::create([
			'title'     => 'Tanggapan Diterima',
			'content'   => 'Tanggapan yang anda berikan di masukan <a href="'.route('feedback.detail', [$comment->post->kind->path, $comment->post->url]).'">'.$comment->post->title.'</a> diterima',
			'from_type' => '1',
			'from_id'   => Auth::guard('admin')->id(),
			'to_id'     => $comment->user_id,
			'type'      => 'success'
		]);
		Notification::create([
			'title'     => 'Tanggapan',
			'content'   => 'Ada tanggapan baru pada masukan anda yang berjudul <a href="'.route('feedback.detail', [$comment->post->kind->path, $comment->post->url]).'">'.$comment->post->title.'</a>',
			'from_type' => '1',
			'from_id'   => Auth::guard('admin')->id(),
			'to_id'     => $comment->post->user->id,
			'type'      => 'success'
		]);
		$con = $comment->post;
        Activity::create([
            'user_id'   => Auth::guard('admin')->id(),
            'user_type' => '1',
            'title'     => 'Moderasi Tanggapan',
            'content'   => 'Mempublikasi tanggapan di masukan yang berjudul <a href="'.$con->link.'">'.$con->title.'</a>',
        ]);
		return 'Tanggapan berhasil dipublikasi';
	}

	public function reject(FeedbackComment $comment)
	{
		$comment->update([
			'status'	=> '2'
		]);
		Notification::create([
			'title'     => 'Tanggapan Ditolak',
			'content'   => 'Tanggapan yang anda berikan di masukan <a href="'.route('feedback.detail', [$comment->post->kind->path, $comment->post->url]).'">'.$comment->post->title.'</a> ditolak',
			'from_type' => '1',
			'from_id'   => Auth::guard('admin')->id(),
			'to_id'     => $comment->user_id,
			'type'      => 'danger'
		]);
		$con = $comment->post;
        Activity::create([
            'user_id'   => Auth::guard('admin')->id(),
            'user_type' => '1',
            'title'     => 'Moderasi Tanggapan',
            'content'   => 'Menolak tanggapan di masukan yang berjudul '.$con->title.'',
        ]);
		return 'Tanggapan berhasil ditolak';
	}
}
