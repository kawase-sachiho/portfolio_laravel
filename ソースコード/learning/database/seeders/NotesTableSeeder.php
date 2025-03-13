<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $param=[
            'user_id'=>1,
            'category_id'=>'1',
            'title'=>'リレーションの命名規則',
            'content'=>'スネークケース(アンダースコアで分割)の方が、コードを書くときに違和感が少なく書ける',
            'keyword'=>'Laravel',
            'registration_date'=>'2024-12-03',
        ];
        DB::table('notes')->insert($param);
    }
}
