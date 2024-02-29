<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cartList()
    {
        $cartItems = \Cart::getContent()->toArray();
        $cartItemsArray = [];
        $total = 0;

        foreach ($cartItems as $cartItem) {
            $subtotal = $cartItem['price'] * $cartItem['quantity'];
            $product = Product::findOrFail($cartItem['id']);
            $cartItemArray = [
                'id' => $cartItem['id'],
                'name' => $cartItem['name'],
                'price' => $cartItem['price'],
                'quantity' => $cartItem['quantity'],
                'stockQuantity' => $product->quantity,
                'weight' => $product->weight,
                'image' => $product->image,
                'subtotal' => $subtotal,
            ];
            $cartItemsArray[] = $cartItemArray;
            $total += $subtotal;
        }

        $itemCount = array_sum(array_column($cartItemsArray, 'quantity'));

        return response()->json([
            'cartItems' => $cartItemsArray,
            'total' => $total,
            'itemCount' => $itemCount, // Add the itemCount to the response
        ]);
    }

    public function addToCart(Request $request)
    {
        // dd($request);
        $request->validate([
            'quantity' => ['required', 'integer'],
            'id' => ['required', 'integer']
        ]);

        $product = Product::findOrFail($request->input('id'));

        try {
            if ($product->quantity < $request->input('quantity')) {
                return response()->json([
                    "status" => "fail",
                    "message" => "We don't have enough items in stock for this product."
                ], 406);
            }

            \Cart::add([
                'id' => $request->input('id'),
                'name' => $product->name,
                'description' => $product->description,
                'availability' => $product->availability,
                'top_product' => $product->top_product,
                'weight' => $product->weight,
                'price' => $product->price_before_discount,
                'quantity' => $request->input('quantity'),
                'attributes' => array(
                    'image' => $product->image,
                )
            ]);

            $cartItems = \Cart::getContent()->toArray();
            $cartItemsArray = [];
            foreach ($cartItems as $cartItem) {
                $cartItemsArray[] = $cartItem;
            }

            return response()->json([
                'message' => 'Product is Added to Cart Successfully !',
                'cartItems' => $cartItemsArray
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateCart(Request $request)
    {
        \Cart::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity
                ],
            ]
        );

        $cartItems = \Cart::getContent()->toArray();
        $cartItemsArray = [];
        foreach ($cartItems as $cartItem) {
            $cartItemsArray[] = $cartItem;
        }

        return response()->json([
            'message' => 'Item Cart is Updated Successfully !',
            'cartItems' => $cartItemsArray
        ]);
    }

    public function removeCart(Request $request)
    {
        \Cart::remove($request->id);

        $cartItems = \Cart::getContent()->toArray();
        $cartItemsArray = [];
        foreach ($cartItems as $cartItem) {
            $cartItemsArray[] = $cartItem;
        }

        return response()->json([
            'message' => 'Item Cart Remove Successfully !',
            'cartItems' => $cartItemsArray
        ]);
    }

    public function clearAllCart()
    {
        \Cart::clear();

        $cartItems = \Cart::getContent()->toArray();
        $cartItemsArray = [];
        foreach ($cartItems as $cartItem) {
            $cartItemsArray[] = $cartItem;
        }

        return response()->json([
            'message' => 'All Item Cart Clear Successfully !',
            'cartItems' => $cartItemsArray
        ]);
    }
}
