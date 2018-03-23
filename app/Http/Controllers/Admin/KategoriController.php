<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreContentKind;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Kategori;

class KategoriController extends Controller
{
    public function api()
    {
    	return Kategori::all();
    }

    public function store(StoreContentKind $r)
    {
    	Kategori::create([
    		'name' => $r->name
    	]);
    	return response('Kategori berhasil ditambahkan');
    }

    public function update($id, StoreContentKind $r)
    {
    	Kategori::find($id)->update([
    		'name' => $r->name
    	]);
    	return response('Kategori berhasil diperbarui');
    }

    public function delete($id)
    {
    	Kategori::find($id)->delete();
    	return response('Kategori berhasil dihapus');
    }
}
