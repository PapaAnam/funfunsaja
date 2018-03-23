<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

class ActivityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker 	= Factory::create('id_ID');
    	$data 	= [];
    	foreach (range(1,50) as $i) {
    		$data[] = [
    			'title' 		=> 'Beli Deposit',
    			'content'		=> 'Membeli deposit sebesar 50000',
    			'user_id'		=> '38',
    			'created_at'	=> $faker->datetime,
    			'updated_at'	=> now(),
    		];
    	}
    	DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    	DB::table('activities')->truncate();
    	DB::table('activities')->insert($data);
    }
}
