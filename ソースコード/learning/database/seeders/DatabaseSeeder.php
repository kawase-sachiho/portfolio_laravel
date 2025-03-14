<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(BlogsTableSeeder::class);
        $this->call(TodoItemsTableSeeder::class);
        $this->call(LongSchedulesTableSeeder::class);
        $this->call(ShortSchedulesTableSeeder::class);
        $this->call(NotesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
    }
}
