<?php


namespace App\Http\Services;


use App\Http\Repositories\AuthorRepo;
use App\Models\Author;
use Illuminate\Database\Eloquent\Model;

class AuthorService
{
    protected $authorRepo;
    public function __construct(AuthorRepo $authorRepo)
    {
        $this->authorRepo = $authorRepo;
    }
    public function getAll(){
        return $this->authorRepo->getAll();
    }
    public function getById($id){
        return $this->authorRepo->getById($id);
    }
    public function store($request){
        $author = new Author();
        $author->fill($request->all());
        $filePath = $request->file('avatar')->store('authors','public');
        $author->avatar = $filePath;
        $this->authorRepo->store($author);
    }
    public function update($request){
        $author = $this->authorRepo->getById($request->id);
        $author->fill($request->all());
        if ($request->hasFile('avatar')){
            $filePath = $request->file('avatar')->store('authors','public');
            $author->avatar = $filePath;
        }
        $this->authorRepo->store($author);
    }
    public function delete($id){
        $author = $this->authorRepo->getById($id);
        $this->authorRepo->delete($author);
    }
    public function search($name){
        return $this->authorRepo->getByName($name);
    }
}
