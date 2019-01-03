<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class AktivitasModerasi extends Model
{
    protected $table = 'aktivitas_moderasi';

    public function admin()
    {
    	return $this->belongsTo('App\Admin', 'admin_id');
    }
}
