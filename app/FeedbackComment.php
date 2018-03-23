<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedbackComment extends Model
{
	protected $fillable = [
		'user_id', 'feedback_id', 'content', 'status', 'is_best', 'file_path'
	];

	protected $appends = ['is_published', 'is_rejected', 'file_name', 'file_url', 'dibuat_pada'];

	public function feedback()
	{
		return $this->belongsTo("App\Feedback", 'feedback_id');
	}

	public function post()
	{
		return $this->belongsTo("App\Feedback", 'feedback_id');
	}

	public function user()
	{
		return $this->belongsTo("App\User");
	}	

	public function getIsPublishedAttribute()
	{
		return $this->status === '1';
	}

	public function getIsRejectedAttribute()
	{
		return $this->status === '2';
	}

	public function getFileUrlAttribute($value)
	{
		return asset('storage/'.str_replace('public/', '', $this->file_path));
	}

	public function getFileNameAttribute($value)
	{
		$file = explode('/', $this->file_path);
		return end($file);
	}

	public function getDibuatPadaAttribute()
	{
		return waktuIndo($this->created_at);
	}
}
