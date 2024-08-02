<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_blog')->insert([
            [
                'page_id' => 1,
                'judul' => 'Halaman blog',
                'slug' => 'memperkenalkan blog CV MasCitra',
                'body' => 'Mascitra Training Center dan Konsultan IT',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'page_id' => 2,
                'judul' => 'Halaman Berita',
                'slug' => 'understanding-eloquent-orm',
                'body' => 'Eloquent ORM is a powerful and expressive database management tool',
                'created_by' => 2,
                'updated_by' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'page_id' => 2,
                'judul' => 'Halaman Traning',
                'slug' => 'tips-and-tricks-for-blade-templates',
                'body' => 'Blade is a simple yet powerful templating engine in Laravel...',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'page_id' => 1,
                'judul' => 'Belajar API',
                'slug' => 'building-restful-apis-with-laravel',
                'body' => 'Laravel provides a robust framework for building RESTful APIs...',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
