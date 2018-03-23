<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;

class SettingController extends Controller
{
	public function updatePageCount(Request $r)
	{
		$r->validate([
			'page_count' => 'required|numeric|min:10|max:300'
		]);
		Setting::where('key', 'page_count')->update(['value' => $r->page_count]);
		return 'Jumlah data per halaman berhasil diperbarui';
	}

	public function point()
	{
		return Setting::point();
	}

	public function updatePoint(Request $r)
	{
		$data = $r->only('get', 'min', 'schedule', 'result');
		Setting::updatePoint($data);
		return 'Pengaturan poin berhasil diperbarui';
	}

	public function upMember()
	{
		return Setting::upMember();
	}

	public function updateUpMember(Request $r)
	{
		$data = $r->only('one','three','six','twelve');
		Setting::updateUpMember($data);
		return 'Pengaturan upgrade member berhasil diperbarui';
	}

	public function web()
	{
		$web = collect(json_decode(Setting::where('key', 'web')->first()->value));
		return ['logo_full_url' => asset('storage/'.$web['logo'])]+$web->toArray();
	}

	public function setAbout()
	{
		return Setting::updateOrCreate([
			'key' => 'tentang'
		], [
			'value' => json_encode([
				'image' => 'laravel',
				'title' => 'Wiranusantara',
				'desc' => 'WiraNusantara.com merupakan sebuah media edukasi di bidang teknologi dan informasi dengan cita-cita bersama membangun bangsa dengan semangat kontribusi bersama. visi kami yaitu menjadi Solusi Teknologi Informasi dalam Layanan Digital dan Desain Berbisnis Online. Media ini dibuat sebagai sarana peningkatan kompetensi di era digital terutama dalam hal Pemprograman, Jaringan, Komputer,Multi Media, Desain, dan Bisnis. Media ini bisa digunakan oleh siapa saja yang ingin mengetahui mengenai Teknologi kekinian.',
				'btn' => [
					[
						'text' => 'Servis',
						'link' => '#'
					],
					[
						'text' => 'Produk',
						'link' => '#'
					],
				]
			])
		]);
	}

	public function setOurFocus()
	{
		return Setting::updateOrCreate([
			'key' => 'our_focus'
		], [
			'value' => json_encode([
				'title' => 'Our Focus',
				'sub_title' => 'Menjadi Solusi Teknologi Informasi dalam Layanan Digital Desain dan Berbisnis Online',
				'content' => [
					[
						'image' => 'images/gps.png',
						'caption' => 'Teknologi'
					],
					[
						'image' => 'images/desain.png',
						'caption' => 'Desain'
					],
					[
						'image' => 'images/digiadv.png',
						'caption' => 'Bisnis'
					],
					[
						'image' => 'images/wedev.png',
						'caption' => 'Startup'
					],
				]
			])
		]);
	}
}
