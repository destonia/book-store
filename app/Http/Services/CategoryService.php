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
    public function store($request){
        $category = new Category();
        $category->fill($request->all());
        $this->categoryRepo->store($category);
    }
    public function update($category){
        $this->categoryRepo->store($category);
    }
    public function delete($id){
        $category = $this->categoryRepo->getById($id);
        $books = $category->books;
        DB::beginTransaction();
        try {
            $category->books()->detach($books);
            $this->categoryRepo->delete($category);
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            dd($exception,$books);
        }

    }
    public function search($name){
        return $this->categoryRepo->getByName($name);
    }
}
