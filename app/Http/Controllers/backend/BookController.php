<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Http\Services\AuthorService;
use App\Http\Services\BookService;
use App\Http\Services\CategoryService;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $bookService;
    protected $authorService;
    protected $categoryService;

    public function __construct(
        BookService $bookService,
        AuthorService $authorService,
        CategoryService $categoryService
    )
    {
        $this->bookService = $bookService;
        $this->authorService = $authorService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $authors = $this->authorService->getAll();
        $books = $this->bookService->getAll();
        return view('backend.book.list', compact('books','authors'));
    }

    public function create()
    {
        $authors = $this->authorService->getAll();
        $categories = $this->categoryService->getAll();
        return view('backend.book.create',compact('authors','categories'));
    }

    public function edit($id)
    {
        $book = $this->bookService->getById($id);
        $selectedCategories = [];
        foreach ($book->categories as $category){
            array_push($selectedCategories,$category->id);
        }
        $categories = $this->categoryService->getAll()->except($selectedCategories);
        $selectedAuthors = [];
        foreach ($book->categories as $author){
            array_push($selectedAuthors,$author->id);
        }
        $authors = $this->authorService->getAll()->except(1);
        return view('backend.book.edit', compact('book','authors','categories'));
    }

    public function store(BookRequest $request)
    {
        $this->bookService->store($request);
        toastr()->success('Book: '.$request->name.' has been added','Add Book');
        return redirect()->route('books.index')->withInput();
    }

    public function update(Request $request)
    {
        $this->bookService->update($request);
        toastr()->success('Book: '.$request->name.' has been updated','Update Book');
        return redirect()->route('books.index');
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $deleted = $this->bookService->getById($id);
        $this->bookService->delete($id);
        toastr()->error('Book: '.'<strong>'.$deleted->name.'</strong>'.' has been deleted','Delete Book');
        return redirect()->route('books.index');
    }

    public function search(Request $request)
    {
        $name = $request->search;
        $books = $this->bookService->search($name);
        return view('backend.book.list', compact('books'));
    }
}
