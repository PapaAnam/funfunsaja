<!DOCTYPE html>
<html>
<head>
	<title>CV Print</title>
	<style>
	body {
		font-family: 'Open Sans', sans-serif;
	}
	.cv h1 {
		text-align: center;
	}
	.cv {
		border: 5px solid blue;
		padding: 20px;
	}
	.email {
		color: blue; text-decoration: underline;
	}
	h3 {
		color: blue;
	}
	h3 span:before {
		width: 200px;
		border-bottom: 3px solid blue;
		content: "";
	}
	h3 span:after {
		width: 800px;
		border-bottom: 3px solid blue;
		content: "";
	}
	.blue {
		color : blue;
	}
	table {
		width: 80%;
	}
	.fancy {
		line-height: 1;
		margin-left: 70px;
	}
	.fancy span {
		display: inline-block;
		position: relative;
	}
	.fancy span:before, .fancy span:after {
		content: "";
		position: absolute;
		height: 10px;
		border-bottom: 2px solid blue;
		/*top: 0;*/
	}
	.fancy span:before {
		right: 100%;
		margin-right: 10px;
		width: 50px;
	}
	.fancy span:after {
		left: 100%;
		margin-left: 10px;
		width: 300px;
	}
	.gambar {
		position: absolute;
		top: 120px;
		right: 50px;
		max-width: 100px;
		border: 2px solid black;
		padding: 3px;
	}
	.bb {
		margin-left: 20px;
	}
</style>
</head>
<body>
	<div class="cv">
		<h1>CURRICULUM <span class="blue">VITAE</span></h1>
		<img class="gambar" src="{{ $my_bio->photo_link }}">
		<table>
			<tbody>
				<tr>
					<td width="200px">Nama</td>
					<td width="400px">: {{ $my_bio->name }}</td>
				</tr>
				<tr>
					<td>NIK</td>
					<td>: {{ $my_bio->nin }}</td>
				</tr>
				<tr>
					<td>Tempat, Tanggal Lahir</td>
					<td>: {{ $my_bio->city_born.', '.$my_bio->birthdate }}</td>
				</tr>
				<tr>
					<td>Jenis Kelamin</td>
					<td>: {{ $my_bio->gender_view }}</td>
				</tr>
				<tr>
					<td>Status</td>
					<td>: {{ $my_bio->married_view }}</td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td>: {{ $my_bio->address }}</td>
				</tr>
				<tr>
					<td>Telephone</td>
					<td>: {{ $user['phone_number'] }}</td>
				</tr>
				<tr>
					<td>Email</td>
					<td>: <span class="email">{{ $user['email'] }}</span></td>
				</tr>
			</tbody>
		</table>
		<h3 class="fancy"><span>KONTAK</span></h3>
		{!! $biography->contact !!}
		<h3 class="fancy"><span>MEDIA SOSIAL</span></h3>
		{!! $biography->social_media !!}
		<h3 class="fancy"><span>SKILL / KEMAMPUAN</span></h3>
		<ul>
			@foreach (explode(',', $biodata->skill) as $b)
			<li>{{ $b }}</li>
			@endforeach
		</ul>
		<h3 class="fancy"><span>PASSION / MINAT</span></h3>
		<ul>
			@foreach (explode(',', $biodata->passion) as $b)
			<li>{{ $b }}</li>
			@endforeach
		</ul>
		<h3 class="fancy"><span>HOBI</span></h3>
		<ul>
			@foreach (explode(',', $biodata->hobby) as $b)
			<li>{{ $b }}</li>
			@endforeach
		</ul>
		<h3 class="fancy"><span>BAHASA</span></h3>
		<ul>
			@foreach (explode(',', $biodata->language) as $b)
			<li>{{ $b }}</li>
			@endforeach
		</ul>
		<h3 class="fancy"><span>KARAKTER</span></h3>
		<ul>
			@foreach (explode(',', $biodata->character) as $b)
			<li>{{ $b }}</li>
			@endforeach
		</ul>
		<h3 class="fancy"><span>PENDIDIKAN</span></h3>
		<div class="bb">{!! $biography->education !!}</div>
		<h3 class="fancy"><span>PENGALAMAN KERJA</span></h3>
		<div class="bb">{!! $biography->work_experience !!}</div>
		<h3 class="fancy"><span>SERTIFIKAT</span></h3>
		<div class="bb">{!! $biography->certificate !!}</div>
		<h3 class="fancy"><span>PENGHARGAAN</span></h3>
		<div class="bb">{!! $biography->appreciation !!}</div>
		<h3 class="fancy"><span>ORGANISASI</span></h3>
		<div class="bb">{!! $biography->organization !!}</div>
		<h3 class="fancy"><span>PORTOFOLIO</span></h3>
		<div class="bb">{!! $biography->portfolio !!}</div>
	</div>
	<script>
		window.print()
	</script>
</body>
</html>