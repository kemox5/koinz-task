<?php

namespace Modules\BooksModule\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\BooksModule\Database\factories\BookFactory;

class Book extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['num_of_read_pages'];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory<static>
     */
    protected static function newFactory()
    {
        return BookFactory::new();
    }
}
