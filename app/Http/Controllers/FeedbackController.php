<?php

namespace App\Http\Controllers;

use Auth;
use Storage;
use App\Tag;
use App\Feedback;
use App\FeedBackKind;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFeedback;
use App\Http\Requests\UpdateFeedback;
use App\Activity;
use App\User;
use DB;

class FeedbackController extends Controller
{

    public function myFb()
    {
        $feedbacks = FeedBack::withCount(['comments' => function($q){
            $q->where('status', '1');
        }])
        ->where('user_id', Auth::id())->latest()->get();
        $oper = [
            'feedbacks' => $feedbacks,
            'i' => 1
        ];
        return view('feedbacks.my_fb', $oper);
    }

    public function create()
    {
        $oper = [
            'feedbackKinds' => FeedBackKind::all(),
            'tags' => Tag::select(['name'])->orderBy('name')->get(),
        ];
        return view('feedbacks.create', $oper);
    }

    public function store(StoreFeedback $r)
    {
        $data = [];
        $att = $r->file('attachment');
        if($att){
            $data['attachment'] = str_replace('public/', '', $att->storeAs('public/'.$r->user()->username.('/feedback/attachment'), $att->getClientOriginalName()));
        }
        $thumb = $r->file('thumbnail');
        if($thumb){
            $data['thumbnail'] = str_replace(
                'public/', '', $thumb->store(
                    'public/'.$r->user()->username.'/feedback/thumbnail'
                )
            );
        }
        Tag::cr($r);
        $data['url'] = str_slug($r->title);
        $data['tags'] = $r->tags;
        $data['user_id'] = Auth::id();
        $feedback = FeedBack::create($data+$r->only(['title', 'feedback_kind_id', 'content', 'status']));
        if($r->status === 'waiting')
            $this->activity('Buat Masukan', 'Mempublikasi masukan yang berjudul '.$feedback->title);
        else
            $this->activity('Buat Masukan', 'Membuat draft masukan yang berjudul '.$feedback->title);
        return $r->status == 'waiting' ? 'Masukan berhasil dipublish. Menunggu persetujuan administrator' : 'Masukan berhasil dimasukkan ke draft';
    }

    public function edit(Feedback $feedback)
    {
        $c = $feedback;
        if($c->status == 'published' || $c->status == 'waiting' || $c->user_id != Auth::id()){
            abort(404);
        }
        $data = $c;
        if(is_string($data->tags)){
            $data = $data->update([
                'tags' => [$data->tags]
            ]);
        }
        $oper = [
            'data'           => $data,
            'feedback_kinds' => collect(FeedBackKind::selectData())->pluck('name', 'id'),
            'tags'           => Tag::selectData(),
        ];
        // dd($oper['data']);
        return view('feedbacks.edit', $oper);
    }

    public function update(Feedback $feedback, UpdateFeedback $r)
    {
        $c = $feedback;
        if($c->status == 'published' || $c->status == 'waiting' || $c->user_id != Auth::id()){
            abort(404);
        }
        $data = [];
        $att = $r->file('attachment');
        if($att){
            $file = 'public/'.$c->attachment;
            if(Storage::exists($file)){
                Storage::delete($file);
            }
            $data['attachment'] = str_replace('public/', '', $att->storeAs('public/'.$r->user()->username.('/feedback/attachment'), $att->getClientOriginalName()));
        }
        $thumb = $r->file('thumbnail');
        if($thumb){
            $file = 'public/'.$c->thumbnail;
            if(Storage::exists($file)){
                Storage::delete($file);
            }
            $data['thumbnail'] = str_replace('public/', '', $thumb->store(
                'public/'.$r->user()->username.'/feedback/thumbnail'
            ));
        }
        $data['url'] = str_slug($r->title);
        $data['tags'] = $r->tags;
        foreach ($r->tags as $t) {
            Tag::updateOrCreate([
                'name' => $t
            ]);
        }
        $data['user_id'] = Auth::id();
        $c->update($data+$r->only(['title', 'feedback_kind_id', 'content', 'status']));
        if($r->status === 'waiting')
            $this->activity('Edit Masukan', 'Mempublikasi masukan yang berjudul '.$feedback->title);
        else
            $this->activity('Edit Masukan', 'Memmbuat draft masukan yang berjudul '.$feedback->title);
        return $r->status == 'waiting' ? 'Masukan berhasil dipublish. Menunggu persetujuan administrator' : 'Masukan berhasil dimasukkan ke draft';
    }

    private function activity($title, $body)
    {
        Activity::create([
            'user_id'   => Auth::id(),
            'title'     => $title,
            'content'   => $body,
        ]);
    }

    public function delete(Feedback $feedback)
    {
        $this->activity('Hapus Masukan', 'Menghapus menghapus yang berjudul '.$feedback->title);
        $feedback->delete();
        return 'Masukan berhasil dihapus';
    }

    public function all($feedback_kind_url, Request $r)
    {
        // DB::enableQueryLog();
        $ck = FeedbackKind::where('path', 'like', '%'.$feedback_kind_url.'%')->first();
        // dd($ck);
        $feedback = [];
        $user = 'all';
        if($ck){
            $feedback = $ck->feedbacks()->withCount(['comments' => function($q){
                $q->where('status', '1');
            }])->where('status', 'published');
            if($r->query('user') && $r->query('user') != 'all'){
                $user_id = User::where('username', $r->query('user'))->first()->id;
                $feedback = $feedback->where('user_id', $user_id);
                $user = $r->query('user');
            }
            $keyword = $r->query('keyword');
            if($keyword)
                $feedback = $feedback->where(function($q) use($keyword){
                    $q->where('title', 'like', '%'.$keyword.'%')
                    ->orWhere('content', 'like', '%'.$keyword.'%');
                });
            $feedback = $feedback->latest()->paginate(10);
        }
        $oper = [
            'data'          => $feedback,
            'users'         => User::username(),
            'modul'         => $ck ? $ck->name : '',
            'url'           => $feedback_kind_url,
            'user'          => $user,
        ]+$this->getRightMenu();
        // dd(DB::getQueryLog());
        // return $oper;
        return view('feedbacks.all', $oper);
    }

    private function getRightMenu()
    {
        $ck = FeedbackKind::withCount(['feedbacks' => function($q){
            $q->where('status', 'published');
        }])->orderBy('name')->get();
        $count = 7;
        $populars = Feedback::with('kind')->where('status', 'published')->take($count)->orderBy('hit', 'DESC')->get();
        $newest = Feedback::with('kind')->where('status', 'published')->take($count)->latest()->get();
        $random = Feedback::with('kind')->where('status', 'published')->take($count)->inRandomOrder()->get();
        return [
            'feedback_kinds'    => $ck,
            'populars'          => $populars,
            'newest'            => $newest,
            'random'            => $random,
        ];
    }

    public function detail($feedback_kind_url, Feedback $feedback)
    {
        $ck = FeedbackKind::whereUrl('/feedback/'.$feedback_kind_url)->first();
        if(!$ck)
            abort(404);
        if(!$feedback)
            abort(404);
        if($feedback->status == 'published'){
            $feedback->increment('hit');
            $oper = [
                'modul'     => $ck->name,
                'feedback'  => Feedback::with(['comments' => function($q){
                    $q->with('user')->where('status', '1')->orderBy('is_best', 'desc')->orderBy('created_at', 'desc');
                }])->withCount(['comments' => function($q){
                    $q->where('status', '1');
                }])->where('id', $feedback->id)->first()
            ]+$this->getRightMenu();
            return view('feedbacks.detail', $oper);
        }
        return abort(404);
    }
}
