<div class="row">
	<div class="col-md-12">
		@if($my_bio)
		@if($biography)
		<my-cv>
			<h1>CURRICULUM <span class="blue">VITAE</span></h1>
			<img class="gambar" src="{{ $my_bio->photo_link }}">
			<table>
				<tbody>
					@if($my_bio)
					<tr>
						<td width="200px">Nama</td>
						<td>: {{ $my_bio->name }}</td>
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
					@endif
					@if($user)
					<tr>
						<td>Telephone</td>
						<td>: {{ $user['phone_number'] }}</td>
					</tr>
					<tr>
						<td>Email</td>
						<td>: <span class="email">{{ $user['email'] }}</span></td>
					</tr>
					@endif
				</tbody>
			</table>
			@if($biography)
			<h3 class="fancy"><span>KONTAK</span></h3>
			{!! $biography->contact !!}
			<h3 class="fancy"><span>MEDIA SOSIAL</span></h3>
			{!! $biography->social_media !!}
			@endif
			@if($biodata)
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
			@endif
			@if($biography)
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
			@endif
		</my-cv>
		<center>
			@if($user && $biodata && $biography && $my_bio)
			<a href="{{ route('cv.print') }}" style="margin-top: -30px" target="_blank" class="btn btn-secondary"><i class="fa fa-print"></i> Cetak</a>
			@else
			<a href="#" style="margin-top: -30px" class="btn btn-danger"><i class="fa fa-exclamation"></i> Data Belum Lengkap</a>
			@endif
		</center>
		@else
		@component('alert')
		@if(Auth::guard('admin')->check())
		Member belum melengkapi biografi
		@else
		Lengkapi biografi anda
		@endif
		@endcomponent
		@endif
		@else
		@component('alert')
		@if(Auth::guard('admin')->check())
		Member belum melengkapi profil
		@else
		Lengkapi profil anda
		@endif
		@endcomponent
		@endif
	</div>
</div>