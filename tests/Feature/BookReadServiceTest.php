<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\BookRead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReadServiceTest extends TestCase
{
    use RefreshDatabase;
    private $new_book_read_api = 'api/book_read/new', $list_recommended_books = '';

    public function testStoreNewIntervalWithOverlappingIntervals()
    {
        Book::factory(1)->create();
        User::factory(1)->create();

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1,
            'user_id' => 1,
            'start_page' => 5,
            'end_page' => 10,
        ]);
        $response->assertStatus(200);

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1,
            'user_id' => 1,
            'start_page' => 6,
            'end_page' => 20,
        ]);
        $response->assertStatus(200);

        // Assert that the overlapping interval has been updated
        $this->assertEquals(5, BookRead::where('book_id', 1)->where('user_id', 1)->first()->start_page);
        $this->assertEquals(20, BookRead::where('book_id', 1)->where('user_id', 1)->first()->end_page);

        // Assert that a new interval has been created
        $this->assertCount(1, BookRead::all());
        $this->assertEquals(16, Book::find(1)->num_of_read_pages);
    }

    public function testStoreNewIntervalWithNoOverlappingIntervals()
    {
        Book::factory(1)->create();
        User::factory(1)->create();

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1,
            'user_id' => 1,
            'start_page' => 1,
            'end_page' => 10,
        ]);
        $response->assertStatus(200);

        // Assert that a new interval has been created
        $this->assertCount(1, BookRead::all());
        $this->assertEquals(10, Book::find(1)->num_of_read_pages);
    }


    public function testStoreNewIntervalWithOverlappingIntervals1()
    {
        Book::factory(1)->create();
        User::factory(1)->create();

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1, 'user_id' => 1,  'start_page' => 1, 'end_page' => 10,
        ]);

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1,  'user_id' => 1,  'start_page' => 20, 'end_page' => 30,
        ]);

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1,  'user_id' => 1, 'start_page' => 5, 'end_page' => 25,
        ]);

        $response->assertStatus(200);

        // Assert that a new interval has been created
        $this->assertCount(1, BookRead::all());
        $this->assertEquals(1, BookRead::where('book_id', 1)->where('user_id', 1)->first()->start_page);
        $this->assertEquals(30, BookRead::where('book_id', 1)->where('user_id', 1)->first()->end_page);
        $this->assertEquals(30, Book::find(1)->num_of_read_pages);

    }

    public function testStoreNewIntervalWithInvalidPages()
    {

        Book::factory(1)->create();
        User::factory(1)->create();

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1,
            'user_id' => 1,
            'start_page' => 25,
            'end_page' => 10,
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(["errors" => ["end_page"], "success"]);
    }

    public function testStoreNewIntervalWithNonExistentBook()
    {
        User::factory(1)->create();

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 999,
            'user_id' => 1,
            'start_page' => 1,
            'end_page' => 10,
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(["errors" => ["book_id"], "success"]);
    }

    public function testEmptyRequest()
    {
        $response = $this->post($this->new_book_read_api, []);
        $response->assertStatus(422);
        $response->assertJsonStructure(["errors" => ["book_id", "user_id", "start_page", "end_page"], "success"]);
    }

    public function testInvalidTypesRequest()
    {
        $response = $this->post($this->new_book_read_api, [
            'book_id' => 'x',
            'user_id' => 'x',
            'start_page' => 'x',
            'end_page' => 'x',
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(["errors" => ["book_id", "user_id", "start_page", "end_page"], "success"]);
    }

    public function testStoreNewIntervalWithNonExistentUser()
    {
        Book::factory(1)->create();

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1,
            'user_id' => 21,
            'start_page' => 1,
            'end_page' => 10,
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(["errors" => ["user_id"], "success"]);
    }
}
