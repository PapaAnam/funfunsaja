<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feedback;
use App\Comment;
use App\FeedbackComment;
use App\Content;
use Storage;
use Auth;

class CommentController extends Controller
{

	private function valid($r)
	{
		$r->validate([
			'content'	=> 'required'
		], [
			'content.required' => 'Isi tanggapan wajib diisi'
		]);
	}

	private function generate(Request $r, $content, $is_feedback = false)
	{
		$this->valid($r);
		$file = $r->file('file');
		$path = '';
		$prefix = 'comment-file';
		$isi_tanggapan = 'Memberikan tanggapan pada konten dengan judul <a href="'.route('contents.detail', [$content->kind->path, $content->url,]).'">'.$content->title.'</a>';
		$title = 'Tanggapan Konten';
		if($is_feedback){
			$title = 'Tanggapan Masukan';
			$prefix = 'feedback-comment-file';
			$isi_tanggapan = 'Memberikan tanggapan pada masukan dengan judul <a href="'.route('feedback.detail', [$content->kind->path, $content->url,]).'">'.$content->title.'</a>';
		}
		if($file){
			$dir 	= 'public/'.$prefix.'/'.$r->user()->username;
			$path 	= $file->storeAs($dir, $file->getClientOriginalName());
			$path 	= str_replace('public/', '', $path);
		}
		if(!$is_feedback){
			$r->user()->comments()->create([
				'content_id' 	=> $content->id,
				'content'		=> $r->content,
				'status'		=> '0',
				'file_path'		=> $path,
			]);
		}else{
			$r->user()->feedbackComments()->create([
				'feedback_id' 	=> $content->id,
				'content'		=> $r->content,
				'file_path'		=> $path,
			]);
		}
		$r->user()->activities()->generate(
			$title, 
			$isi_tanggapan,
			$r->user()->id
		);
		return response('Tanggapan berhasil disimpan. Menunggu moderasi admin.', 200);
	}

	public function post(Content $content, Request $r)
	{
		return $this->generate($r, $content);	
	}

	private function generateUpdate($comment, $r, $is_feedback = false)
	{
		$this->valid($r);
		$content = $comment->post;
		$file = $r->file('file');
		$path = $comment->file_path;
		$prefix = 'comment-file';
		$isi_tanggapan = 'Mengubah tanggapan pada konten dengan judul <a href="'.route('contents.detail', [$content->kind->path, $content->url,]).'">'.$content->title.'</a>';
		$title = 'Tanggapan Konten';
		if($is_feedback){
			$title = 'Tanggapan Masukan';
			$prefix = 'feedback-comment-file';
			$isi_tanggapan = 'Mengubah tanggapan pada masukan dengan judul <a href="'.route('feedback.detail', [$content->kind->path, $content->url,]).'">'.$content->title.'</a>';
		}
		if($file){
			if($comment->file_path){
				Storage::delete('public/'.$comment->file_path);
			}
			$dir 	= 'public/'.$prefix.'/'.$r->user()->username;
			$path 	= $file->storeAs($dir, $file->getClientOriginalName());
			$path 	= str_replace('public/', '', $path);
		}
		$comment->update([
			'content'		=> $r->content,
			'status'		=> '0',
			'file_path'		=> $path,
		]);
		$r->user()->activities()->generate(
			$title, 
			$isi_tanggapan,
			$r->user()->id
		);
		return response('Tanggapan berhasil disimpan. Menunggu moderasi admin.', 200);
	}

	public function update(Comment $comment, Request $r)
	{
		return $this->generateUpdate($comment, $r);
	}	

	public function updateFeedback(FeedbackComment $comment, Request $r)
	{
		return $this->generateUpdate($comment, $r, true);
	}

	public function postFeedback(Feedback $feedback, Request $r)
	{
		return $this->generate($r, $feedback, true);
	}

	public function index(Content $content, Request $r)
	{
		$comments = Comment::with('user', 'post')->where('status', '1')->where('content_id', $content->id)->get();
		$oper = [
			'comments' => $comments
		];
		return view('comments.index', $oper);
	}

	public function onFeedback(Feedback $feedback)
	{
		$comments = FeedbackComment::with('user', 'post')->where('status', '1')
		->where('feedback_id', $feedback->id)->get();
		$oper = [
			'comments' => $comments
		];
		return view('comments.feedback', $oper);
	}

	public function setBest(Content $content, Comment $comment)
	{
		$content->comments()->update([
			'is_best' => '0',
		]);
		$comment->update([
			'is_best' => '1',
		]);
		return redirect()->route('comment', $content->url)->with('msg', 'Berhasil memilih tanggapan terbaik');
	}

	public function setBestFeedback(Feedback $feedback, FeedbackComment $comment)
	{
		$feedback->comments()->update([
			'is_best' => '0',
		]);
		$comment->update([
			'is_best' => '1',
		]);
		return redirect()->route('feedback_comment', $feedback->url)->with('msg', 'Berhasil memilih tanggapan terbaik');
	}

	public function mineInContent(Request $r)
	{
		$u = $r->user();
		$oper = [
			'comments' => $u->comments()->with('post')->latest()->get(),
		];
		return view('comments.on_content', $oper);
	}

	private function generateEdit($comment)
	{
		if($comment->status === '1' || $comment->user_id != Auth::id()){
			abort(404);
		}
		return [
			'comment' 	=> $comment,
			'file' 		=> json_encode([
				'name' 		=> $comment->file_name,
				'link'		=> $comment->file_url,
				'is_empty'	=> $comment->file_name === null || $comment->file_name === '',
			])
		];
	}

	public function mineInContentEdit(Content $content, Comment $comment)
	{
		$oper = $this->generateEdit($comment);
		return view('comments.on_content_edit', $oper);
	}

	public function mineInFeedback(Request $r)
	{
		$u = $r->user();
		$oper = [
			'comments' => $u->feedbackComments()->with('post')->latest()->get(),
		];
		return view('comments.on_feedback', $oper);
	}

	public function mineInFeedbackEdit(Feedback $feedback, FeedbackComment $comment)
	{
		$oper = $this->generateEdit($comment);
		return view('comments.on_feedback_edit', $oper);
	}

	public function setTerbaik(Comment $comment, Content $content)
	{
		$content->comments()->update([
			'is_best' => '0',
		]);
		$comment->update([
			'is_best' => '1',
		]);
		return redirect()->back()->with('msg', 'Berhasil memilih tanggapan terbaik');
	}

}
