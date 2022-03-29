<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
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
        $categories_array = [];
        foreach ($data as $news) {
            $categories_array[] = $news->category[0];
        }
        $categories_array = array_unique($categories_array, SORT_STRING);
        foreach ($categories_array as $category) {
            DB::table('categories')->insert([
                'title' => $category
            ]);
        }
    }
}
