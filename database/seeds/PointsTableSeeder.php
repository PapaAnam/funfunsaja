<?php

use Illuminate\Database\Seeder;

class PointsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker          = \Faker\Factory::create('id_ID');
    	$users          = \App\User::with(['contents' => function($q){
    		$q->where('status', '4');
    	}])->where('status', '1')->inRandomOrder()->get();
    	$point 			= \App\Setting::pointGet();
    	DB::table('points')->truncate();
    	$data = [];
    	foreach ($users as $user) {
    		$data = [];
    		$total_point = 0;
    		if(count($user->contents) > 0){
    			foreach ($user->contents as $c) {
    				$data[] = [
    					"user_id"		=> $user->id,
    					"point"			=> $point,
    					"description"	=> 'Mempublikasi konten',
    					"content_id"	=> $c->id,
    					"created_at"	=> $faker->dateTimeBetween('-1 years'),
    					"updated_at"	=> $faker->dateTimeBetween('-1 years'),
    				];
    				$total_point += $point;
    			}
    			DB::table('points')->insert($data);
    		}
    		DB::table('users')->where('id', $user->id)->update([
    			'point' => $total_point
    		]);
    	}
    }
}
