<?php

namespace App\Http\Controllers;

use App\Http\Controllers\backend\AuthorController;
use App\Http\Controllers\backend\BookController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Services\AuthorService;
use App\Http\Services\BookService;
use App\Http\Services\CategoryService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $bookService;
    protected $categoryService;
    protected $authorService;
    public function __construct
    (
        BookService $bookService,
        CategoryService $categoryService,
        AuthorService $authorService
    )
    {
        $this->bookService = $bookService;
        $this->categoryService = $categoryService;
        $this->authorService = $authorService;
    }

    public function index(){
        $books = $this->bookService->getAll();
        $categories = $this->categoryService->getAll();
        $authors = $this->authorService->getAll();
        return view('frontend.home',compact('books','categories','authors'));
    }
}
