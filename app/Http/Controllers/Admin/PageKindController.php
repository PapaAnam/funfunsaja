<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UpdatePageKind;
use App\Http\Requests\StorePageKind;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PageKind;

class PageKindController extends Controller
{
	public function api()
	{
		return PageKind::all();
	}

	public function store(StorePageKind $r)
	{
		PageKind::create($r->only(['name', 'path']));
		return response('Jenis Halaman berhasil ditambahkan');
	}

	public function update($id, UpdatePageKind $r)
	{
		PageKind::find($id)->update($r->only(['name', 'path']));
		return response('Jenis Halaman berhasil diperbarui');
	}

	public function delete($id)
	{
		PageKind::find($id)->delete();
		return response('Jenis Halaman berhasil dihapus');
	}
}
