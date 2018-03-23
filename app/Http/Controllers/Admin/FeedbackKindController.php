<?php

namespace App\Http\Controllers\Admin;

use App\FeedBackKind;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeedbackKind;
use App\Http\Requests\UpdateFeedbackKind;

class FeedbackKindController extends Controller
{
    public function api()
    {
        return FeedBackKind::all();
    }

    public function store(StoreFeedBackKind $r)
    {
        FeedBackKind::create($r->only(['name', 'path']));
        return response('Jenis Masukan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $oper = [
            'data' => FeedBackKind::find($id)
        ];
        return view('admin.feedback_kinds.edit', $oper);
    }

    public function update($id, UpdateFeedBackKind $r)
    {
        FeedBackKind::find($id)->update($r->only(['name', 'path']));
        return response('Jenis Masukan berhasil diperbarui');
    }

    public function delete($id)
    {
        FeedBackKind::find($id)->delete();
        return response('Jenis Masukan berhasil dihapus');
    }
}
