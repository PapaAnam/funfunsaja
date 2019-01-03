<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class AktivitasSaldo extends Model
{
    protected $table = 'aktivitas_saldo';

    public function admin()
    {
    	return $this->belongsTo('App\Admin', 'admin_id');
    }
}
