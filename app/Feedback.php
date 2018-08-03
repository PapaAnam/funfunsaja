<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Feedback extends Model
{
    protected $guarded = [];
    protected $table = 'feedbacks';

    protected $appends = ['short_title', 'crat', 'thumb', 'username', 'short_content', 'avatar', 'dibuat_pada', 'full_url','status_view'];

    protected $casts = [
        'tags' => 'array'
    ];

    public function kind()
    {
    	return $this->belongsTo('App\FeedBackKind', 'feedback_kind_id');
    }

    public function getShortTitleAttribute()
    {
        if(strlen($this->title) >= 20){
            return substr($this->title, 0, 20).'...';
        }
        return $this->title;
    }

    public function getThumbAttribute()
    {
        if(Storage::exists('public/'.$this->thumbnail) && $this->thumbnail){
            return asset('storage/'.$this->thumbnail);
        }
        return asset('images/no-thumbnail.png');
    }

    public function getCratAttribute()
    {
        $month = substr($this->created_at, 5, 2);
        switch ($month) {
            case '01': $month = 'Januari'; break;
            case '02': $month = 'Februari'; break;
            case '03': $month = 'Maret'; break;
            case '04': $month = 'April'; break;
            case '05': $month = 'Mei'; break;
            case '06': $month = 'Juni'; break;
            case '07': $month = 'Juli'; break;
            case '08': $month = 'Agustus'; break;
            case '09': $month = 'September'; break;
            case '10': $month = 'Oktober'; break;
            case '11': $month = 'November'; break;
            case '12': $month = 'Desember'; break;
            default: $month = 'Tidak valid!!!'; break;
        }
        return substr($this->created_at, 8, 2).' '.$month.' '.substr($this->created_at,0,4).' '.substr($this->created_at, 11);
    }

    public function getUsernameAttribute()
    {
        return $this->user->username;
    }

    public function getAvatarAttribute()
    {
        return $this->user->avatar;
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function getShortContentAttribute()
    {
        return substr(strip_tags($this->content), 0, 200);
    }

    public function scopeTestimoni($q)
    {
        return $q->where('feedback_kind_id', 4)->take(10)->get()
        ->map(function($item, $key){
            return (object) collect($item)->only(['url', 'username', 'short_content', 'avatar'])->toArray();
        });
    }

    public function comments()
    {
        return $this->hasMany('App\FeedbackComment', 'feedback_id');
    }

    public function getRouteKeyName()
    {
        return 'url';
    }

    public function getDibuatPadaAttribute()
    {
        return waktuIndo($this->created_at);
    }

    public function getLinkAttribute()
    {
        return route('feedback.detail', [$this->kind->path, $this->url]);
    }

    public function getFullUrlAttribute()
    {
        return url(str_replace('//', '/', '/feedback/'.$this->kind->path.'/'.$this->url));
    }

    public function scopeWithCommentCount($q)
    {
        $q->withCount(['comments' => function($k){
            $k->where('status', '1');
        }]);
    }

    public function scopePublished($q)
    {
        return $q->where('status', 'published');
    }

    public function getStatusViewAttribute()
    {
        if($this->status === 'waiting')
            return 'menunggu';
        if($this->status === 'rejected')
            return 'ditolak';
        if($this->status === 'published')
            return 'dipublikasi';
    }

}
