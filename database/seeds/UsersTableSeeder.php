<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

class UsersTableSeeder extends Seeder
{

    private $COUNT  = 200;
    private $faker  = null;
    private $ua     = null;

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $faker          = Factory::create('id_ID');
        $this->faker    = $faker;
        $this->users();
        $ua             = DB::table('users')->where('status', '1')->get();
        $this->ua       = $ua;
        
        $this->biodatas();
        $this->bank_accounts();
        $this->bios();
        $this->biographies();
        
    }

    private function random($arr, $jml)
    {
        $temp = [];
        foreach(range(1, $jml) as $i){
            $item = $this->faker->randomElement($arr);
            if(!in_array($item, $temp))
                $temp[] = $item;
        }
        return implode($temp, ', ');
    }

    private function users()
    {
        $faker = $this->faker;
        $data            = [];
        foreach (range(1, $this->COUNT) as $i) {
            $token           = str_random(3).$faker->randomElement(range(0,9)).$faker->randomElement(range(0,9)).str_random(2).$faker->randomElement(['$', '#', '*', '%', '&', '@']).str_random(2);
            $email           = $faker->unique()->email;
            $data[] = [
                "email"                  => $email,
                "password"               => bcrypt($email),
                "avatar"                 => 'path/to/img',
                "web"                    => $faker->unique()->domainName,
                "wrong_login"            => 0,
                "balance"                => round($faker->numberBetween(50000, 5000000), -3),
                "token_number"           => $token,
                "verification_url"       => config('app.url').('/user-verification/'.md5(str_random(20))),
                "last_time_to_verify"    => $faker->dateTimeBetween('-2 days', '+2 days'),
                "created_at"             => $faker->dateTimeBetween('-1 years'),
                "updated_at"             => now(),
                "phone_number"           => $faker->unique()->phoneNumber,
                "status"                 => (String) $faker->randomElement(range(0,2)),
                "username"               => $faker->unique()->username,
                "description"            => $faker->text,
                "point"                  => 0,
            ];
        }
        DB::table('users')->truncate();
        foreach (array_chunk($data, 4) as $d) {
            DB::table('users')->insert($d);
        }
    }

    private function bank_accounts()
    {
        $bank_accounts  = [];
        $faker          = $this->faker;
        foreach ($this->ua as $user) {
            $bank_accounts[] = [
                "user_id"       => $user->id,
                "on_name"       => $faker->name,
                "bank"          => $faker->randomElement(['BNI', 'BCA', 'BRI', 'BTN', 'MANDIRI']),
                "bill_number"   => $faker->numberBetween(1000000, 100000000).$faker->numberBetween(1000000, 100000000),
                "branch"        => $faker->city,
                "city"          => $faker->city,
                "status"        => '1',
                "created_at"    => $user->created_at,
                "updated_at"    => $user->updated_at,
            ];
        }
        DB::table('user_bank_accounts')->truncate();
        foreach (array_chunk($bank_accounts, 4) as $d) {
            DB::table('user_bank_accounts')->insert($d);
        }
    }

    private function biodatas()
    {
        $skills = [
            'office', 'data mining', 'web develop', 'game develop', 'android', 'windows', 'linux', 'hacking', 'security', 'photoshop', 'corel draw', 'backend', 'engineer', 'it consultant'
        ];

        $hobbies = [
            'nonton', 'menulis', 'traveling', 'otomotif', 'desain grafis', 'fotografi', 'kuliner', 'memasak', 'olahraga', 'pecinta batu', 'kerajinan tangan', 'kolektor', 'programming', 'kliping', 'bersepeda', 'fashion', 'bercocok tanam', 'mancing', 'musik', 'melukis', 'menggambar', 'ngeblog', 'hewan peliharaan', 'rekam video', 'elektronik', 'komputer', 'main game', 
        ];
        $passions = $hobbies;
        $countries = [
            'Afghanistan', 'Albania', 'Aljazair', 'Andorra', 'Angola', 'Antigua dan Barbuda', 'Argentina', 'Armenia', 'Australia', 'Austria', 'Azerbaijan', 'Bahama', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgia', 'Belize', 'Benin', 'Bhutan', 'Bolivia', 'Bosnia-Herzegovina', 'Botswana', 'Brasil', 'Brunei Darussalam', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Kamboja', 'Kamerun', 'Kanada', 'Cape Verde', 'Afrika Tengah', 'Chad', 'Chile', 'Cina', 'Kolombia', 'Komoro', 'Kongo', 'Kosta Rika', 'Pantai Gading', 'Kroasia', 'Kuba', 'Siprus', 'Republik Ceko', 'Denmark', 'Djibouti', 'Dominika', 'Republik Dominika', 'Timor Leste', 'Ekuador', 'Mesir', 'El Salvador', 'Guinea Ekuatorial', 'Eritrea', 'Estonia', 'Ethiopia', 'Fiji', 'Finlandia', 'Prancis', 'Gabon', 'Gambia', 'Georgia', 'Jerman', 'Ghana', 'Yunani', 'Grenada', 'Guatemala', 'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti', 'Honduras', 'Hongaria', 'Islandia', 'India', 'Indonesia', 'Iran', 'Irak', 'Irlandia', 'Israel', 'Italia', 'Jamaika', 'Jepang', 'Yordania', 'Kazakhstan', 'Kenya', 'Kiribati', 'Korea Utara', 'Korea Selatan', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon', 'Libya', 'Liechtenstein', 'Luxembourg', 'Macedonia', 'Madagaskar', 'Malawi', 'Malaysia', 'Maladewa', 'Mali', 'Malta', 'Kepulauan Marshall', 'Mauritania', 'Mauritius', 'Meksiko', 'Federasi Mikronesia', 'Moldova', 'Monako', 'Mongolia', 'Montenegro', 'Maroko', 'Mozambik', 'Myanmar', 'Namibia', 'Nauru', 'Nepal', 'Belanda', 'Selandia Baru', 'Nikaragua', 'Niger', 'Nigeria', 'Norwegia', 'Oman', 'Pakistan', 'Palau', 'Panama', 'Papua Nugini', 'Paraguay', 'Peru', 'Filipina', 'Polandia', 'Portugal', 'Qatar', 'Romania', 'Rusia', 'Rwanda', 'Saint Kitts dan Nevis', 'Saint Lucia', 'Saint Vincent dan  Grenadines', 'Samoa', 'San Marino', 'Sao Tome dan Principe', 'Arab Saudi', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leone', 'Singapura', 'Slovakia', 'Slovenia', 'Kepulauan Solomon', 'Somalia', 'Afrika Selatan', 'Spanyol', 'Sri Lanka', 'Sudan', 'Suriname', 'Swaziland', 'Swedia', 'Swiss', 'Suriah', 'Tajikistan', 'Tanzania', 'Thailand', 'Togo', 'Tonga', 'Trinidad dan Tobago', 'Tunisia', 'Turki', 'Turkmenistan', 'Tuvalu', 'Uganda', 'Ukraina', 'Uni Emirat Arab', 'Inggris', 'Amerika Serikat', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Vatikan', 'Venezuela', 'Vietnam', 'Yaman', 'Zambia', 'Zimbabwe',
        ];

        $characters = [
            'Jujur', 'Amanah (Dapat Dipercaya)', 'Berprasangka Baik', 'Rajin', 'Supel / Mudah Bergaul', 'Berani', 'Rendah Hati', 'Suka Menolong', 'Sopan dan Santun', 'Rajin Menabung', 'Bijaksana', 'Adil', 'Pintar / Pandai', 'Rapi', 'Peduli dengan Sesama / Sekitar', 'Dermawan', 'Mudah Mengalah', 'Berjiwa Sosial', 'Periang', 'Pembaharu', 'Sabar', 'Penyayang', 'Setia Terhadap Pasangan', 'Patuh / Taat', 'Sholeh (Beriman dan Bertakwa)', 'Optimis', 'Penghangat Suasana / Penggembira', 'Cekatan / Gesit / Luwes', 'Teliti', 'Berpikir Positif', 'Tekun', 'Terbuka', 'Bersih', 'Bersahaja / Sederhana', 'Pengertian', 'Murah Hati', 'Teladan', 'Berprestasi', 'Pemaaf', 'Bersemangat', 'Tegas', 'Solider', 'Toleran', 'Hemat', 'Kreatif dan Inovatif', 'Kuat', 'Hati-Hati / Waspada', 'Tertib', 'Perhatian', 'Percaya Diri', "Supel atau Mudah Bergaul", "Sombong", "Labil", "Optimis", "Humoris", "Kreatif", "Minder", "Cari Perhatian", "Pendendam", " Sulit memaafkan", " Perfeksionis", " Pesimis", " Hard to Please", " Terlalu Sensitif", " Negative Attitude ", " Penyendiri", " Moody", " Mandiri", " Egois", " Ambisius", " Helper", " Kritis", " Bossy", " Pembangkang", " Rendah Hati", " Jujur", " Dermawan", " Pelit", " Keras Kepala", " Setia", " Pendusta", " Bijaksana", " Tempramental", " Sopan", " Berjiwa Besar",         
        ];

        $countries = collect($countries)->transform(function($item){
            return 'Bahasa '.$item;
        })->toArray();

        $faker = $this->faker;
        $biodatas = [];
        foreach ($this->ua as $user) {
            $biodatas[] = [
                "user_id"       => $user->id,
                "status"        => '1',
                "created_at"    => $user->created_at,
                "updated_at"    => $user->updated_at,
                "skill"         => $this->random($skills, $faker->numberBetween(2, 6)),
                "passion"       => $this->random($passions, $faker->numberBetween(2, 6)),
                "hobby"         => $this->random($hobbies, $faker->numberBetween(2, 6)),
                "language"      => $this->random($countries, $faker->numberBetween(2, 6)),
                "character"     => $this->random($characters, $faker->numberBetween(2, 6)),
            ];
        }
        DB::table('user_biodatas')->truncate();
        foreach (array_chunk($biodatas, 4) as $d) {
            DB::table('user_biodatas')->insert($d);
        }
    }

    private function bios()
    {
        $bios       = [];
        $faker      = $this->faker;
        $provinces  = DB::table('area_provinces')->get()->pluck('IDProvinsi')->toArray();
        foreach ($this->ua as $user) {
            $gender = $faker->randomElement(['0', '1']);
            $g      = $gender == '0' ? 'male' : 'female';
            $prov   = $faker->randomElement($provinces);
            $kota   = DB::table('area_cities')->where('IDProvinsi', $prov)->inRandomOrder()->first()->IDKabupaten;
            $kec    = DB::table('area_regions')->where('IDKabupaten', $kota)->inRandomOrder()->first()->IDKecamatan;
            $desa   = DB::table('area_villages')->where('IDKecamatan', $kec)->inRandomOrder()->first()->IDKelurahan;
            $bios[] = [
                "user_id"       => $user->id,
                "status"        => '1',
                "created_at"    => $user->created_at,
                "updated_at"    => $user->updated_at,
                "nin"           => $faker->unique()->nik,
                "name"          => $faker->unique()->name($g),
                "city_born"     => $faker->city,
                "birthdate"     => $faker->dateTimeBetween('-40 years', '-15 years'),
                "gender"        => $gender,
                "address"       => $faker->address,
                "province_id"   => $prov,
                "city_id"       => $kota,
                "region_id"     => $kec,
                "village_id"    => $desa,
                "post_code"     => $faker->numberBetween(10000, 99999),
                "married"       => $faker->randomElement(['0', '1']),
                "nin_upload"    => 'nin-upload/path/to',
                "nin_valid"     => $faker->randomElement(['0', '1']),
                "photo"         => 'photo/path/to',
            ];
        }
        DB::table('user_bios')->truncate();
        foreach (array_chunk($bios, 4) as $d) {
            DB::table('user_bios')->insert($d);
        }
    }

    private function biographies()
    {
        $bios       = [];
        $faker      = $this->faker;
        $educations = ['S1 Bimbingan dan Konseling','S2 Bimbingan dan Konseling','S3 Bimbingan dan Konseling','S1 Teknologi Pendidikan','S2 Teknologi Pembelajaran','S3 Teknologi Pembelajaran','S1 Administrasi Pendidikan','S2 Manajemen Pendidikan','S3 Manajemen Pendidikan','S1 Pendidikan Luar Sekolah','S2 Pendidikan Luar Sekolah','S3 Pendidikan Luar Sekolah','S1 Pendidikan Guru Sekolah Dasar','S1 Pendidikan Guru Pendidikan Anak Usia Dini','S2 Pendidikan Dasar','S2 Pendidikan Anak Usia Dini','S1 Pendidikan Luar Biasa','S2 Pendidikan Khusus','S1 Pendidikan Bahasa Sastra Indonesia dan Daerah','S1 Bahasa dan Sastra Indonesia','S2 Pendidikan Bahasa Indonesia','S3 Pendidikan Bahasa Indonesia','S2 Keguruan Bahasa','S1 Ilmu Perpustakaan','D3 Perpustakaan','S1 Pendidikan Bahasa Inggris','S1 Bahasa dan Sastra Inggris','S2 Pendidikan Bahasa Inggris','S3 Pendidikan Bahasa Inggris','S1 Pendidikan Bahasa Arab','S2 Pendidikan Bahasa Arab','S1 Pendidikan Bahasa Jerman','S1 Pendidikan Bahasa Mandarin','S1 Pendidikan Seni Rupa','S2 Keguruan Seni Rupa','S1 Pendidikan Seni Tari dan Musik','S1 Desain Komunikasi Visual','D3 Game Animasi','S1 Pendidikan Matematika','S1 Matematika','S2 Pendidikan Matematika','S3 Pendidikan Matematika','S1 Pendidikan Fisika','S1 Fisika','S2 Pendidikan Fisika','S2 Fisika','S1 Pendidikan Kimia','S1 Kimia','S2 Pendidikan Kimia','S3 Pendidikan Kimia','S1 Pendidikan Biologi','S1 Biologi','S2 Biologi','S2 Pendidikan Biologi','S3 Pendidikan Biologi','S1 Pendidikan Tata Niaga','S1 Pendidikan Administrasi Perkantoran','S1 Manajemen','D3 Manajemen Pemasaran','S2 Pendidikan Bisnis dan Manajemen','S2 Manajemen','S1 Pendidikan Akuntansi','S1 Akuntansi','S2 Akuntansi','D3 Akuntansi','S1 Pendidikan Ekonomi','S1 Ekonomi dan Studi Pembangunan','S2 Ilmu Ekonomi','S2 Pendidikan Ekonomi','S3 Pendidikan Ekonomi','S1 Pendidikan Teknik Mesin','S1 Pendidikan Teknik Otomotif','S1 Teknik Mesin','S2 Teknik Mesin','D3 Teknik Mesin','D3 Mesin Otomotif','S1 Teknik Industri','S1 Pendidikan Teknik Bangunan','D3 Teknik Sipil dan Bangunan ','S1 Teknik Sipil','S2 Teknik Sipil','D3 Teknik Elektro','D3 Teknik Elektronika','S1 Pendidikan Teknik Informatika','S1 Pendidikan Teknik Elektro','S1 Teknik Elektro','S1 Teknik Informatika','D3 Tata Boga','D3 Tata Busana','S1 Pendidikan Tata Boga','S1 Pendidikan Tata Busana','S2 Pendidikan Kejuruan','Konsentrasi Teknik Mesin','Konsentrasi Teknik Sipil dan Bangunan','Konsentrasi Teknik Elektro','Konsentrasi Teknik Informatika','Konsentrasi Tata Busana dan Tata Boga','S3 Pendidikan Kejuruan','S1 Pendidikan Jasmani dan Kesehatan','S1 Pendidikan Kepelatihan Olahraga','S1 Ilmu Keolahragaan ','S2 Pendidikan Olahraga','S1 Ilmu Kesehatan Masyarakat','S1 Pendidikan Pancasila dan Kewarganegaraan (PPKn)','S2 Pendidikan Pancasila dan Kewarganegaraan (PPKn)','S1 Geografi','S1 Pendidikan Geografi','S2 Pendidikan Geografi','S3 Pendidikan Geografi','S1 Pendidikan Sejarah','S2 Pendidikan Sejarah','S1 Ilmu Sejarah','S1 Pendidikan Sosiologi','S1 Pendidikan Ilmu Pengetahuan Sosial','S1 Psikologi','S3 Psikologi Pendidikan','Konsentrasi IPA','Kosentrasi IPS','Konsentrasi Bahasa Indonesia','Konsentrasi Matematika','Kosentrasi PKn','Konsentrasi Guru Kelas','Konsentrasi Guru PAUD','Konsentrasi Pendidikan Luar Biasa',];
        foreach ($this->ua as $user) {
            $sosmed = 'Facebook : http://www.facebook.com/'.$user->username.'<br>
            Twitter : http://www.twitter.com/'.$user->username;
            $contact = 'No HP : '.$user->phone_number.'<br>
            Email : '.$user->email;
            $bios[] = [
                "user_id"           => $user->id,
                "status"            => '1',
                "created_at"        => $user->created_at,
                "updated_at"        => $user->updated_at,
                "social_media"      => $sosmed,
                "contact"           => $contact,
                "education"         => $faker->randomElement($educations),
                "work_experience"   => 'Ini hanya data dummy untuk testing',
                "certificate"       => 'Ini hanya data dummy untuk testing',
                "appreciation"      => 'Ini hanya data dummy untuk testing',
                "organization"      => 'Ini hanya data dummy untuk testing',
                "portfolio"         => 'Ini hanya data dummy untuk testing',
            ];
        }
        DB::table('user_biographies')->truncate();
        foreach (array_chunk($bios, 4) as $d) {
            DB::table('user_biographies')->insert($d);
        }
    }
}