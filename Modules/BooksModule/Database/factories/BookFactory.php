<?php

namespace Modules\BooksModule\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\BooksModule\Models\Book;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{

    protected $model = Book::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'num_of_pages' => rand(50, 300),
            'num_of_read_pages' => 0
        ];
    }
}
