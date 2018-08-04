<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class UserBio extends Model
{
	protected $guarded = [];
	protected $appends = ['bd_view', 'gender_view', 'married_view', 'nin_upload_view', 'prov_name', 'city_name', 'region_name', 'village_name','status_ktp','nin_upload_link','photo_link'];

	public function prov()
	{
		return $this->belongsTo('App\Province', 'province_id', 'IDProvinsi');
	}

	public function city()
	{
		return $this->belongsTo('App\City', 'city_id', 'IDKabupaten');
	}

	public function region()
	{
		return $this->belongsTo('App\Region', 'region_id', 'IDKecamatan');
	}

	public function village()
	{
		return $this->belongsTo('App\Village', 'village_id', 'IDKelurahan');
	}

	public function getGenderViewAttribute()
	{
		return $this->gender == '0' ? 'Laki-laki' : 'Perempuan';
	}

	public function getMarriedViewAttribute()
	{
		return $this->married == '0' ? 'Nikah' : 'Belum Nikah';
	}

	public function getNinUploadViewAttribute()
	{
		return asset('storage/'.$this->nin_upload);
	}

	public function getBdViewAttribute()
	{
		$month = substr($this->birthdate, 5, 2);
		switch ($month) {
			case '01': $month = 'Januari'; break;
			case '02': $month = 'Februari'; break;
			case '03': $month = 'Maret'; break;
			case '04': $month = 'April'; break;
			case '05': $month = 'Mei'; break;
			case '06': $month = 'Juni'; break;
			case '07': $month = 'Juli'; break;
			case '08': $month = 'Agustus'; break;
			case '09': $month = 'September'; break;
			case '10': $month = 'Oktober'; break;
			case '11': $month = 'November'; break;
			case '12': $month = 'Desember'; break;
			default: $month = 'Tidak valid!!!'; break;
		}
		return substr($this->birthdate, 8, 2).' '.$month.' '.substr($this->birthdate,0,4);
	}

	public function getProvNameAttribute()
	{
		return $this->prov->Nama;
	}

	public function getCityNameAttribute()
	{
		return $this->city->Nama;
	}

	public function getRegionNameAttribute()
	{
		return $this->region->Nama;
	}

	public function getVillageNameAttribute()
	{
		return $this->village->Nama;
	}

	public function getPhotoLinkAttribute()
	{
		$value = $this->photo;
		if(!Storage::exists('public/'.$value) || $value === '' || $value === null){
			return asset('images/photo.jpg');
		}
		return asset('storage/'.$value);
	}

	public function getNinUploadLinkAttribute()
	{
		$value = $this->nin_upload;
		if(!Storage::exists('public/'.$value) || $value === '' || $value === null){
			return asset('images/contoh_ktp.jpeg');
		}
		return asset('storage/'.$value);
	}

	public function getStatusKtpAttribute()
	{
		if($this->nin_valid == 0){
			return 'Menunggu verifikasi';
		}elseif($this->nin_valid == 1){
			return 'Diterima';
		}
		return 'Ditolak';
	}
}
