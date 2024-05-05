<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\BooksModule\Models\Book;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('book_reads', function (Blueprint $table) {

            $table->foreignIdFor(Book::class);
            $table->foreignIdFor(User::class);
            $table->unsignedBigInteger('start_page');
            $table->unsignedBigInteger('end_page');
            $table->unsignedBigInteger('num_of_pages');
            
            // $table->timestamps();

            $table->index('user_id');
            $table->index('book_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_reads');
    }
};
