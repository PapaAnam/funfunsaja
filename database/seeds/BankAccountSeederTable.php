<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

class BankAccountSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $faker = Factory::create('id_ID');
        $data = [];
        $banks = ['BNI', 'BRI', 'BCA', 'BTN', 'BANK MEGA'];
        foreach ($banks as $i) {
            $data[] = [
                'owner' => $faker->name,
                'bill_number' => $faker->numberBetween(100000, 999999).$faker->numberBetween(100000, 999999),
                'branch' => $faker->city.' '.$faker->numberBetween(0, 20),
                'bank' => $i
            ];
        }
    	DB::table('bank_accounts')->truncate();
        DB::table('bank_accounts')->insert($data);
    }
}
