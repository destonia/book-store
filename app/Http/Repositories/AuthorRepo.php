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
    public function store($author){
        $author->save();
    }
    public function delete($author){
        $author->delete();
    }
    public function getByName($name){
        return DB::table('authors')->where('name','like','%'.$name.'%')->get();
    }
}
