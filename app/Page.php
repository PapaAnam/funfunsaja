<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Page extends Model
{
    protected $guarded = [];
    protected $appends = ['short_title', 'crat', 'thumb', 'kind_name', 'link', 'dibuat_pada'];

    public function kind()
    {
    	return $this->belongsTo('App\PageKind', 'page_kind_id');
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

    public function getKindNameAttribute()
    {
        return $this->kind->name;
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

    public function getLinkAttribute()
    {
        return url(str_replace('//', '/', '/pages'.$this->kind->path.'/'.$this->url));
    }

    public function getDibuatPadaAttribute()
    {
        return waktuIndo($this->created_at);
    }

    public function scopePublished($q)
    {
        return $q->where('status', '1');
    }
}
