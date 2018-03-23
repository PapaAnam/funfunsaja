<?php 

function tahun($tgl)
{
	return substr($tgl, 0, 4);
}

function bulan($tgl)
{
	return substr($tgl, 5, 2);
}

function tgl($tgl)
{
	return substr($tgl, 8, 2);
}

function tglIndo($tgl)
{
	return tgl($tgl).' '.namaBulan(bulan($tgl)).' '.tahun($tgl);
}

function waktuIndo($tgl)
{
	return tglIndo($tgl).' '.substr($tgl, 11, 8);
}

function namaBulan($bulan){
	switch ($bulan) {
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

function status()
{
	return ['published', 'rejected', 'waiting', 'draft'];
}

function rp($duit)
{
	return number_format($duit, 0, ',', '.');
}

function apiRoute($controller)
{
	Route::get('/today', $controller.'@today');
	Route::get('/{year}/{month}', $controller.'@filter');
}

require_once('Api.php');

// function array_random($arr)
// {
// 	return $arr[array_rand($arr)];
// }

function upload($file, $path)
{
	return str_replace('public/', '', $file->store($path));
}