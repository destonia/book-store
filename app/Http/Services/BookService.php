<?php


namespace App\Http\Services;


use App\Http\Repositories\AuthorRepo;
use App\Http\Repositories\BookRepo;
use App\Http\Repositories\CategoryRepo;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class BookService
{
    protected $bookRepo;
    protected $categoryService;
    protected $authorService;
    protected $categoryRepo;
    protected $authorRepo;

    public function __construct(
        BookRepo $bookRepo,
        CategoryService $categoryService,
        AuthorService $authorService,
        CategoryRepo $categoryRepo,
        AuthorRepo $authorRepo
    )
    {
        $this->bookRepo = $bookRepo;
        $this->categoryService = $categoryService;
        $this->authorService = $authorService;
        $this->categoryRepo = $categoryRepo;
        $this->authorRepo = $authorRepo;
    }

    public function getAll()
    {
        return $this->bookRepo->getAll();
    }

    public function getById($id)
    {
        return $this->bookRepo->getById($id);
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $book = new Book();
            $book->fill($request->all());
            if ($request->hot == 'on'){
                $book->hot = 1;
            }
            if ($request->recommend == 'on'){
                $book->recommend = 1;
            }
            if ($request->hasFile('avatar')) {
                $filePath = $request->file('avatar')->store('books', 'public');
                $book->avatar = $filePath;
            }
            $this->bookRepo->store($book);
            $book->categories()->sync($request->category_id);
            $book->authors()->sync($request->author_id);
            foreach ($request->category_id as $category_id){
                $category = $this->categoryService->getById($category_id);
                $oldTotalBook = $category->total_book;
                $category->total_book = $oldTotalBook + 1;
                $this->categoryRepo->store($category);
            }
            foreach ($request->author_id as $author_id){
                $author = $this->authorService->getById($author_id);
                $oldTotalBook = $author->total_book;
                $author->total_book = $oldTotalBook + 1;
                $this->authorRepo->store($author);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($book, $exception);
        }
    }

    public function update($request)
    {
        DB::beginTransaction();
        try {
            $book = $this->bookRepo->getById($request->id);
            $book->fill($request->all());
            if ($request->hot == 'on'){
                $book->hot = 1;
            }else $book->hot = 0;

            if ($request->recommend == 'on'){
                $book->recommend = 1;
            }else $book->recommend = 0;
            if ($request->hasFile('avatar')) {
                $filePath = $request->file('avatar')->store('categories', 'public');
                $book->avatar = $filePath;
            }
            $this->bookRepo->store($book);
            $book->categories()->sync($request->category_id);
            $book->authors()->sync($request->author_id);
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            dd($exception);
        }

    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $book= new Book();
            $book = $this->bookRepo->getById($id);

            foreach ($book->categories as $category){
                $oldTotalBook = $category->total_book;
                $category->total_book = $oldTotalBook - 1;
                $this->categoryRepo->store($category);
            }
            $book->categories()->detach($book->categories);

            foreach ($book->authors as $category){
                $oldTotalBook = $category->total_book;
                $category->total_book = $oldTotalBook - 1;
                $this->categoryRepo->store($category);
            }
            $book->authors()->detach($book->authors);
            $this->bookRepo->delete($book);
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            dd($book,$exception);
        }
    }

    public function search($name)
    {
        return $this->bookRepo->getByName($name);
    }
}
