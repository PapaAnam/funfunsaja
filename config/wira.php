<?php 
use Faker\Factory;
$faker = Factory::create('id_ID');
$token = str_random(3).$faker->randomElement(range(0,9)).$faker->randomElement(range(0,9)).str_random(2).$faker->randomElement(['$', '#', '*', '%', '&', '@']).str_random(2);
return [
	'verif_url' 	=> config('app.url').('/user-verification/'.md5(str_random(20))),
	'phone_token' 	=> $token,
];