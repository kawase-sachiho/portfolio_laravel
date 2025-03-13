<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LongSchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $param = [
            'user_id' => 1,
            'long_term_goal_name' => 'Laravelをマスターする',
            'registration_date' =>'2024-12-03',
            'expire_date' =>'2025-02-27',
        ];
        DB::table('long_schedules')->insert($param);
    }
}
