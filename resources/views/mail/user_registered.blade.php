<!DOCTYPE html>
<html>
<head>
	<title>Verifikasi akun</title>
</head>
<body>
Selamat anda berhasil mendaftar di <a href="{{ config('app.url', 'https://funzy.id') }}">{{ $_web->title }}</a>. Ikuti link ini untuk mengaktifkan akun anda {{ $user->verification_url }}
</body>
</html>