<?php

namespace App\Http\Controllers;

use App\Http\Services\CategoryService;
use App\Http\Services\OrderService;
use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected $orderService;
    protected $categoryService;

    public function __construct(OrderService $orderService, CategoryService $categoryService)
    {
        $this->orderService = $orderService;
        $this->categoryService = $categoryService;
    }

    public function showCheckout()
    {
        $categories = $this->categoryService->getAll();
        return view('frontend.checkout',compact('categories'));
    }

    public function placeOrder(Request $request)
    {
        $book_ids = [];
        foreach(session()->get('cart') as $item){
            array_push($book_ids,$item['id']);
        }
        $user = session()->get('customer')[0]['id'];
        $address = $request->address;
        $this->orderService->addOrder($user,$book_ids,$address);
        toastSuccess('Your order is being process','Order success');
        return redirect()->route('home');
    }
}
