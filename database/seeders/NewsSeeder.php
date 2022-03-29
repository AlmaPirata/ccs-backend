<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = resource_path('parse/parser_result.json');
        $data = file_get_contents($path);
        $data = json_decode($data);
        $categories = [
            '1' => 'Политика',
            '2' => 'Спорт',
            '3' => 'Экономика',
            '4' => 'Общество',
            '5' => 'Бизнес'
        ];
        $images = [
            '1' =>	'https://s0.rbk.ru/v6_top_pics/media/img/2/88/756481489702882.jpg',
            '2' =>	'https://s0.rbk.ru/v6_top_pics/media/img/8/60/756481488495608.jpg',
            '3' =>	'https://s0.rbk.ru/v6_top_pics/media/img/6/28/756481462139286.jpg',
            '4' =>	'https://s0.rbk.ru/v6_top_pics/media/img/5/29/756481434890295.jpg',
            '5' =>	'https://s0.rbk.ru/v6_top_pics/media/img/9/59/756481470168599.jpg',
            '6' =>	'https://s0.rbk.ru/v6_top_pics/media/img/1/18/756481446121181.jpg',
            '7' =>	'https://s0.rbk.ru/v6_top_pics/media/img/0/16/756481477936160.jpg',
            '8' =>	'https://s0.rbk.ru/v6_top_pics/media/img/5/09/756481446321095.jpg',
            '9' =>	'https://s0.rbk.ru/v6_top_pics/media/img/8/19/756481471595198.jpg',
            '10' => '',
            '11' =>	'https://s0.rbk.ru/v6_top_pics/media/img/6/35/756481421315356.jpg',
            '12' =>	'https://s0.rbk.ru/v6_top_pics/media/img/7/29/756481464654297.jpg',
            '13' =>	'https://s0.rbk.ru/v6_top_pics/media/img/9/47/756460582323479.jpg',
            '14' =>	'https://s0.rbk.ru/v6_top_pics/media/img/3/74/756481454072743.jpg'
        ];
        $users = [
            '1' => 'Кирилл Соколов',
            '2' => 'Антон Балакирев',
            '3' => 'Любовь Порываева',
            '4' => 'Юлия Выродова',
            '5' => '',
            '6' => 'Лилия Пашкова',
            '7' => 'Михаил Юшков',
            '8' => 'Елена Чернышова',
            '9' => 'Анастасия Антипова',
            '10' => 'Артём Кореняко',
            '11' => 'Тимофей Дзядко',
            '12' => 'Редакция РБК'
        ];
        foreach ($data as $news) {
            DB::table('news')->insert([
                'category_id' => array_search($news->category[0], $categories),
                'image_id' => array_search($news->image[0], $images),
                'user_id' => array_search($news->author[0], $users),
                'original_link' => $news->news_link[0],
                'title' => $news->title[0],
                'text' => $news->text_article[0],
                'slug' => mb_substr(md5($news->title[0]), 0, 10)
            ]);
        }
    }
}
