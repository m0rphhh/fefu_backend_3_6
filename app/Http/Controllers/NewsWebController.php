<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsWebController extends Controller
{
    public function getAllNews()
    {
        $news = News::orderBy('title')->simplePaginate(5);
        return view('news_list', ['newsList' => $news]);
    }

    public function getNewsPage($slug)
    {
        $news = News::where('slug', $slug)->firstOrFail();
        return view('news', ['news' => $news]);
    }
}
