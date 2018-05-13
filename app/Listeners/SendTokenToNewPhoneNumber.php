<?php

namespace App\Listeners;

use App\Events\UpdatePhoneNumber;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTokenToNewPhoneNumber
{
    public function handle(UserCreated $event)
    {
        $user       = $event->user;
        $web        = Setting::web();
        $isi        = 'No HP Anda berhasil diubah. Silahkan cek email anda, untuk mendapatkan link Verifikasi dan masukkan token berikut '.$user->token_number.' untuk mengaktifkan akun anda. '.$web->title;
        $this->smsMe($event, $user->phone_number, $isi);
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
