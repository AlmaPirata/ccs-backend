<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use voku\helper\HtmlDomParser;
use Curl\Curl;



class NewsListController extends Controller
{
    public function index() {
        function pref($val){
                echo '<pre style="background: #333;
                                text-align: left;
                                color: #fff;
                                font-size: 11px;
                                padding: 20px;
                                max-height: 500px;
                                overflow: auto">';
                print_r($val);
                echo '</pre>';
        }
        $news_array = News::paginate(4);
        $categories = Category::orderBy('title')->get();

//        $html = HtmlDomParser::file_get_html('http://www.google.com/');

//        $ch = curl_init ("http://www.google.com/");
//        $ch = curl_init ("https://www.rbc.ru/");
//        $path = resource_path('parse/test_parser.html');
//        $fp = fopen ($path, "w");
//        curl_setopt($ch, CURLOPT_USERAGENT, "google");
//        curl_setopt ($ch, CURLOPT_FILE, $fp);
//        curl_setopt ($ch, CURLOPT_HEADER, 0);
//        curl_exec ($ch);
//        curl_close ($ch);
//        fclose ($fp);


//        $html = HtmlDomParser::file_get_html($path);
//        $result = [];
//        foreach ($html->find('.news-feed__item.js-news-feed-item') as $key => $news) {
//            $result[$key]['title'][] = $news->find('.news-feed__item__title')->innertext[0];
//            $category = $news->find('.news-feed__item__date-text')->innertext;
//            $category = explode(',&nbsp;', $category[0]);
//            $result[$key]['category'][] = $category[0];
//            $result[$key]['news_link'][] = $news->href;
//        }
//        foreach ($result as $key => $news) {
//            $ch = curl_init ($news['news_link'][0]);
//            $path = resource_path('parse/'.$key.'/test_parser.html');
//            $fp = fopen ($path, "w");
//            curl_setopt($ch, CURLOPT_USERAGENT, "google");
//            curl_setopt ($ch, CURLOPT_FILE, $fp);
//            curl_setopt ($ch, CURLOPT_HEADER, 0);
//            curl_exec ($ch);
//            curl_close ($ch);
//            fclose ($fp);
//            sleep(15);
//            pref($news);


//            $html = HtmlDomParser::file_get_html($path);
//            $article = $html->find('.article');
//            $text_article = $article->find('.article__text__overview span')->innertext;
//                $result[$key]['text_article'][] = $text_article[0] ?? '';
//            $image = $article->find('.article__main-image__wrap img');
//                $result[$key]['image'][] = $image->src[0] ?? '';
//            $author = $article->find('.article__authors__author__name')->innerText;
//                $result[$key]['author'][] = $author[0] ?? '';
//            $paragraphs = $article->find('p');
//            $result[$key]['text'] = [''];
//            foreach ($paragraphs as $p) {
//                if(trim($p->textContent)) {
//                    $result[$key]['text'][0] .=  '<p>' . trim($p->textContent) . '</p>';
//                }
//            }
//        }

//        $path = resource_path('parse/parser_result.json');
//        $fp = fopen ($path, "w");
//        fwrite($fp, json_encode($result));
//        fclose($fp);
//        $path = resource_path('parse/parser_result.json');
//        $result = file_get_contents($path);
//        $result = json_decode($result);
//        pref($result);
//        foreach ($result as $n) {
//            $ar[] = $n->category[0];
//        }
//        $a = array_unique($ar, SORT_STRING);


        return view('pages.index', [
            'news_array' => $news_array,
            'categories' => $categories
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
