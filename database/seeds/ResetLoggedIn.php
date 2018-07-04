<?php

use Illuminate\Database\Seeder;

class ResetLoggedIn extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('users')->update([
    		'logged_in' => '0',
    		'must_logout'=> null,
    	]);
    	echo 'user logged in reset';
    }
}
