<?php

namespace App\Http\Controllers;

use App\Facades\ParseRBK;
use App\Models\Category;
use App\Models\News;


class NewsListController extends Controller
{
    public function index() {
        $news_array = News::paginate(4);
        $categories = Category::orderBy('title')->get();

        return view('pages.index', [
            'news_array' => $news_array,
            'categories' => $categories
        ]);
    }

    public function parse()
    {
        ParseRBK::parse_news();
        return redirect()->route('index');
    }

    public function getNewsByCategory($slug) {
        $categories = Category::orderBy('title')->get();
        $current_category = Category::where('id', $slug)->first();

        return view('pages.index', [
            'news_array' => $current_category->news()->paginate(4),
            'categories' => $categories,
            'current_category' => $slug
        ]);
    }

    public function getNews($slug_category, $slug_news) {
        $news = News::where('slug', $slug_news)->first();
        $categories = Category::orderBy('title')->get();

        return view('pages.show-news', [
            'news' => $news,
            'categories' => $categories,
            'slug_category' => $slug_category,
        ]);
    }
}
