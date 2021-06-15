<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Http\Requests\Search;
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
        return view('backend.book.list', compact('books', 'authors'));
    }
    public function showTrashed(){
        $books = $this->bookService->getTrashed();
        $authors = $this->authorService->getAll();
        return view('backend.book.trashed', compact('books', 'authors'));

    }
    public function create()
    {
        $authors = $this->authorService->getAll();
        $categories = $this->categoryService->getAll();
        return view('backend.book.create', compact('authors', 'categories'));
    }

    public function edit($id)
    {
        $book = $this->bookService->getById($id);
        $selectedCategories = [];
        foreach ($book->categories as $category) {
            array_push($selectedCategories, $category->id);
        }
        $categories = $this->categoryService->getAll()->except($selectedCategories);
        $selectedAuthors = [];
        foreach ($book->categories as $author) {
            array_push($selectedAuthors, $author->id);
        }
        $authors = $this->authorService->getAll()->except($selectedAuthors);
        return view('backend.book.edit', compact('book', 'authors', 'categories'));
    }

    public function store(BookRequest $request)
    {
        $this->bookService->store($request);
        toastr()->success('Book: ' . $request->name . ' has been added', 'Add Book');
        return redirect()->route('books.index')->withInput();
    }

    public function update(BookRequest $request)
    {
        $this->bookService->update($request);
        toastr()->success('Book: ' . $request->name . ' has been updated', 'Update Book');
        return redirect()->route('books.index');
    }
    public function updateViewCount(Request $request){
        $id = $request->id;
        $this->bookService->updateViewCount();
    }
    public function showDeleteForm(Request $request)
    {
        $book = $this->bookService->getById($request->id);
        $orders = $book->orders;
        $order_ids = [];
        $order_names = [];
        foreach ($orders as $order) {
            array_push($order_ids, $order->id);
            array_push($order_names, $order->name);
        }
        $data = [
            'book_id' => $book->id,
            'book_name' => $book->name,
            'book_avatar' => asset('storage/' . $book->avatar),
            'order_id' => $orders,
            'order_name' => $order_names,
        ];
        return Response($data);
    }

    public function softDelete(Request $request)
    {
        $id = $request->id;
        $book = $this->bookService->getById($id);
        $this->bookService->softDelete($book);
        toastr()->error('Book: ' . '<strong>' . $book->name . '</strong>' . ' has been deleted', 'Delete Book');
        return redirect()->route('books.index');
    }
    public function restore($id){
        $book = $this->bookService->restore($id);
        toastr()->success('Book: ' . '<strong>' . $book->name . '</strong>' . ' has been restored', 'Restore Book');
        return redirect()->route('books.trashed');
    }
    public function delete(Request $request)
    {
        $id = $request->id;
        $deleted = $this->bookService->getTrashedById($id);
        $this->bookService->delete($id);
        toastr()->error('Book: ' . '<strong>' . $deleted->name . '</strong>' . ' has been deleted', 'Delete Book');
        return redirect()->route('books.index');
    }

    public function search(Search $request)
    {
        $name = $request->search;
        $output = $this->bookService->search($name);
        return Response($output);
    }
    public function searchInTrash(Search $request)
    {
        $name = $request->search;
        $output = $this->bookService->searchInTrash($name);
        return Response($output);
    }
}
