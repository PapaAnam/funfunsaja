@extends('layouts.app', ['title' => 'Daftar User'])
@section('content')
<br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h4>Daftar User</h4>
			<hr>
			<div class="row">
				<div class="col-md-4">
					@component('select', ['id'=>'status','label'=>'Pilih Status User','size'=>'sm'])
					<option value="all">Semua</option>
					<option value="0">Menunggu Verifikasi</option>
					<option value="1">Aktif</option>
					<option value="2">Non Aktif</option>
					@endcomponent
				</div>
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
				<div class="col-md-12 mb-5">
					<div class="card">
						<div class="card-body">
							@if($a->username)
							<a class="text-dark" style="text-decoration: none;" href="{{ url('/profile/'.$a->username) }}"><h5>{{ $a->username }}</h5></a>
							@else
							<h5>{{ $a->email }}</h5>
							@endif
							<i class="fa fa-clock-o"></i> {{ $a->dibuat_pada }}
							<i class="fa fa-tags"></i> 
							<hr>
							<div>
								<img class="mb-2 img-thumbnail rounded-circle float-left" style="max-width: 180px; max-height: 180px; margin-right: 20px;" src="{{ $a->avatar }}" alt="{{ $a->username }}">
								<div class="text-justify" style="line-height: 20px;">
									@if($a->description)
									{!! $a->description !!}
									@else
									<span class="badge badge-danger">
										Deskripsi belum diisi
									</span>
									@endif
								</div>
								<br>
							</div>
						</div>
						<div class="card-footer">
							<div class="text-right text-muted">
								<i class="fa fa-eye"></i> 
								@php
								$view = DB::table('contents')->where('user_id', $a->id)->sum('hit');
								@endphp
								{{ $view }} &nbsp;&nbsp;
								{{-- @if($a->cat) --}}
								<a class="text-muted" href="#">
									<i class="fa fa-cube"></i> {{ $a->contents_count }}
								</a>
								{{-- @endif --}}
							</div>
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

@push('style')
<style>
.page-item.active .page-link {
	background-color: #dc3545;
	border-color: #dc3545;
}
.page-link {
    color: #dc3545;
}
</style>
@endpush