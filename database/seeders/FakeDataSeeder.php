<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class FakeDataSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        
        foreach (range(1, 1000) as $index) {
            DB::table('authors')->insert([
                'name' => $faker->name(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        foreach (range(1, 3000) as $index) {
            DB::table('categories')->insert([
                'name' => $faker->word(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $authorIds = DB::table('authors')->pluck('id')->toArray();
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        foreach (range(1, 100000) as $index) {
            DB::table('books')->insert([
                'title' => $faker->sentence(),
                'author_id' => $faker->randomElement($authorIds),
                'category_id' => $faker->randomElement($categoryIds),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $bookIds = DB::table('books')->pluck('id')->toArray();

        foreach (range(1, 500000) as $index) {
            DB::table('ratings')->insert([
                'book_id' => $faker->randomElement($bookIds),
                'rating' => $faker->randomFloat(1, 1, 10),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        foreach ($bookIds as $bookId) {
            DB::table('votes')->insert([
                'book_id' => $bookId,
                'vote_value' => $faker->numberBetween(1, 50000), 
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
