<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Services\OrderService;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function showOrders(){
        $orders = $this->orderService->getAll();
        return view('backend.order.list',compact('orders'));
    }
    public function showOrderDetail($id){
        $order = Order::findOrFail($id);
        $books = $order->books;
        $orderDetail = $order->orderDetal;
        return view('backend.order.detail',compact('books','order','orderDetail'));
    }
    public function cancelOrder($id){
        $order = $this->orderService->getById($id);
        $this->orderService->softDelete($order);
        toastError('Cancel Order',$order->name.' has been deleted');
        return redirect()->route('orders.index');
    }
    public function restoreOrder(Request $request){
        $id = $request->id;
        $this->orderService->restoreOrder($id);
        return redirect()->route('orders.trashed');
    }
    public function showTrashedOrders(){
        $orders = $this->orderService->getTrashed();
        return view('backend.order.trashed',compact('orders'));
    }
    public function showOrdersByBook($book){
        $orders = $this->orderService->getByBook($book);
        return view('backend.order.list',compact('orders'));
    }
}
