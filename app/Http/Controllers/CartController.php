<?php

namespace App\Http\Controllers;

use App\Http\Services\BookService;
use App\Http\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $bookService;
    protected $cartService;

    public function __construct
    (
        BookService $bookService,
        CartService $cartService
    )
    {
        $this->bookService = $bookService;
        $this->cartService = $cartService;
    }

    public function showCart()
    {
        return view('frontend.cart');
    }

    public function addToCart(Request $request)
    {
        $id = $request->id;
        $book = $this->bookService->getById($id);
        $newItem = [
            'id' => $book->id,
            'name' => $book->name,
            'avatar' => $book->avatar,
            'price' => $book->price,
            'totalPrice' => $book->price,
            'quantity' => 1
        ];
        $totalItem = $this->cartService->addItem($newItem);
        $this->cartService->calculatePrice();
        $this->cartService->updateSummary(2, '');
        return response()->json(['success' => 'Book: ' . $newItem['name'] . ' added to cart', 'totalItem' => $totalItem]);
    }

    public function removeItem(Request $request)
    {
        $inCartItems = session()->get('cart');
        session()->forget('cart');
        $remainItems = [];
        foreach ($inCartItems as $item) {
            $itemName = $item['name'];
            if ($item['id'] != $request->id) {
                array_push($remainItems, $item);
            }
        }
        foreach ($remainItems as $item) {
            session()->push('cart', $item);
        }

        if (session()->has('cart')) {
            $couponCode = $request->couponCode;
            $shipCost = $request->shipCost;
            $this->cartService->updateSummary($shipCost,$couponCode);

        } else {
            session()->forget('summary');
            return Response(['warning' => 'There is nothing in your cart']);
        }
    }

    public function updateCart(Request $request)
    {
        $shipCost = $request->shipCost;
        $couponCode = $request->couponCode;
        if ($request->id != null) {
            $id = $request->id;
            $qty = $request->qty;
            $totalPrice = $this->cartService->updateCart($id, $qty);
            $summary = $this->cartService->updateSummary($shipCost, $couponCode);
            return Response(['totalPrice' => $totalPrice, 'summary' => $summary['summary'], 'total' => $summary['total'], 'discount' => $summary['discount'], 'shipCost' => $shipCost, 'couponCode' => $couponCode]);

        } else {
            $summary = $this->cartService->updateSummary($shipCost, $couponCode);
            return Response(['summary' => $summary['summary'], 'total' => $summary['total'], 'discount' => $summary['discount'], 'shipCost' => $shipCost, 'couponCode' => $couponCode]);
        }
    }

}
