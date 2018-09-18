<?php

use Illuminate\Database\Seeder;
use App\Setting;

class ContohSMS extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sms = Setting::sms();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => config('sms.api'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => "[  " . json_encode([
                'phone_number'=>'085322778935',
                'message'=>'Hai anam, apa kabar? sehat kan? semoga apa yang kamu inginkan tercapai. Amiin',
                'device_id'=>95703
            ]) . "]",
            CURLOPT_HTTPHEADER => array(
                "authorization: ".config('sms.token'),
                "cache-control: no-cache"
            ),
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = json_decode(curl_exec($curl),true);
        curl_close($curl);
    }
}
