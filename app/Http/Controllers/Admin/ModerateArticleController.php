<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Content;

class ModerateArticleController extends Controller
{
    public function index()
    {
    	Content::where('status', '0')->where('')->get();
    	return view('admin.moderate.articles.index')
    }
}
