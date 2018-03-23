<?php

use Illuminate\Database\Seeder;

class DepositsTableSeeder extends Seeder
{
    private $COUNT = 50; // per user

    public function run()
    {
    	$faker          = \Faker\Factory::create('id_ID');
    	$users          = DB::table('users')->where('status', '1')->inRandomOrder()->get()->pluck('id')->toArray();
    	$banks          = DB::table('bank_accounts')->get()->pluck('id')->toArray();
    	$deposits = [];
    	for($i = 50000; $i < 2000000; $i+=50000){
    		$deposits[] = $i;
    	}
		DB::table('deposits')->truncate();
    	foreach(range(1, $this->COUNT) as $i):
    		$data = [];
    		foreach ($users as $user) {
    			$status = $faker->randomElement(['0', '1', '2']);
    			$data[] = [
    				"user_id"		=> $user,
    				"sender_name"	=> $faker->name,
    				"sender_bill"	=> $faker->numberBetween(1000000, 100000000).$faker->numberBetween(1000000, 100000000),
    				"deposit"		=> $faker->randomElement($deposits),
    				"receiver"		=> $faker->randomElement($banks),
    				"send_time"		=> $faker->dateTimeBetween('-1 years', '-1 days'),
    				"proof"			=> 'path/to/proof',
    				"status"		=> $status,
    				"reason"		=> $status === '2' ? 'Alasan ditolak. Dummy ... ' : '',
    				"created_at"	=> $faker->dateTimeBetween('-2 years'),
    				"updated_at"	=> $faker->dateTimeBetween('-2 years'),
    			];
    		}
    		DB::table('deposits')->insert($data);
    	endforeach;
    }
}
