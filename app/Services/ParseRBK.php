<?php

namespace App\Services;

use voku\helper\HtmlDomParser;

class ParseRBK
{

    public function parse_news()
    {
        try {
            $path = resource_path("parse/rbk_main_page.html");
            $this->get_main_page($path);
//            $data_main = $this->parse_main_page($path);
//            $result = $this->parse_detail_page($data_main);
//            $this->create_result_json($result);
            return 'success';
        } catch (\Exception $exception){
            return $exception;
        }
    }

    private function get_main_page($path)
    {
        //$this->get_curl_request($path, "https://www.rbc.ru/");
        $this->parse_main_page($path);
    }

    private function parse_main_page($path)
    {
        $html = HtmlDomParser::file_get_html($path);
        $result = [];
        foreach ($html->find('.news-feed__item.js-news-feed-item') as $key => $news) {
            $result[$key]['title'][] = $news->find('.news-feed__item__title')->innertext[0];
            $category = $news->find('.news-feed__item__date-text')->innertext;
            $category = explode(',&nbsp;', $category[0]);
            $result[$key]['category'][] = $category[0];
            $result[$key]['news_link'][] = $news->href;
        }
        $this->parse_detail_page($result);
//        return $result;
    }

    private function parse_detail_page($result)
    {
        foreach ($result as $key => $news) {
            $path = resource_path("parse/rbk_detail_page_".$key.".html");
            $this->get_curl_request($path, $news['news_link'][0]);

            $html = HtmlDomParser::file_get_html($path);
            $article = $html->find('.article');
            $text_article = $article->find('.article__text__overview span')->innertext;
                $result[$key]['text_article'][] = $text_article[0] ?? '';
            $image = $article->find('.article__main-image__wrap img');
                $result[$key]['image'][] = $image->src[0] ?? '';
            $author = $article->find('.article__authors__author__name')->innerText;
                $result[$key]['author'][] = $author[0] ?? '';
            $paragraphs = $article->find('p');
            $result[$key]['text'] = [''];
            foreach ($paragraphs as $p) {
                if(trim($p->textContent)) {
                    $result[$key]['text'][0] .=  '<p>' . trim($p->textContent) . '</p>';
                }
            }
        }
        $this->create_result_json($result);
//        return $result;
    }

    private function create_result_json($result)
    {
        $path = resource_path("parse/parser_result.json");
        $fp = fopen ($path, "w");
        fwrite($fp, json_encode($result));
        fclose($fp);
    }

    private function get_curl_request($path, $url) {
        $ch = curl_init ($url);
        $path = resource_path($path);
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
