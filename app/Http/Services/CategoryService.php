<?php


namespace App\Http\Services;
use App\Http\Repositories\CategoryRepo;
use App\Models\Category;
class CategoryService
{
    protected $categoryRepo;
    public function __construct(CategoryRepo $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
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
    public function update($request){
        $category = $this->categoryRepo->getById($request->id);
        $category->fill($request->all());
        if ($request->hasFile('avatar')){
            $filePath = $request->file('avatar')->store('categories','public');
            $category->avatar = $filePath;
        }
        $this->categoryRepo->store($category);
    }
    public function delete($id){
        $category = $this->categoryRepo->getById($id);
        $this->categoryRepo->delete($category);
    }
    public function search($name){
        return $this->categoryRepo->getByName($name);
    }
}
