<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBiodata extends Model
{
    protected $guarded = [];
    protected $appends = ['skill_array','passion_array','hobby_array','language_array','character_array'];

    public function getSkillArrayAttribute()
    {
    	return explode(',', $this->skill);
    }

    public function getPassionArrayAttribute()
    {
    	return explode(',', $this->passion);
    }

    public function getHobbyArrayAttribute()
    {
    	return explode(',', $this->hobby);
    }

    public function getLanguageArrayAttribute()
    {
    	return explode(',', $this->language);
    }

    public function getCharacterArrayAttribute()
    {
    	return explode(',', $this->character);
    }
}
