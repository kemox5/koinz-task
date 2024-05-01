<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookRead>
 */
class BookReadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIDs = DB::table('users')->pluck('id');
        $booksIds = DB::table('books')->pluck('id');
        $start_page = rand(1, 100);
        return [
            'book_id' => fake()->randomElement($userIDs),
            'user_id' => fake()->randomElement($booksIds),
            'start_page' => $start_page,
            'end_page' => rand($start_page, 500),
        ];
    }
}
