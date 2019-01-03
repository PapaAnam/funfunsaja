<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Storage;

class User extends Authenticatable
{
    use Notifiable;

    protected $appends = ['tgl_lhr', 'saldo_view', 'dibuat_pada', 'terakhir_login', 'status_text','avatar_link', 'balance_in_rp'];
    protected $casts = [
        'is_premium'    => 'boolean'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    private function month($date){
        $month = substr($date, 5, 2);
        switch ($month) {
            case '01': return 'Januari'; break;
            case '02': return 'Februari'; break;
            case '03': return 'Maret'; break;
            case '04': return 'April'; break;
            case '05': return 'Mei'; break;
            case '06': return 'Juni'; break;
            case '07': return 'Juli'; break;
            case '08': return 'Agustus'; break;
            case '09': return 'September'; break;
            case '10': return 'Oktober'; break;
            case '11': return 'November'; break;
            case '12': return 'Desember'; break;
            default: return 'Tidak valid!!!'; break;
        }
    }

    public function getAvatarLinkAttribute(){
        $value = $this->avatar;
        $default = asset('images/user-default.png');
        if(config('app.env') === 'production'){
            return Storage::exists('public/'.$value) && $value ? asset('storage/'.$value) : 'https://www.gravatar.com/avatar/'.md5($this->email).'?d=wavatar&s=200';
        }
        return Storage::exists('public/'.$value) && $value ? asset('storage/'.$value) : $default;
    }

    public function getTglLhrAttribute()
    {
        return substr($this->tanggal_lahir, 8, 2).' '.$this->month($this->tanggal_lahir).' '.substr($this->tanggal_lahir, 0, 4);
    }

    public function getSaldoViewAttribute()
    {
        return number_format($this->saldo, 0, ',', '.');
    }

    public function prov()
    {
        return $this->belongsTo('App\Province', 'id_prov', 'IDProvinsi');
    }

    public function city()
    {
        return $this->belongsTo('App\City', 'id_kabkota', 'IDKabupaten');
    }

    public function region()
    {
        return $this->belongsTo('App\Region', 'id_kec', 'IDKecamatan');
    }

    public function village()
    {
        return $this->belongsTo('App\Village', 'id_kel', 'IDKelurahan');
    }

    public function bank()
    {
        return $this->hasMany('App\UserBank', 'user_id');
    }

    public function bio()
    {
        return $this->hasMany('App\UserBio', 'user_id');
    }

    public function biodata()
    {
        return $this->hasMany('App\UserBiodata', 'user_id');
    }

    public function biography()
    {
        return $this->hasMany('App\UserBiography', 'user_id');
    }

    public function scopeUsername($q)
    {
        $users = $q->where('status', '1')->where('username', '!=', null)->get()->pluck('username');
        $u = [];
        foreach ($users as $s) {
            if(preg_match('[@]', $s))
                continue;
            $u[] = $s;
        }
        return $u;
    }

    public function notif()
    {
        return $this->hasMany('App\Notification', 'to_id');
    }

    public function boughtContent()
    {
        return $this->hasMany('App\BoughtContent');
    }

    public function contents()
    {
        return $this->hasMany('App\Content');
    }

    public function getIsPremiumAttribute($value)
    {
        return $value === '1';
    }

    public function premiumLogs()
    {
        return $this->hasMany('App\PremiumLog');
    }

    public function activities()
    {
        return $this->hasMany('App\Activity');
    }

    public function depoClaimLogs()
    {
        return $this->hasMany('App\DepositClaimLog');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function feedbackComments()
    {
        return $this->hasMany('App\FeedbackComment');
    }

    public function getDibuatPadaAttribute()
    {
        return tglIndo($this->created_at);
    }

    public function getTerakhirLoginAttribute()
    {
        return preg_match('[valid]', tglIndo($this->last_login)) ? 'Belum Pernah' : tglIndo($this->last_login);
    }

    public function getStatusTextAttribute()
    {
        if($this->status == 0){
            return 'Menunggu verifikasi';
        }elseif($this->status == 1){
            return 'Aktif';
        }else{
            return 'Non aktif';
        }
    }

    public function transaksiSaldo()
    {
        return $this->hasMany('App\DepositTransaction');
    }

    public function getBalanceInRpAttribute()
    {
        return number_format($this->balance, 0, ',', '.');
    }
}
