<?php


namespace App\Http\Services;


use App\Http\Repositories\OrderRepo;
use App\Models\Book;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected $orderRepo;
    protected $bookService;

    public function __construct(OrderRepo $orderRepo, BookService $bookService)
    {
        $this->orderRepo = $orderRepo;
        $this->bookService = $bookService;
    }

    public function getAll()
    {
        return $this->orderRepo->getAll();
    }
    public function getTrashed(){
        return $this->orderRepo->getTrashed();
    }
    public function getById($id)
    {
        return $this->orderRepo->getById($id);
    }

    public function addOrder($user, $book_ids, $address)
    {
        DB::beginTransaction();
        try {
            $order = new Order();
            $order->name = \Illuminate\Support\Str::random(15);
            $order->address = $address;
            $order->ship_cost = session()->get('summary')[0]['shipCost'];
            $order->total = session()->get('summary')[0]['total'];
            $order->status = 'pending';
            $order->user_id = $user;
            $total_item = 0;
            foreach (session()->get('cart') as $book) {
                $orderQty = $book['quantity'];
                $this->bookService->updateOrderCount($book['id'],$orderQty);
                $total_item += $book['quantity'];
            }
            $order->books_count = $total_item;
            $this->orderRepo->store($order);
            $syncData = [];
            foreach ($book_ids as $key => $book_id) {
                $syncData[$book_id] = ['quantity' => session()->get('cart')[$key]['quantity']];
            }
            $order->books()->sync($syncData);

            DB::commit();
            foreach ($book_ids as $book_id) {
                $book = Book::findOrFail($book_id);
                $quantity = $book->qty - 1;
                $this->bookService->updateQuantity($book_id, $quantity, $order);
            }
            session()->forget(['cart', 'summary']);
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception);
        }
    }

    public function softDelete($order)
    {
        $this->orderRepo->softDelete($order);
    }
    public function restoreOrder($id){
        $this->orderRepo->restoreTrashed($id);
    }
    public function delete($order)
    {
        DB::beginTransaction();
        try {
            $order->books()->detach();
            $this->orderRepo->delete($order);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    public function getByBook($book)
    {
        return $this->orderRepo->getByBook($book);
    }
}
