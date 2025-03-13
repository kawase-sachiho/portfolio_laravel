<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $param=[
            'user_id'=>1,
            'title'=>'はじめてのブログ',
            'content'=>'今日からLaravelで開発を始めた',
            'comment'=>'なかなか根気のいる作業だった',
            'learning_date'=>'2024-12-03',
        ];
        DB::table('blogs')->insert($param);
    }
}
