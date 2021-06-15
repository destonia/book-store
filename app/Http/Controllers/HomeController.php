<?php

namespace App\Http\Controllers;

use App\Http\Services\BookService;
use App\Http\Services\CategoryService;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $bookService;
    protected $categoryService;
    public function __construct(BookService $bookService,CategoryService $categoryService)
    {
        $this->bookService = $bookService;
        $this->categoryService = $categoryService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $books = $this->bookService->getAll();
        $topTenOrder = $this->bookService->getTopTenOrder();
        $hots = $this->bookService->getHot();
        $recommends = $this->bookService->getRecommend();
        $categories = $this->categoryService->getAll();
        return view('frontend.home',compact('books','topTenOrder','hots','recommends','categories'));
    }
    public function listBook(){
        $books = $this->bookService->getAll();
        $categories = $this->categoryService->getAll();
        return view('frontend.list',compact('books','categories'));

    }
    public function viewBookDetail($id){
        $book = Book::findOrFail($id);
        $categories = $this->categoryService->getAll();
        $thisCategories = $book->categories;
        $relatedBooks = [];
        foreach ($thisCategories as $category){
            $relatedBooks = $category->books;
        }
        $this->bookService->updateViewCount($id);
        return view('frontend.book-detail',compact('book','categories','relatedBooks'));
    }
    public function viewByCategory(Request $request){
        $id = $request->id;
        $books = $this->bookService->getByCategory($id);
        $categories = $this->categoryService->getAll();
        return view('frontend.list',compact('books','categories'));
    }
}
