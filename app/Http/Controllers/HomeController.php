<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MenuUtama;
use App\ViewSubMenu;
use App\Konfigurasi;
use App\Testimoni;
use App\Feedback;
use App\Kategori;
use App\User;
use App\Slider;
use App\Setting;
use App\Content;
use Auth;

class HomeController extends Controller
{

    public function index()
    {
        $categories     = Kategori::withCount('contents')->orderBy('name')->get();
        $sliders        = Slider::where('status', '1')->get();
        $oper = [
            'categories'        => $categories,
            'sliders'           => $sliders,
            'why_us'            => Setting::whyUs(),
            'testimoni'         => Feedback::testimoni(),
            'popular_contents'  => Content::popular(),
            'about'             => Setting::about(),
            'our_focus'         => Setting::ourFocus(),
        ];
        // return Feedback::testimoni();
        return view('home.index', $oper);
    }

    public function categories()
    {
        return Kategori::withCount(['contents' => function($q){
            $q->where('content_kind_id', '1');
        }])->orderBy('name')->get();
    }

}