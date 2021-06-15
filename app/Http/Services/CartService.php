<?php


namespace App\Http\Services;


class CartService
{
    public function addItem($newItem)
    {
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
        return count(session()->get('cart'));
    }

    public function calculatePrice()
    {
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
    }

    public function updateCart($id, $qty)
    {
        $inCartItems = session()->get('cart');
        session()->forget('cart');
        foreach ($inCartItems as $item) {
            if ($item['id'] == $id) {
                $item['quantity'] = $qty;
                $item['totalPrice'] = $item['price'] * $qty;
                $totalPrice = round($item['totalPrice'],2);
                session()->push('cart', $item);
            } else {
                session()->push('cart', $item);
            }
        }
        return $totalPrice;
    }

    public function updateSummary($shipCost, $couponCode)
    {
        $couponList = [['name' => 'freeShip', 'value' => 1], ['name' => 'vip', 'value' => 2]];
        $discount = 0;
        foreach ($couponList as $coupon) {
            if ($couponCode == $coupon['name']) {
                $discount += $coupon['value'];
            }
        }
        $summary = 0;
        foreach (session()->get('cart') as $item) {
            $summary += $item['totalPrice'];
        }
        $summary = round($summary,2,2);
        $total = round(($summary + $shipCost - $discount),2);
        $final = ['summary' => $summary, 'total' => $total, 'shipCost' => $shipCost, 'couponCode' => $couponCode, 'discount' => $discount];
        if (session()->has('summary')) {
            session()->forget('summary');
            session()->push('summary', $final);
        } else {
            session()->push('summary', $final);
        }
        return $final;
    }
}
