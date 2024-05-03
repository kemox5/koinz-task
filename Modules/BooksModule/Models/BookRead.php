<?php

namespace Modules\BooksModule\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\BooksModule\Database\factories\BookFactory;

class BookRead extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['book_id', 'user_id', 'start_page', 'end_page', 'num_of_pages'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
