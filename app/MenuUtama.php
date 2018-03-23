<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuUtama extends Model
{
    protected $table = 'menu_utama';

    public function sub_menu()
    {
    	return $this->hasMany('App\ViewSubMenu', 'id_menu_utama');
    }
}
