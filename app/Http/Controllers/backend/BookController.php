<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Services\AuthorService;
use App\Http\Services\BookService;
use App\Http\Services\CategoryService;
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
        return view('backend.book.edit', compact('book'));
    }

    public function store(Request $request)
    {
        dd($request);
        $this->bookService->store($request);
        return redirect()->route('books.index');
    }

    public function update(Request $request)
    {
        $this->bookService->update($request);
        return redirect()->route('books.index');
    }

    public function delete($id)
    {
        $this->bookService->delete($id);
        return redirect()->route('books.index');
    }

    public function search(Request $request)
    {
        $name = $request->search;
        $books = $this->bookService->search($name);
        return view('backend.book.list', compact('books'));
    }
}
