<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UpdateContentKind;
use App\Http\Requests\StoreContentKind;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ContentKind;

class ContentKindController extends Controller
{
    public function api()
    {
    	return ContentKind::orderBy('name')->get();
    }

    public function store(StoreContentKind $r)
    {
    	ContentKind::create($r->only(['name', 'path']));
    	return response('Jenis konten berhasil ditambahkan');
    }

    public function edit($id)
    {
    	$oper = [
    		'data' => ContentKind::find($id)
    	];
    	return view('admin.content_kinds.edit', $oper);
    }

    public function update($id, UpdateContentKind $r)
    {
    	ContentKind::find($id)->update([
    		'name' => $r->name,
            'path' => $r->path
    	]);
    	return response('Jenis konten berhasil diperbarui');
    }

    public function delete($id)
    {
    	ContentKind::find($id)->delete();
    	return response('Jenis konten berhasil dihapus');
    }
}
