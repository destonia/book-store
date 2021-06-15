<?php


namespace App\Http\Services;
use App\Http\Repositories\BookRepo;
use App\Http\Repositories\CategoryRepo;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    protected $categoryRepo;
    protected $bookRepo;
    public function __construct
    (
        CategoryRepo $categoryRepo,
        BookRepo $bookRepo
    )
    {
        $this->categoryRepo = $categoryRepo;
        $this->bookRepo = $bookRepo;
    }
    public function getAll(){
        return $this->categoryRepo->getAll();
    }
    public function getById($id){
        return $this->categoryRepo->getById($id);
    }
    public function getTrashed(){
        return $this->categoryRepo->getTrashed();
    }
    public function store($request){
        $category = new Category();
        $category->fill($request->all());
        $this->categoryRepo->store($category);
    }
    public function update($request){
        $category = $this->categoryRepo->getById($request->id);
        toastr()->info('Category: '.'<strong>'.$category->name.'</strong>'.' has been changed to '.'<strong>'.$request->name.'</strong>','Update category');
        $category->fill(request()->all());
        $this->categoryRepo->store($category);
    }
    public function delete($id){
        $category = $this->categoryRepo->getById($id);
        DB::beginTransaction();
        try {
            $this->categoryRepo->delete($category);
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            dd($exception);
        }

    }
    public function restore($id){
        $category = $this->categoryRepo->getTrashedById($id);
        $this->categoryRepo->restore($category);
    }
    public function search($name){
        return $this->categoryRepo->getByName($name);
    }
}
