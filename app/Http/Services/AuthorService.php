<?php


namespace App\Http\Services;


use App\Http\Repositories\AuthorRepo;
use App\Models\Author;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
    public function update($request, $author){
        $author->fill($request->all());
        if ($request->hasFile('avatar')){
            $filePath = $request->file('avatar')->store('authors','public');
            $author->avatar = $filePath;
        }
        $this->authorRepo->store($author);
    }
    public function softDelete($id){
        $author = $this->authorRepo->getById($id);
        $this->authorRepo->softDelete($author);
    }
    public function getTrashed(){
        return $this->authorRepo->getTrashed();
    }
    public function restore($id){
        $this->authorRepo->restore($id);
    }
    public function delete($id){
        $author = $this->authorRepo->getTrashedById($id);
        DB::beginTransaction();
        try {
            $author->books()->detach($author->books);
            $this->authorRepo->delete($author);
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            dd($exception,$author->books);
        }
    }
    public function search($name){
        return $this->authorRepo->getByName($name);
    }
}
