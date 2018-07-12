<?php

use Illuminate\Database\Seeder;
use App\User;

class ResetContohUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	User::updateOrCreate([
    		'email'=>'hairulanam21@outlook.com'
        ], [
           'password'=>bcrypt('Narutolover11'),
           'wrong_login'=>0,
           'verification_url'=>null,
           'token_number'=>null,
           'phone_number'=>'085322778935',
           'avatar'=>'ujicoba',
           'balance'=>0,
           'point'=>0,
           'status'=>'1',
           'username'=>'Anamcoollzz',
           'web'=>'http://anamkun.com',
           'description'=>'Aku hanyalah seorang laki-laki',
           'logged_in'=>'0'
       ]);
        echo 'user anam terreset';
    }
}
