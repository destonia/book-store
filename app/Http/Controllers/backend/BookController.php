<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
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
        $authors = $this->authorService->getAll()->except(1);
        return view('backend.book.edit', compact('book', 'authors', 'categories'));
    }

    public function store(BookRequest $request)
    {
        $this->bookService->store($request);
        toastr()->success('Book: ' . $request->name . ' has been added', 'Add Book');
        return redirect()->route('books.index')->withInput();
    }

    public function update(Request $request)
    {
        $this->bookService->update($request);
        toastr()->success('Book: ' . $request->name . ' has been updated', 'Update Book');
        return redirect()->route('books.index');
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $deleted = $this->bookService->getById($id);
        $this->bookService->delete($id);
        toastr()->error('Book: ' . '<strong>' . $deleted->name . '</strong>' . ' has been deleted', 'Delete Book');
        return redirect()->route('books.index');
    }

    public function search(Request $request)
    {
        $name = $request->search;
        $output = '';
        $books = $this->bookService->getByName($name);
        if ($books) {
            foreach ($books as $key => $book) {
                $avatarPath = asset('storage/' . $book->avatar);
                $avatar = '<img src="' . $avatarPath . '"' . 'style="' . 'height: 50px' . '"' . 'id="' . 'bookAvatar' . '"' . '>';
                $categories = '';
                foreach ($book->categories as $category){
                    $categories .= $category->name.', ';
                }
                $authors = '';
                foreach ($book->authors as $author){
                    $authors .= $author->name.', ';
                }
                $output .= '<tr>
                    <td class="center" style="padding-top: 20px">' . ($key + 1) . '</td>
                    <td class="center">' . $avatar . '</td>
                    <td class="center" style="padding-top: 20px">' . $book->name . '</td>
                    <td class="center" style="padding-top: 20px">' . $categories . '</td>
                    <td class="center" style="padding-top: 20px">' . $authors . '</td>
                    <td class="center" style="padding-top: 20px">' . $book->publish_date . '</td>
                    <td class="center" style="padding-top: 20px">' . $book->republish_no . '</td>
                    <td class="center" style="padding-top: 20px">' . $book->isbn_no . '</td>
                    <td class="center" style="padding-top: 20px">' . $book->publisher . '</td>
                    <td class="center" style="padding-top: 20px">' . $book->license_no . '</td>
                    <td class="center" style="padding-top: 20px" hidden id="bookId" data-value="{{$book->id}}">{{"MSB - ".$book->id}}</td>
                    <td class="center" style="padding-top: 20px">
                    <div class="hidden-sm hidden-xs btn-group">

                        <a class="btn btn-xs btn-info" href="'.'{{route("'.'"books.edit",'.$book->id.')}}'.'"><i
                            class="ace-icon fa fa-pencil bigger-120"></i></a>
                        <a class=" btn btn-xs btn-danger delete-button" href="#delete-modal-form" data-toggle="modal" role="button"><i
                                class="ace-icon btn-danger fa fa-trash bigger-120"></i></a>

                    </div>

                    <div class="hidden-md hidden-lg">
                        <div class="inline pos-rel">
                            <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown"
                                    data-position="auto">
                                <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                <li>
                                    <a href="#" class="tooltip-info" data-rel="tooltip" title="View">
																			<span class="blue">
																				<i class="ace-icon fa fa-search-plus bigger-120"></i>
																			</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
																			<span class="green">
																				<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																			</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="tooltip-error"  data-rel="tooltip" title="Delete">
																			<span class="red">
																				<i class="ace-icon fa fa-trash-o bigger-120"></i>
																			</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </td>
                    </tr>';
            }
        }

        return Response($output);
    }
}
