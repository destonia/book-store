<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Category extends Model
{
    use HasFactory;
    use Notifiable,
        SoftDeletes;

    protected $fillable = [
        'name',
    ];
    public function books(){
        return $this->belongsToMany(Book::class,'book_category','category_id','book_id');
    }
}
