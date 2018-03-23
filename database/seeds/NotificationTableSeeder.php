<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

class NotificationTableSeeder extends Seeder
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
    		$msg 	= 'Selamat pembelian deposit sebesar 50000 berhasil diverifikasi dan dimasukkan ke dalam saldo anda. <a href="'.route('my_deposit').'">Deposit Saya</a>';
    		$title 	= 'Deposit diterima';
    		$type 	= 'success';
    		$status = $faker->randomElement(range(1,2));
    		if($status != 1){
    			$title 	= 'Deposit ditolak';
    			$msg = 'Pembelian deposit sebesar 50000 gagal dilakukan. <a href="'.route('my_deposit').'">Deposit Saya</a>';
    			$type 	= 'danger';
    		}
    		$data[] = [
    			'title' 		=> $title,
    			'content'		=> $msg,
    			'to_id'			=> '38',
    			'from_id'		=> '2',
    			'from_type'		=> '1',
    			'type'			=> $type,
    			'created_at'	=> now(),
    			'updated_at'	=> now(),
    		];
    	}
    	DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    	DB::table('notifications')->truncate();
    	DB::table('notifications')->insert($data);
    }
}
