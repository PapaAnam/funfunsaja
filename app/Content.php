<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Content extends Model
{
    protected $guarded = [];
    protected $appends = ['short_title', 'crat', 'thumb', 'full_url', 'short_content', 'dibuat_pada', 'link', 'cat_url', 'is_draft', 'is_rejected', 'is_published', 'is_waiting', 'type_name'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function kind()
    {
    	return $this->belongsTo('App\ContentKind', 'content_kind_id');
    }

    public function cat()
    {
    	return $this->belongsTo('App\Kategori', 'category_id');
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

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function getFullUrlAttribute()
    {
        return str_replace('contents//', 'contents/', $this->kind->full_url.'/'.$this->url);
    }

    public function getShortContentAttribute()
    {
        return substr(strip_tags($this->content), 0, 100);
    }

    public function scopePopular($q)
    {
        return $q->with('kind')->take(6)->orderBy('hit', 'desc')->get()->map(function($item, $key){
            return (object) collect($item)->only(['full_url', 'title', 'short_content', 'thumb'])->toArray();
        });
    }

    // public function getRouteKeyName()
    // {
    //     return 'url';
    // }

    public function scopeData($q)
    {
        return $q->with('kind', 'user')->latest()->get();
    }

    public function getDibuatPadaAttribute()
    {
        return waktuIndo($this->created_at);
    }

    public function getLinkAttribute()
    {
        return str_replace('contents//', 'contents/', route('contents.detail', [$this->kind->path, $this->url]));
    }

    public function getCatUrlAttribute()
    {
        $path = str_replace('//', '/', '/contents/'.$this->kind->path.'?cat='.$this->cat->url);
        return url($path);
    }

    public function getIsDraftAttribute()
    {
        return $this->status === 'draft';
    }

    public function getIsPublishedAttribute()
    {
        return $this->status === 'published';
    }

    public function getIsRejectedAttribute()
    {
        return $this->status === 'rejected';
    }

    public function getIsWaitingAttribute()
    {
        return $this->status === 'waiting';
    }

    public function scopePublished($q)
    {
        return $q->where('status', 'published');
    }

    public function scopeWithCommentCount($q)
    {
        $q->withCount(['comments' => function($k){
            $k->where('status', '1');
        }]);
    }

    public function getTypeNameAttribute()
    {
        return $this->type == 1 ? 'Premium' : 'Free';
    }
}
