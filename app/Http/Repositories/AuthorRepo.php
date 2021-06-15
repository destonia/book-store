<?php


namespace App\Http\Repositories;


use App\Models\Author;
use Illuminate\Support\Facades\DB;

class AuthorRepo
{
    public function getAll(){
        return Author::all();
    }
    public function getById($id){
        return Author::findOrFail($id);
    }
    public function getTrashed(){
        return Author::onlyTrashed()->get();
    }
    public function getTrashedById($id){
        return Author::withTrashed()->where('id','=',$id);
    }
    public function store($author){
        $author->save();
    }
    public function softDelete($author){
        $author->delete();
    }
    public function restore($id){
        Author::withTrashed()->where('id',$id)->restore();
    }
    public function delete($author){
        $author->forceDelete();
    }
    public function getByName($name){
        return DB::table('authors')->where('name','like','%'.$name.'%')->get();
    }
}
