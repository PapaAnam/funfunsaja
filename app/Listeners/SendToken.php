<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Setting;

class SendToken
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $user       = $event->user;
        $web        = Setting::web();
        $isi        = 'Silahkan cek email anda, untuk mendapatkan link Verifikasi dan masukkan token berikut '.$user->token_number.' untuk mengaktifkan akun anda. '.$web->title;
        // $this->kirimSms($event, $user->phone_number, $isi);
        $this->smsMe($event, $user->phone_number, $isi);
    }

    private function kirimSms($event, $recipient, $msg)
    {
        $url = "http://www.freesms4us.com/kirimsms.php";
        $username   = env('SMS_USERNAME', 'wiranusantara');
        $pass       = env('SMS_PASSWORD', 'jogja021214');
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, 'user='.$username.'&pass='.$pass.'&no='.$recipient.'&isi='.urlencode($isi));
        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        $results = curl_exec($curlHandle);
        curl_close($curlHandle);
    } 

    private function smsMe($event, $recipient, $msg)
    {
        $curl = curl_init(config('sms.api'));
        curl_setopt($curl, CURLOPT_POST, 1);
        $sms = Setting::sms();
        curl_setopt($curl, CURLOPT_POSTFIELDS, [
            'email'     => $sms->SMS_ME_EMAIL,
            'password'  => $sms->SMS_ME_PASSWORD,
            'device'    => $sms->SMS_ME_DEVICE,
            'number'    => $recipient,
            'name'      => 'Aktivasi Akun',
            'message'   => $msg
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($curl));
        curl_close($curl);
    }
}
