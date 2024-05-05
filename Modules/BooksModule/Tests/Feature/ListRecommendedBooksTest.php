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
        Book::factory(1)->create(['name' => 'Book 1', 'num_of_pages' => 200, 'num_of_read_pages' => 10]);
        Book::factory(1)->create(['name' => 'Book 2', 'num_of_pages' => 200, 'num_of_read_pages' => 100]);
        Book::factory(1)->create(['name' => 'Book 3', 'num_of_pages' => 200, 'num_of_read_pages' => 60]);
        Book::factory(1)->create(['name' => 'Book 4', 'num_of_pages' => 200, 'num_of_read_pages' => 20]);
        Book::factory(1)->create(['name' => 'Book 5', 'num_of_pages' => 200, 'num_of_read_pages' => 30]);

        $response = $this->get($this->list_recommended_books);

        $response->assertStatus(200)
            ->assertJsonFragment([
                "books" => [
                    [
                        "book_id" => 2,
                        "book_name" => "Book 2",
                        "num_of_read_pages" => 100
                    ],
                    [
                        "book_id" => 3,
                        "book_name" => "Book 3",
                        "num_of_read_pages" => 60
                    ],
                    [
                        "book_id" => 5,
                        "book_name" => "Book 5",
                        "num_of_read_pages" => 30
                    ],
                    [
                        "book_id" => 4,
                        "book_name" => "Book 4",
                        "num_of_read_pages" => 20
                    ],
                    [
                        "book_id" => 1,
                        "book_name" => "Book 1",
                        "num_of_read_pages" => 10
                    ],
                ]
            ]);
    }

    public function test_more_than_5_items()
    {
        Book::factory(1)->create(['name' => 'Book 1', 'num_of_pages' => 200, 'num_of_read_pages' => 10]);
        Book::factory(1)->create(['name' => 'Book 2', 'num_of_pages' => 200, 'num_of_read_pages' => 100]);
        Book::factory(1)->create(['name' => 'Book 3', 'num_of_pages' => 200, 'num_of_read_pages' => 60]);
        Book::factory(1)->create(['name' => 'Book 4', 'num_of_pages' => 200, 'num_of_read_pages' => 20]);
        Book::factory(1)->create(['name' => 'Book 5', 'num_of_pages' => 200, 'num_of_read_pages' => 30]);
        Book::factory(1)->create(['name' => 'Book 6', 'num_of_pages' => 200, 'num_of_read_pages' => 200]);

        $response = $this->get($this->list_recommended_books);

        $response->assertStatus(200)
            ->assertJsonFragment([
                "books" => [
                    [
                        "book_id" => 6,
                        "book_name" => "Book 6",
                        "num_of_read_pages" => 200
                    ],
                    [
                        "book_id" => 2,
                        "book_name" => "Book 2",
                        "num_of_read_pages" => 100
                    ],
                    [
                        "book_id" => 3,
                        "book_name" => "Book 3",
                        "num_of_read_pages" => 60
                    ],
                    [
                        "book_id" => 5,
                        "book_name" => "Book 5",
                        "num_of_read_pages" => 30
                    ],
                    [
                        "book_id" => 4,
                        "book_name" => "Book 4",
                        "num_of_read_pages" => 20
                    ]
                ]
            ]);
    }

    public function test_less_than_5_items()
    {
        Book::factory(1)->create(['name' => 'Book 1', 'num_of_pages' => 200, 'num_of_read_pages' => 10]);
        Book::factory(1)->create(['name' => 'Book 2', 'num_of_pages' => 200, 'num_of_read_pages' => 100]);
        Book::factory(1)->create(['name' => 'Book 3', 'num_of_pages' => 200, 'num_of_read_pages' => 60]);
        $response = $this->get($this->list_recommended_books);

        $response->assertStatus(200)
            ->assertJsonFragment([
                "books" => [
                    [
                        "book_id" => 2,
                        "book_name" => "Book 2",
                        "num_of_read_pages" => 100
                    ],
                    [
                        "book_id" => 3,
                        "book_name" => "Book 3",
                        "num_of_read_pages" => 60
                    ],
                    [
                        "book_id" => 1,
                        "book_name" => "Book 1",
                        "num_of_read_pages" => 10
                    ]
                ]
            ]);
    }
}
