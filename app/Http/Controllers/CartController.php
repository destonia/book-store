<?php

namespace App\Http\Controllers;

use App\Http\Services\BookService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $bookService;

    public function __construct
    (
        BookService $bookService
    )
    {
        $this->bookService = $bookService;
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
        $inCartItem = false;
        if (session()->has('cart')) {
            $oldItems = session()->get('cart');
            session()->forget('cart');
            foreach ($oldItems as $oldItem) {
                if ($oldItem['id'] == $newItem['id']) {
                    $oldItem['quantity']++;
                    $oldItem['totalPrice'] = $newItem['price'] * $oldItem['quantity'];
                    $inCartItem = true;
                }
                session()->push('cart', $oldItem);
            }
            if (!$inCartItem) {
                session()->push('cart', $newItem);
            }
        } else {
            session()->push('cart', $newItem);
        }
        $totalItem = count(session()->get('cart'));
        $summary = 0;
        foreach (session()->get('cart') as $item) {
            $summary += $item['totalPrice'];
        }
        if (session()->has('summary')) {
            session()->forget('summary');
            session()->push('summary', $summary);
        } else {
            session()->push('summary', $summary);
        }
        $shipCost = 2;
        foreach (session()->get('cart') as $item) {
            $summary += $item['totalPrice'];
        }
        $total = $summary + $shipCost;
        $final = ['summary' => $summary, 'total' => $total, 'shipCost' => $shipCost];
        if (session()->has('summary')) {
            session()->forget('summary');
            session()->push('summary', $final);
        } else {
            session()->push('summary', $final);
        }
        return response()->json(['success' => 'Book: ' . $newItem['name'] . ' added to cart', 'totalItem' => $totalItem]);
    }

    public function removeItem(Request $request)
    {
        $inCartItems = session()->get('cart');
        session()->forget('cart');
        $remainItems = [];

        $output = [];
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
            $totalItem = count(session()->get('cart'));
            $summary = 0;
            $shipCost = $request->shipCost;
            foreach (session()->get('cart') as $item) {
                $summary += $item['totalPrice'];
            }
            $total = $summary + $shipCost;
            $final = ['summary' => $summary, 'total' => $total, 'shipCost' => $shipCost];
            if (session()->has('summary')) {
                session()->forget('summary');
                session()->push('summary', $final);
            } else {
                session()->push('summary', $final);
            }
            if (session()->has('status')) {
                session()->forget('status');
                session()->push('status', 'Book: ' . $itemName . ' removed from cart');
            } else {
                session()->push('status', 'Book: ' . $itemName . ' removed from cart');
            }

        } else {
            session()->forget('summary');
            return Response(['warning' => 'There is nothing in your cart']);
        }
    }

    public function updateCart(Request $request)
    {
        $id = $request->id;
        $inCartItems = session()->get('cart');
        session()->forget('cart');
        foreach ($inCartItems as $item) {
            if ($item['id'] == $id) {
                $item['quantity'] = $request->qty;
                $item['totalPrice'] = $item['price'] * $request->qty;
                $totalPrice = $item['totalPrice'];
                session()->push('cart', $item);
            } else {
                session()->push('cart', $item);
            }
        }
        $summary = 0;
        $shipCost = $request->shipCost;
        foreach (session()->get('cart') as $item) {
            $summary += $item['totalPrice'];
        }
        $total = $summary + $shipCost;
        $final = ['summary' => $summary, 'total' => $total, 'shipCost' => $shipCost];
        if (session()->has('summary')) {
            session()->forget('summary');
            session()->push('summary', $final);
        } else {
            session()->push('summary', $final);
        }
        return Response(['totalPrice' => $totalPrice, 'summary' => $summary, 'total' => $total]);
    }

    public function updateShipCost(Request $request)
    {
        $summary = 0;
        $shipCost = $request->shipCost;
        foreach (session()->get('cart') as $item) {
            $summary += $item['totalPrice'];
        }
        $total = $summary + $shipCost;
        $final = ['summary' => $summary, 'total' => $total, 'shipCost' => $shipCost];
        if (session()->has('summary')) {
            session()->forget('summary');
            session()->push('summary', $final);
        } else {
            session()->push('shipCost', $shipCost);
        }
        return Response(['summary' => $summary, 'total' => $total]);
    }
}
