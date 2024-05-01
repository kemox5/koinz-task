<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookRead extends Model
{
    use HasFactory;

    protected $fillable = ['book_id', 'user_id', 'start_page', 'end_page', 'num_of_pages'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
