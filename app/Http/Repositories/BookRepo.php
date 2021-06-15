<?php


namespace App\Http\Repositories;


use App\Models\Book;
use Illuminate\Support\Facades\DB;

class BookRepo
{
    public function getAll(){
        return Book::all();
    }
    public function getTopTenOrder(){
        return Book::all()->sortByDesc('orders_count')->take(5);
    }
    public function getRecommend(){
        return Book::all()->where('recommend','=',1)->take(5);
    }
    public function getHot(){
        return (Book::all()->where('hot','=',1))->take(5);
    }
    public function getTrashed(){
        return Book::onlyTrashed()->get();
    }
    public function getTrashedById($id){
        return Book::onlyTrashed()->where('id',$id)->get();
    }
    public function getById($id){
        return Book::findOrFail($id);
    }
    public function store($book){
        $book->save();
    }
    public function softDelete($book){
        $book->delete();
    }
    public function restore($id){
        return Book::withTrashed()->where('id',$id)->restore();
    }
    public function delete($book){
        $book->delete();
    }
    public function getByName($name){
        return Book::where('name','like','%'.$name.'%')->get();
    }
    public function getByNameInTrash($name){
        return Book::onlyTrashed()->where('name','like','%'.$name.'%')->get();
    }
}
