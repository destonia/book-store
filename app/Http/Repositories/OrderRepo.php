<?php


namespace App\Http\Repositories;


use App\Models\Book;
use App\Models\Order;

class OrderRepo
{
    public function getAll()
    {
        return Order::all();
    }
    public function getTrashed()
    {
        return Order::onlyTrashed()->get();
    }
    public function getById($id)
    {
        return Order::findOrFail($id);
    }
    public function restoreTrashed($id)
    {
        Order::withTrashed()->where('id',$id)->restore();
    }
    public function getByBook($book){
        $book = Book::findOrFail($book);
        $orders = $book->orders;
        return $orders;
    }
    public function store($order)
    {
        $order->save();
    }
    public function softDelete($order){
        $order->delete();
    }
    public function delete($order){
        $order->delete();
    }
}
