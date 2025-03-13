<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TodoItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $param = [
            'user_id' => 1,
            'item_name' => 'ダミーレコードの作成',
            'registration_date' =>'2024-12-03',
            'expire_date' => '2024-12-27',
        ];
        DB::table('todo_items')->insert($param);
    }
}
