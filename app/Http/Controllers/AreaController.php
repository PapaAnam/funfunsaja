<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\Region;
use App\Village;

class AreaController extends Controller
{
    public function cities($province)
    {
    	return City::where('IDProvinsi', $province)->orderBy('Nama')->get();
    }

    public function regions($city)
    {
    	return Region::where('IDKabupaten', $city)->orderBy('Nama')->get();
    }

    public function villages($region)
    {
    	return Village::where('IDKecamatan', $region)->orderBy('Nama')->get();
    }
}
