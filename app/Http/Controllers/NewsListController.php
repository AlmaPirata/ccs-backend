<?php

namespace App\Http\Controllers;

use App\Facades\ParseRBK;
use App\Models\Category;
use App\Models\News;
use Illuminate\Support\Facades\DB;


class NewsListController extends Controller
{
    public function index() {
        $news_array = News::all()->toQuery()->orderBy('created_at', 'desc')->paginate(4);
        $categories = Category::orderBy('title')->get();

        return view('pages.index', [
            'news_array' => $news_array,
            'categories' => $categories
        ]);
    }

    public function parse()
    {
        $data = ParseRBK::parse_news();
        $count_data = (is_array($data)) ? count($data) : 0;

        return view('pages.parse', [
            'data' => $data,
            'count' => $count_data
        ]);
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
