<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Image;
use App\Models\News;
use App\Models\User;
use voku\helper\HtmlDomParser;

class ParseRBK
{

    public function parse_news()
    {
        try {
            $path = resource_path("parse/rbk_main_page.html");
            $this->get_main_page($path);
            $data_main = $this->parse_main_page($path);
            $result = $this->parse_detail_page($data_main);
            return $result;
        } catch (\Exception $exception){
            return $exception;
        }
    }

    private function get_main_page($path)
    {
        $this->get_curl_request($path, "https://www.rbc.ru/");
    }

    private function parse_main_page($path)
    {
        $html = HtmlDomParser::file_get_html($path);
        $result = [];
        foreach ($html->find('.news-feed__item.js-news-feed-item') as $key => $news) {
            $result[$key]['title'][] = $news->find('.news-feed__item__title')->innertext[0];
            $category = $news->find('.news-feed__item__date-text')->plaintext;
            $category = explode(',&nbsp;', $category[0]);
            $result[$key]['category'][] = $category[0];
            $findCategory = Category::where('title', $category[0])->first();
            if(!$findCategory) {
                Category::create([
                    'title' => $category[0]
                ]);
            }
            $result[$key]['news_link'][] = $news->href;
        }

        return $result;
    }

    private function parse_detail_page($result)
    {
        $newsArray = [];
        foreach ($result as $key => $news) {
            $path = resource_path("parse/rbk_detail_page_".$key.".html");
            $this->get_curl_request($path, $news['news_link'][0]);

            $html = HtmlDomParser::file_get_html($path);
            $article = $html->find('.article');
            $article_text = $article->find('.article__text__overview > span');
            $text_article = $article_text ? $article_text->innertext : [];
                $result[$key]['text_article'][] = $text_article[0] ?? '';
            $image = $article->find('.article__main-image__wrap img');
                $result[$key]['image'][] = $image->src[0] ?? '';
                $newImage = Image::create([
                    'path' => $result[$key]['image'][0],
                    'format' => 'jpg'
                ]);
            $author_text = $article->find('.article__authors__author__name');
            $author = $author_text ? $author_text->innerText : [];
                $result[$key]['author'][] = $author[0] ?? '';
                $findUser = User::where('name', $result[$key]['author'][0])->first();
                if(!$findUser) {
                    $newUser = User::create([
                        'name' => $result[$key]['author'][0]
                    ]);
                } else {
                    $newUser = $findUser;
                }
            $paragraphs = $article->find('p');
            $result[$key]['text'] = [''];
            if($paragraphs) {
                foreach ($paragraphs as $p) {
                    if(trim($p->textContent)) {
                        $result[$key]['text'][0] .=  '<p>' . trim($p->textContent) . '</p>';
                    }
                }
            }
            $findCategory = Category::where('title', $result[$key]['category'][0])->first();
            $slug = mb_substr(md5($result[$key]['title'][0]), 0, 10);
            $findNews = News::where('slug', $slug)->first();
            if(!$findNews) {
                $news = News::create([
                    'category_id' => $findCategory->id,
                    'image_id' => $newImage->id,
                    'user_id' => $newUser->id,
                    'original_link' => $result[$key]['news_link'][0],
                    'title' => $result[$key]['title'][0],
                    'text' => $result[$key]['text'][0],
                    'slug' => $slug
                ]);
                array_push($newsArray, $news);
            }
        }
        return $newsArray;
    }


    private function get_curl_request($path, $url) {
        $ch = curl_init ($url);
        $fp = fopen ($path, "w+");
        curl_setopt($ch, CURLOPT_USERAGENT, "google");
        curl_setopt ($ch, CURLOPT_FILE, $fp);
        curl_setopt ($ch, CURLOPT_HEADER, 0);
        curl_exec ($ch);
        curl_close ($ch);
        fclose ($fp);
        sleep(2);
    }
}
