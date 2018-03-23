<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoughtContent extends Model
{
    protected $fillable = ['user_id', 'content_id', 'price'];
}
