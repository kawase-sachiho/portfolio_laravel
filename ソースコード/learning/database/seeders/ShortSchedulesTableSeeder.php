<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ShortSchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $param = [
            'user_id' => 1,
            'long_schedule_id'=>1,
            'short_term_goal_name' => 'Laravelのアプリを開発する',
            'registration_date' => '2024-12-03',
            'expire_date' => '2025-01-02',
        ];
        DB::table('short_schedules')->insert($param);
    }
}
