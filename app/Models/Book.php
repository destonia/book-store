<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin Builder
 */

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'publisher',
        'publish_date',
        'republish_no',
        'license_no',
        'isbn_no',
        'qty',
        'pages',
        'price',
        'lang',
        'detail',
        'recommend',
        'hot',
        'desc',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_category', 'book_id', 'category_id');
    }
    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_author', 'book_id', 'author_id');
    }
}
