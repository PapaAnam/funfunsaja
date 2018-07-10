<!DOCTYPE html>
<html>
<head>
	<title>Verifikasi akun anda</title>
</head>
<body>
Selamat anda berhasil mengganti email anda di <a href="{{ config('app.url', 'https://funzy.id') }}">{{ $_web->title }}</a>. Ikuti link ini untuk mengaktifkan akun anda kembali {{ $user->verification_url }}
</body>
</html>