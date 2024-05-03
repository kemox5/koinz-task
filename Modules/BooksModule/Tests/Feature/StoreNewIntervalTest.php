<?php

namespace Modules\BooksModule\Tests\Feature;

use App\Exceptions\Handler;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Modules\BooksModule\Models\Book;
use Modules\BooksModule\Models\BookRead;
use Tests\TestCase;
use Throwable;

class StoreNewIntervalTest extends TestCase
{
    use RefreshDatabase;
    private $new_book_read_api = 'api/book_read/new', $list_recommended_books = '';

    public function createUserandBook()
    {
        Book::factory(1)->create();
        User::factory(1)->create([
            'phone_number' => '11111'
        ]);
    }


    public function test_single_new_interval()
    {
        $this->createUserandBook();

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1, 'user_id' => 1, 'start_page' => 1, 'end_page' => 10,
        ]);
        $response->assertStatus(200);

        // Assert that a new interval has been created
        $this->assertCount(1, BookRead::all());
        $this->assertEquals(10, Book::find(1)->num_of_read_pages);
    }

    public function test_vodafone_sms()
    {
        Config::set('smsgateway.provider', 'vodafone');

        Log::shouldReceive('info')->once()->with('VodafoneSMSGateway: SMS sent to 11111 with message Thank you for your submition!');

        $this->createUserandBook();

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1, 'user_id' => 1, 'start_page' => 1, 'end_page' => 10,
        ]);
        $response->assertStatus(200);
    }

    public function test_no_sms_config()
    {
        Config::set('smsgateway.provider', null);

        Log::shouldReceive('error')->once()->with('No gateway configuration found!');

        $this->createUserandBook();

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1, 'user_id' => 1, 'start_page' => 1, 'end_page' => 10,
        ]);
        $response->assertStatus(200);
    }

    public function test_etislate_sms()
    {
        Config::set('smsgateway.provider', 'etisalat');

        Log::shouldReceive('info')->once()->with('EtisalatSMSGateway: SMS sent to 11111 with message Thank you for your submition!');

        $this->createUserandBook();

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1, 'user_id' => 1, 'start_page' => 1, 'end_page' => 10,
        ]);
        $response->assertStatus(200);
    }

   

    public function test_two_intervals_with_overlapping_1()
    {
        $this->createUserandBook();

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

    public function test_two_intervals_with_overlapping_2()
    {
        $this->createUserandBook();

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1,
            'user_id' => 1,
            'start_page' => 50,
            'end_page' => 100,
        ]);
        $response->assertStatus(200);

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1,
            'user_id' => 1,
            'start_page' => 10,
            'end_page' => 80,
        ]);
        $response->assertStatus(200);

        // Assert that the overlapping interval has been updated
        $this->assertEquals(10, BookRead::where('book_id', 1)->where('user_id', 1)->first()->start_page);
        $this->assertEquals(100, BookRead::where('book_id', 1)->where('user_id', 1)->first()->end_page);

        // Assert that a new interval has been created
        $this->assertCount(1, BookRead::all());
        $this->assertEquals(91, Book::find(1)->num_of_read_pages);
    }

    public function test_three_intervals_with_overlapping_1()
    {
        $this->createUserandBook();

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

    public function test_three_intervals_with_overlapping_2()
    {
        $this->createUserandBook();

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1, 'user_id' => 1,  'start_page' => 5, 'end_page' => 10,
        ]);

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1,  'user_id' => 1,  'start_page' => 20, 'end_page' => 30,
        ]);

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1,  'user_id' => 1, 'start_page' => 1, 'end_page' => 40,
        ]);

        $response->assertStatus(200);

        // Assert that a new interval has been created
        $this->assertCount(1, BookRead::all());
        $this->assertEquals(1, BookRead::where('book_id', 1)->where('user_id', 1)->first()->start_page);
        $this->assertEquals(40, BookRead::where('book_id', 1)->where('user_id', 1)->first()->end_page);
        $this->assertEquals(40, Book::find(1)->num_of_read_pages);
    }

    public function test_three_intervals_with_overlapping_3()
    {
        $this->createUserandBook();

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1, 'user_id' => 1,  'start_page' => 5, 'end_page' => 10,
        ]);

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1,  'user_id' => 1,  'start_page' => 20, 'end_page' => 30,
        ]);

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1,  'user_id' => 1, 'start_page' => 10, 'end_page' => 20,
        ]);

        $response->assertStatus(200);

        // Assert that a new interval has been created
        $this->assertCount(1, BookRead::all());
        $this->assertEquals(5, BookRead::where('book_id', 1)->where('user_id', 1)->first()->start_page);
        $this->assertEquals(30, BookRead::where('book_id', 1)->where('user_id', 1)->first()->end_page);
        $this->assertEquals(26, Book::find(1)->num_of_read_pages);
    }

    public function test_multiple_intervals_without_overlapping()
    {
        $this->createUserandBook();

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1, 'user_id' => 1,  'start_page' => 1, 'end_page' => 10,
        ]);

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1,  'user_id' => 1,  'start_page' => 21, 'end_page' => 30,
        ]);

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1,  'user_id' => 1, 'start_page' => 41, 'end_page' => 50,
        ]);

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1,  'user_id' => 1, 'start_page' => 61, 'end_page' => 70,
        ]);

        $response->assertStatus(200);

        // Assert that a new interval has been created
        $this->assertCount(4, BookRead::all());
        $this->assertEquals(40, Book::find(1)->num_of_read_pages);
    }

    public function test_multiple_intervals_some_with_overlapping_some_without()
    {
        $this->createUserandBook();

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1, 'user_id' => 1,  'start_page' => 1, 'end_page' => 11,
        ]);

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1,  'user_id' => 1,  'start_page' => 11, 'end_page' => 20,
        ]);

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1,  'user_id' => 1, 'start_page' => 41, 'end_page' => 50,
        ]);

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1,  'user_id' => 1, 'start_page' => 61, 'end_page' => 80,
        ]);

        $response->assertStatus(200);

        // Assert that a new interval has been created
        $this->assertCount(3, BookRead::all());
        $this->assertEquals(50, Book::find(1)->num_of_read_pages);
    }

    public function test_with_invalid_pages()
    {

        $this->createUserandBook();

        $response = $this->post($this->new_book_read_api, [
            'book_id' => 1,
            'user_id' => 1,
            'start_page' => 25,
            'end_page' => 10,
        ]);

        $response->assertJsonStructure(["errors" => ["end_page"], "success"]);
    }

    public function test_with_non_existent_book()
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

    public function test_empty_request()
    {

        $response = $this->post($this->new_book_read_api, []);
        $response->assertStatus(422);
        $response->assertJsonStructure(["errors" => ["book_id", "user_id", "start_page", "end_page"], "success"]);
    }

    public function test_invalid_types_request()
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

    public function test_with_non_existent_user()
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
