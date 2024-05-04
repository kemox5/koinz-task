<?php

namespace Modules\BooksModule\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\BooksModule\Models\Book;
use Tests\TestCase;

class ListRecommendedBooksTest extends TestCase
{
    use RefreshDatabase;
    private $list_recommended_books = 'api/books/most-read';

    public function test_5_items()
    {
        Book::factory(1)->create(['name' => 'Book 1', 'num_of_read_pages' => 10]);
        Book::factory(1)->create(['name' => 'Book 2', 'num_of_read_pages' => 100]);
        Book::factory(1)->create(['name' => 'Book 3', 'num_of_read_pages' => 60]);
        Book::factory(1)->create(['name' => 'Book 4', 'num_of_read_pages' => 20]);
        Book::factory(1)->create(['name' => 'Book 5', 'num_of_read_pages' => 30]);

        $response = $this->get($this->list_recommended_books);

        $response->assertStatus(200)
            ->assertJsonFragment([
                "books" => [
                    [
                        "id" => 2,
                        "name" => "Book 2",
                        "num_of_read_pages" => 100
                    ],
                    [
                        "id" => 3,
                        "name" => "Book 3",
                        "num_of_read_pages" => 60
                    ],
                    [
                        "id" => 5,
                        "name" => "Book 5",
                        "num_of_read_pages" => 30
                    ],
                    [
                        "id" => 4,
                        "name" => "Book 4",
                        "num_of_read_pages" => 20
                    ],
                    [
                        "id" => 1,
                        "name" => "Book 1",
                        "num_of_read_pages" => 10
                    ],
                ]
            ]);
    }

    public function test_more_than_5_items()
    {
        Book::factory(1)->create(['name' => 'Book 1', 'num_of_read_pages' => 10]);
        Book::factory(1)->create(['name' => 'Book 2', 'num_of_read_pages' => 100]);
        Book::factory(1)->create(['name' => 'Book 3', 'num_of_read_pages' => 60]);
        Book::factory(1)->create(['name' => 'Book 4', 'num_of_read_pages' => 20]);
        Book::factory(1)->create(['name' => 'Book 5', 'num_of_read_pages' => 30]);
        Book::factory(1)->create(['name' => 'Book 6', 'num_of_read_pages' => 200]);

        $response = $this->get($this->list_recommended_books);

        $response->assertStatus(200)
            ->assertJsonFragment([
                "books" => [
                    [
                        "id" => 6,
                        "name" => "Book 6",
                        "num_of_read_pages" => 200
                    ],
                    [
                        "id" => 2,
                        "name" => "Book 2",
                        "num_of_read_pages" => 100
                    ],
                    [
                        "id" => 3,
                        "name" => "Book 3",
                        "num_of_read_pages" => 60
                    ],
                    [
                        "id" => 5,
                        "name" => "Book 5",
                        "num_of_read_pages" => 30
                    ],
                    [
                        "id" => 4,
                        "name" => "Book 4",
                        "num_of_read_pages" => 20
                    ]
                ]
            ]);
    }

    public function test_less_than_5_items()
    {
        Book::factory(1)->create(['name' => 'Book 1', 'num_of_read_pages' => 10]);
        Book::factory(1)->create(['name' => 'Book 2', 'num_of_read_pages' => 100]);
        Book::factory(1)->create(['name' => 'Book 3', 'num_of_read_pages' => 60]);
        $response = $this->get($this->list_recommended_books);

        $response->assertStatus(200)
            ->assertJsonFragment([
                "books" => [
                    [
                        "id" => 2,
                        "name" => "Book 2",
                        "num_of_read_pages" => 100
                    ],
                    [
                        "id" => 3,
                        "name" => "Book 3",
                        "num_of_read_pages" => 60
                    ],
                    [
                        "id" => 1,
                        "name" => "Book 1",
                        "num_of_read_pages" => 10
                    ]
                ]
            ]);
    }
}
