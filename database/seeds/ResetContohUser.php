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
      User::whereIn('username', [
        'Anamcoollzz', 'Anamkun',
      ])->delete();
      User::whereIn('email', [
        'hairulanam21@outlook.com', 'hairulanam21@gmail.com',
      ])->delete();
      User::updateOrCreate([
        'username'=>'Anamcoollzz',
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
           'email'=>'hairulanam21@outlook.com',
           'web'=>'http://anamkun.com',
           'description'=>'Aku hanyalah seorang laki-laki',
           'logged_in'=>'0',
           'balance'=>30000000
       ]);
      User::updateOrCreate([
        'username'=>'Anamkun',
        ], [
           'password'=>bcrypt('Narutolover11'),
           'wrong_login'=>0,
           'verification_url'=>null,
           'token_number'=>null,
           'phone_number'=>'085322778936',
           'avatar'=>'ujicoba',
           'point'=>0,
           'status'=>'1',
           'email'=>'hairulanam21@gmail.com',
           'web'=>'http://anamkun.com',
           'description'=>'Aku hanyalah seorang laki-laki',
           'logged_in'=>'0',
           'balance'=>30000000,
       ]);
        echo 'user anam terreset';
    }
}
