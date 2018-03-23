<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

	protected $fillable = [
		"user_id", "content_id", "content", "status", "file_path", "is_best",
	];

	protected $appends = ['is_published', 'is_rejected', 'file_name', 'file_url', 'dibuat_pada'];

	public function post()
	{
		return $this->belongsTo('App\Content', 'content_id');
	}

	public function user()
	{
		return $this->belongsTo('App\User');
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
		return asset('storage/'.$this->file_path);
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
