<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ContentKind;
use App\Kategori;
use App\Content;
use App\User;
use DB;

class ArticleController extends Controller
{
    public function index()
    {
        // DB::enableQueryLog();
        $oper = [
            'articles' => Content::withCount('comments')->with('cat')->where('status', '4')->where('content_kind_id', '1')->latest()->paginate(10),
            'content_kinds' => ContentKind::withCount('contents')->orderBy('name')->get(),
            'users' => User::where('status', '1')->get(),
            'categories' => Kategori::orderBy('name')->get()
        ];
        // dd(DB::getQueryLog());
        return view('contents.articles.all', $oper);
    }

    public function detail($url)
    {
        $content = Content::where('url', $url)->first();
        if($content->status == '4'){
            Content::where('url', $url)->update([
                'hit' => ++$content->hit
            ]);
            $oper = [
                'article' => $content
            ];
            return view('contents.articles.detail', $oper);
        }
        return abort(404);
    }
}
