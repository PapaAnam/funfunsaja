<?php

namespace App\Listeners;

use App\Events\SendLinkAndSms;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Setting;

class SendSms
{
    
    public function handle(SendLinkAndSms $event)
    {
        $web        = Setting::web();
        $message = '';
        if($event->email_type == 'forgot_password'){
            $message = 'Password berhasil direset. Silahkan cek email anda, untuk mendapatkan link Verifikasi dan masukkan token berikut '.$event->user->token_number.' untuk mengaktifkan akun anda kembali. '.$web->title;
        }elseif($event->email_type == 'update_phone_number'){
            $message = 'No Hp berhasil diubah. Silahkan cek email anda, untuk mendapatkan link Verifikasi dan masukkan token berikut '.$event->user->token_number.' untuk mengaktifkan akun anda kembali. '.$web->title;
        }elseif($event->email_type == 'update_email'){
            $message = 'Email berhasil diubah. Silahkan cek email anda, untuk mendapatkan link Verifikasi dan masukkan token berikut '.$event->user->token_number.' untuk mengaktifkan akun anda kembali. '.$web->title;
        }elseif($event->email_type == 'update_password'){
            $message = 'Password berhasil diubah. Silahkan cek email anda, untuk mendapatkan link Verifikasi dan masukkan token berikut '.$event->user->token_number.' untuk mengaktifkan akun anda kembali. '.$web->title;
        }
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
                'phone_number'=>$event->user->phone_number,
                'message'=>$message,
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
