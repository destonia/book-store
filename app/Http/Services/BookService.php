<?php


namespace App\Http\Services;


use App\Http\Repositories\AuthorRepo;
use App\Http\Repositories\BookRepo;
use App\Http\Repositories\CategoryRepo;
use App\Models\Book;
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

    public function getTrashed()
    {
        return $this->bookRepo->getTrashed();
    }

    public function getTrashedById($id)
    {
        return $this->bookRepo->getTrashedById($id);
    }

    public function getById($id)
    {
        return $this->bookRepo->getById($id);
    }

    public function getByName($name)
    {
        return $this->bookRepo->getByName($name);
    }

    public function getByCategory($id)
    {
        $categories = $this->categoryRepo->getById($id);
        return $categories->books;
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $book = new Book();
            $book->fill($request->all());
            if ($request->hot == 'on') {
                $book->hot = 1;
            }
            if ($request->recommend == 'on') {
                $book->recommend = 1;
            }
            if ($request->hasFile('avatar')) {
                $filePath = $request->file('avatar')->store('books', 'public');
                $book->avatar = $filePath;
            }
            $this->bookRepo->store($book);
            $book->categories()->sync($request->category_id);
            $book->authors()->sync($request->author_id);
            foreach ($request->category_id as $category_id) {
                $category = $this->categoryService->getById($category_id);
                $oldTotalBook = $category->total_book;
                $category->total_book = $oldTotalBook + 1;
                $this->categoryRepo->store($category);
            }
            foreach ($request->author_id as $author_id) {
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
            if ($request->hot == 'on') {
                $book->hot = 1;
            } else $book->hot = 0;

            if ($request->recommend == 'on') {
                $book->recommend = 1;
            } else $book->recommend = 0;
            if ($request->hasFile('avatar')) {
                $filePath = $request->file('avatar')->store('categories', 'public');
                $book->avatar = $filePath;
            }
            $this->bookRepo->store($book);
            $book->categories()->sync($request->category_id);
            $book->authors()->sync($request->author_id);
            foreach ($request->category_id as $category_id) {
                $category = $this->categoryService->getById($category_id);
                $oldTotalBook = $category->total_book;
                $category->total_book = $oldTotalBook + 1;
                $this->categoryRepo->store($category);
            }
            foreach ($request->author_id as $author_id) {
                $author = $this->authorService->getById($author_id);
                $oldTotalBook = $author->total_book;
                $author->total_book = $oldTotalBook + 1;
                $this->authorRepo->store($author);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception);
        }

    }

    public function updateQuantity($id, $quantity, $order)
    {
        $book = Book::findOrFail($id);
        $book->qty = $quantity;
        $book->orders_count = $order;
        $book->save();
    }

    public function updateViewCount($id)
    {
        $book = Book::findOrFail($id);
        $book->views += 1;
        $this->bookRepo->store($book);
    }

    public function updateOrderCount($id,$orderQty)
    {
        $book = Book::findOrFail($id);
        $book->orders_count += $orderQty;
        $this->bookRepo->store($book);
    }

    public function softDelete($book)
    {
        DB::beginTransaction();
        try {
            $this->bookRepo->softDelete($book);
            foreach ($book->categories as $category) {
                $oldTotalBook = $category->total_book;
                $category->total_book = $oldTotalBook - 1;
                $this->categoryRepo->store($category);
            }
            foreach ($book->authors as $author) {
                $oldTotalBook = $author->total_book;
                $author->total_book = $oldTotalBook - 1;
                $this->categoryRepo->store($author);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($book, $exception);
        }
    }

    public function restore($id)
    {
        DB::beginTransaction();
        try {
            $this->bookRepo->restore($id);
            $book = $this->bookRepo->getById($id);
            foreach ($book->categories as $category) {
                $oldTotalBook = $category->total_book;
                $category->total_book = $oldTotalBook + 1;
                $this->categoryRepo->store($category);
            }
            foreach ($book->authors as $author) {
                $oldTotalBook = $author->total_book;
                $author->total_book = $oldTotalBook + 1;
                $this->categoryRepo->store($author);
            }
            DB::commit();
            return $book;
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($book, $exception);
        }
    }

    public function delete($id)
    {

        $book = $this->bookRepo->getTrashedById($id);
        DB::beginTransaction();
        try {
            $book->categories()->detach($book->categories);
            $book->authors()->detach($book->authors);
            $book->orders()->detach($book->orders);
            $this->bookRepo->delete($book);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($book, $exception);
        }
    }

    public function search($name)
    {
        $output = '';
        $books = $this->bookRepo->getByName($name);
        if ($books) {
            foreach ($books as $key => $book) {
                $avatarPath = asset('storage/' . $book->avatar);
                $avatar = '<img src="' . $avatarPath . '"' . 'style="' . 'height: 50px' . '"' . 'id="' . 'bookAvatar' . '"' . '>';
                $categories = '';
                foreach ($book->categories as $category) {
                    $categories .= $category->name . ', ';
                }
                $authors = '';
                foreach ($book->authors as $author) {
                    $authors .= $author->name . ', ';
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
                    <td class="center" style="padding-top: 20px">MSB' . $book->license_no . '</td>
                    <td class="center" style="padding-top: 20px">$' . $book->price . '</td>
                    <td class="center" style="padding-top: 20px" hidden id="bookId">' . $book->id . '</td>
                    <td class="center" style="padding-top: 20px;text-align: center;width: 100px">
                    <div class="hidden-sm hidden-xs btn-group">

                        <a class="btn btn-xs btn-info" href="books/edit/' . $book->id . '"><i
                            class="ace-icon fa fa-pencil bigger-120"></i></a>
                        <a class=" btn btn-xs btn-danger delete-button" href="#delete-modal-form" data-toggle="modal" role="button"><i
                                class="ace-icon btn-danger fa fa-trash bigger-120"></i></a>

                    </div>
                </td>
                    </tr>';
            }
        }
        return $output;
    }

    public function searchInTrash($name)
    {
        $output = '';
        $books = $this->bookRepo->getByNameInTrash($name);
        if ($books) {
            foreach ($books as $key => $book) {
                $avatarPath = asset('storage/' . $book->avatar);
                $avatar = '<img src="' . $avatarPath . '"' . 'style="' . 'height: 50px' . '"' . 'id="' . 'bookAvatar' . '"' . '>';
                $categories = '';
                foreach ($book->categories as $category) {
                    $categories .= $category->name . ', ';
                }
                $authors = '';
                foreach ($book->authors as $author) {
                    $authors .= $author->name . ', ';
                }
                $output .= '<tr>
                    <td class="center" style="padding-top: 20px">' . ($key + 1) . '</td>
                    <td class="center">' . $avatar . '</td>
                    <td class="center" style="padding-top: 20px">' . $book->name . '</td>
                    <td class="center" style="padding-top: 20px">' . $categories . '</td>
                    <td class="center" style="padding-top: 20px">' . $authors . '</td>
                    <td class="center" style="padding-top: 20px">' . $book->publish_date . '</td>
                    <td class="center" style="padding-top: 20px">' . $book->republish_no . '</td>
                    <td class="center" style="padding-top: 20px">MSB' . $book->isbn_no . '</td>
                    <td class="center" style="padding-top: 20px">' . $book->publisher . '</td>
                    <td class="center" style="padding-top: 20px">' . $book->license_no . '</td>
                    <td class="center" style="padding-top: 20px">$' . $book->price . '</td>
                    <td class="center" style="padding-top: 20px" hidden id="bookId">' . $book->id . '</td>
                    <td class="center" style="padding-top: 20px">
                    <div class="hidden-sm hidden-xs btn-group">
                             <a class="btn btn-xs btn-info" href="restore/' . $book->id . '">
                                <i class="ace-icon fa fa-recycle bigger-120"></i>
                            </a>
                   </td>
                   </tr>';
            }
        }
        return $output;
    }

    public function getTopTenOrder()
    {
        return $this->bookRepo->getTopTenOrder();
    }

    public function getHot()
    {
        return $this->bookRepo->getHot();
    }

    public function getRecommend()
    {
        return $this->bookRepo->getRecommend();
    }
}
