<?php


namespace App\Http\Services;


use App\Http\Repositories\BookRepo;
use App\Models\Book;

class BookService
{
    protected $bookRepo;
    public function __construct(BookRepo $bookRepo)
    {
        $this->bookRepo = $bookRepo;
    }
    public function getAll(){
        return $this->bookRepo->getAll();
    }
    public function getById($id){
        return $this->bookRepo->getById($id);
    }
    public function store($request){
        $book = new Book();
        $book->fill($request->all());
        $this->bookRepo->store($book);
    }
    public function update($request){
        $book = $this->bookRepo->getById($request->id);
        $book->fill($request->all());
        if ($request->hasFile('avatar')){
            $filePath = $request->file('avatar')->store('categories','public');
            $book->avatar = $filePath;
        }
        $this->bookRepo->store($book);
    }
    public function delete($id){
        $book = $this->bookRepo->getById($id);
        $this->bookRepo->delete($book);
    }
    public function search($name){
        return $this->bookRepo->getByName($name);
    }
}
