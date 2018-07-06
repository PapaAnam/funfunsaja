<?php

use Illuminate\Database\Seeder;
use App\Setting;

class SetDefaultSmsMeGateway extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::updateOrCreate([
        	'key'=>'sms'
        ], [
        	'value'=>'{"SMS_ME_EMAIL":"funzy.com@gmail.com","SMS_ME_PASSWORD":"Jogja021214","SMS_ME_DEVICE":"038083298932"}'
        ]);
    }
}
