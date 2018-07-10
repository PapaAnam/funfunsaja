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
        $this->smsMe($event, $user->phone_number, $isi);
    }

    private function smsMe($event, $recipient, $msg)
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
                'phone_number'=>$recipient,
                'message'=>$msg,
                'device_id'=>$sms['SMS_ME_DEVICE']
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
