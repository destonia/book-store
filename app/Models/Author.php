<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'avatar',
        'book_qty',
        'born',
        'die',
        'wiki_link',
        'country',
    ];
}
