@extends('layouts.app', ['title' => 'Daftar User'])
@section('content')
<br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h4>Daftar User</h4>
			<hr>
			<div class="row">
				@include('contents.search-form')
			</div>
		</div>
		<div class="col-lg-9 col-md-12">
			@if(request()->query('keyword'))
			<div class="alert alert-info">
				Menampilkan hasil pencarian dengan kata kunci <strong>{{ request()->query('keyword') }}</strong>
			</div>
			@endif
			@if(count($data) > 0)
			<div class="row">
				@foreach ($data as $a)
				<div class="col-md-6 mb-5">
					<div class="card">
						<div class="card-header">
							<i class="fa fa-user"></i>&nbsp;&nbsp;&nbsp;
							@if($a->username)
							<a class="text-dark" href="{{ url('/profile/'.$a->username) }}">{{ $a->username }}</a>
							@else
							{{ $a->email }}
							@endif
						</div>
						<div class="card-body" style="margin: 0;">
							<dl class="row">
								<table class="table m0">
									<tbody>
										<tr>
											<td><strong>Nama Lengkap</strong></td>
											<td>
												@if(count($a->bio))
												{{ $a->bio[0]->name }}
												@else
												<span class="badge badge-danger">
													Belum diisi
												</span>
												@endif
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<strong>Deskripsi</strong>
												<p align="justify" class="mt-2">
													@if($a->description)
													{!! $a->description !!}
													@else
													<span class="badge badge-danger">
														Deskripsi belum diisi
													</span>
													@endif
												</p>
											</td>
										</tr>
										<tr>
											<td><strong>Jumlah Konten</strong></td>
											<td>
												<span class="badge @if($a->contents_count > 0) badge-primary @else badge-danger @endif">
													{{ $a->contents_count }}		
												</span>
											</td>
										</tr>
										<tr>
											<td><strong>Jumlah View</strong></td>
											<td>
												@php
												$view = DB::table('contents')->where('user_id', $a->id)->sum('hit');
												@endphp
												<span class="badge @if($view > 0) badge-primary @else badge-danger @endif">
													{{ $view }}		
												</span>
											</td>
										</tr>
										<tr>
											<td><strong>Daftar Pada</strong></td>
											<td>
												{{ $a->dibuat_pada }}		
											</td>
										</tr>
										<tr>
											<td><strong>Status</strong></td>
											<td>
												@if($a->status === '0')
												Menunggu verifikasi
												@elseif($a->status === '1')
												Aktif
												@else
												Banned
												@endif
											</td>
										</tr>
										@if($a->status === '1')
										<tr>
											<td><strong>Premium</strong></td>
											<td>
												<span class="badge @if($a->is_premium) badge-primary @else badge-danger @endif">
													{{ $a->is_premium ? 'Ya' : 'Tidak' }}
												</span>
											</td>
										</tr>
										@endif
									</tbody>
								</table>
							</dl>
						</div>
					</div>
				</div>
				@endforeach
				<div class="col-md-12">
					{{ $data->appends(['keyword' => request()->query('keyword')])->links() }}
				</div>
			</div>
			@else
			<div class="alert alert-danger">
				Mohon maaf user belum ada
			</div>
			@endif
		</div>
		@include('contents.right-menu')
	</div>
</div>
@endsection

@push('script')
@endpush