<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    protected $fillable = [
        'name',
        'ship_cost',
        'total',
        'status',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function books(){
        return $this->belongsToMany(Book::class,'order_details','order_id','book_id');
    }
    public function orderDetails(){
        return $this->hasMany(OrderDetail::class,'order_id','id');
    }
    use HasFactory;
    use Notifiable,
        SoftDeletes;
}
