<?php

use Illuminate\Database\Seeder;

class DepositClaimLogsTableSeeder extends Seeder
{
    private $TABLE = 'deposit_claim_logs';
    private $COUNT = 20; // per user
    public function run()
    {
        $faker          = \Faker\Factory::create('id_ID');
    	$users          = DB::table('users')->where('status', '1')->inRandomOrder()->get()->pluck('id')->toArray();
    	$deposits = [];
    	for($i = 50000; $i < 2000000; $i+=50000){
    		$deposits[] = $i;
    	}
		DB::table($this->TABLE)->truncate();
    	foreach(range(1, $this->COUNT) as $i):
    		$data = [];
    		foreach ($users as $user) {
    			$status = $faker->randomElement(['0', '1']);
    			$data[] = [
    				"user_id"		=> $user,
    				"deposit"		=> $faker->randomElement($deposits),
    				"status"		=> $status,
    				"created_at"	=> $faker->dateTimeBetween('-2 years'),
    				"updated_at"	=> $faker->dateTimeBetween('-2 years'),
    			];
    		}
    		DB::table($this->TABLE)->insert($data);
    	endforeach;
    }
}
