<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
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
        foreach ($data as $news) {
            DB::table('images')->insert([
                'path' => $news->image[0],
                'format' => 'jpg'
            ]);
        }
    }
}
