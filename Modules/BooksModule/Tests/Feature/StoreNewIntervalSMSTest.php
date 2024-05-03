<?php

namespace Modules\BooksModule\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Modules\BooksModule\Models\Book;
use Tests\TestCase;

class StoreNewIntervalSMSTest extends TestCase
{
    use RefreshDatabase;
    private $new_book_read_api = 'api/book_read/new', $list_recommended_books = 'api/books/top';

    public function setUp(): void
    {
        parent::setUp();
    }

    public function createUserandBook()
    {
        Book::factory(1)->create();
        User::factory(1)->create([
            'phone_number' => '11111'
        ]);
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

}
