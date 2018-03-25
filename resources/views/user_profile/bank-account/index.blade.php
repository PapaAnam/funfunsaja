@extends('all-user.profile', ['title' => 'Rekening Saya'])
@section('profile')
<div class="table-responsive">
	<table class="table table-striped table-bordered">
		<tbody>
			<tr>
				<td width="200px"><strong>Atas Nama</strong></td>
				<td>@if($bank) {{ $bank->on_name }} @else <span class="badge badge-warning">Belum Diisi</span> @endif</td>
			</tr>
			<tr>
				<td><strong>No Rekening</strong></td>
				<td>@if($bank) {{ $bank->bill_number }} @else <span class="badge badge-warning">Belum Diisi</span> @endif</td>
			</tr>
			<tr>
				<td><strong>Nama Bank</strong></td>
				<td>@if($bank) {{ $bank->bank }} @else <span class="badge badge-warning">Belum Diisi</span> @endif</td>
			</tr>
			<tr>
				<td><strong>Cabang</strong></td>
				<td>@if($bank) {{ $bank->branch }} @else <span class="badge badge-warning">Belum Diisi</span> @endif</td>
			</tr>
			<tr>
				<td><strong>Kota</strong></td>
				<td>@if($bank) {{ $bank->city }} @else <span class="badge badge-warning">Belum Diisi</span> @endif</td>
			</tr>
			<tr>
				<td><strong>Terakhir kali diperbarui</strong></td>
				<td>@if($bank) {{ $bank->created_at }} @else <span class="badge badge-warning">Belum Diisi</span> @endif</td>
			</tr>
		</tbody>
	</table>
</div>
@endsection

@section('action')
<div class="col-md-12">
	<div class="card border-danger mt-2">
		<div class="card-header bg-danger text-light">
			Action
		</div>
		<div class="card-body border-danger">
			<a class="btn btn-danger btn-sm" href="{{ url('/user-profile') }}">Profil Saya</a>
			<a class="btn btn-danger btn-sm" href="{{ url('/user-profile/bank-account/edit') }}">Ubah Rekening</a>
		</div>
	</div>
</div>
@endsection

@push('js')
<script src="{{ asset('vendors/js/notify.min.js') }}"></script>
@endpush