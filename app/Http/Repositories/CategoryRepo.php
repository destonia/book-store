<?php


namespace App\Http\Repositories;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryRepo
{
    public function getAll(){
        return Category::all();
    }
    public function getById($id){
        return Category::findOrFail($id);
    }
    public function getTrashed(){
        return Category::onlyTrashed()->get();
    }
    public function getTrashedById($id){
        return Category::onlyTrashed()->where('id','=',$id);
    }
    public function store($category){
        $category->save();
    }
    public function delete($category){
        $category->delete();
    }
    public function restore($category){
        $category->restore();
    }
    public function getByName($name){
        return DB::table('categories')->where('name','like','%'.$name.'%')->get();
    }
}
