<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ModerateContent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notification;
use App\Setting;
use App\Content;
use App\Point;
use Auth;
use App\Activity;
use App\Admin\AktivitasModerasi;

class ModerateController extends Controller
{
    public function index()
    {
    	$contents = Content::with(['user', 'kind', 'cat'])->where('status', '1')->latest()->paginate(20);
    	$oper = [
    		'contents' => $contents
    	];
    	return view('admin.moderate.index', $oper);
    }

    public function preview($url)
    {
        $content = Content::with(['user', 'kind', 'cat'])->where('url', $url)->first();
    	$oper = [
    		'content' => $content
    	];
    	return view('admin.contents.preview', $oper);
    }

    public function update($id, ModerateContent $r)
    {
        // return Auth::guard('admin')->id();
        // return Auth::guard('admin_api')->user();
        $con = Content::find($id);
        $published = $r->status == 'published';
        $title = $published ? 'Konten dipublikasi.' : 'Konten ditolak';
        $content = $r->status == 'published' ? 'Selamat konten berhasil dipublikasi.' : 'Mohon maaf konten anda ditolak';
        Notification::create([
            'title'     => $title,
            'content'   => $content,
            'from_type' => '1',
            'from_id'   => Auth::guard('admin')->id(),
            'to_id'     => $con->user_id,
            'type'      => $published ? 'success' : 'danger'
        ]);
        $aktivitas = new AktivitasModerasi();
        $aktivitas->admin_id    = Auth::guard('admin')->id();
        $aktivitas->judul       = 'Moderasi Konten';
        $aktivitas->isi         = $published ? 'Mempublikasi konten yang berjudul <a href="'.$con->full_url.'">'.$con->title.'</a>' : 'Menolak konten yang berjudul '.$con->title;
        $aktivitas->save();
        $point = Setting::pointGet();
        $u = $con->user()->first();
        $u->point += $point;
        $u->save();
        $con->update([
            'status' => $r->status
        ]);
        if($published){
            Point::create([
                'user_id'       => $con->user_id,
                'point'         => $point,
                'description'   => 'Mempublikasi konten',
                'content_id'    => $con->id,
            ]);
        }
        return $published ? 'Konten berhasil dipublikasi.' : 'Konten berhasil ditolak';
    }
}
