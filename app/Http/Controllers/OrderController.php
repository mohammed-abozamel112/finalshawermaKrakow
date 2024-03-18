<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use PHPMailer\PHPMailer\PHPMailer;
use Stripe\Token;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            // If not, return a message
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to access this page.'
            ], 401);
        }
        try {
            // If the user is authenticated, proceed with the function logic
            $orders = Order::orderByDesc('created_at')->paginate(10);

            // Return a paginated collection of orders
            return response()->json([
                'status' => 'success',
                'orders' => OrderResource::collection($orders),
                'pagination' => [
                    'current_page' => $orders->currentPage(),
                    'last_page' => $orders->lastPage(),
                    'next_page_url' => $orders->nextPageUrl(),
                    'prev_page_url' => $orders->previousPageUrl(),
                    'total' => $orders->total(),
                ],
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    // show single order
    public function showsingele($id)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            // If not, return a message
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to access this page.'
            ], 401);
        }
        try {
            $order = Order::findOrFail($id);
            return response()->json([
                "order" => new OrderResource($order),
                "status" => true,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "message" => "Order Not Found!"
            ], 404);
        }
    }
    // Tracking function
    function show(Request $request)
    {
        // Validate the request parameters
        $request->validate([
            'checkout_token' => ['required'],
            'checkout_email' => 'required|email'
        ]);
        $token = $request->checkout_token;
        $email = $request->checkout_email;

        if (!$token) {
            return response()->json(['' => 'Token is required'], 400);
        }
        if (!$email) {
            return response()->json(['' => 'Email is required'], 400);
        }
        // Get the order by token and email
        $order = Order::where('checkout_token', $token)->firstOrFail();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        // Return the order resource
        return response()->json([
            'success' => true,
            'order' => new OrderResource($order)
        ]);

    }
    // create new order function and payment
    public function store(Request $request)
    {
        $paymethod = $request->checkout_payment_method;
        try {
            // Get cart items
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
            if ($request->has('checkout_shipping')) {
                $shipping_val = $request->checkout_shipping;
            } else {
                $shipping_val = 0.2;
            }
            // Calculate shipping cost
            $shipping = $total * $shipping_val;

            // Create order
            $total_with_shipping = $total + $shipping;
            // check cart items
            if (!$cartItems) {
                return response()->json([
                    "status" => false,
                    "message" => "Sorry! Your Cart is Empty."
                ]);
            }
            // if payment method is catd
            if ($paymethod === 'credit_card') {
                $request->validate([
                    'checkout_phone_number' => 'numeric',
                    'checkout_email' => 'required|email',
                    'checkout_first_name' => 'required|string|min:3',
                    'checkout_last_name' => 'required|string|max:20',
                    'checkout_address' => 'required',
                    'checkout_city' => 'required|string|min:3',
                    'checkout_country' => 'required|string|min:3',
                    'checkout_payment_method' => 'required',
                    'checkout_card_number' => 'required|numeric',
                    'checkout_expire_date_month' => 'required|date_format:m',
                    'checkout_expire_date_year' => 'required|date_format:y',
                    'checkout_security_code' => 'required|digits:3',
                ]);
                //payment
                //stripe payment

                // $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                /*  $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                 $stripe->setApiKey(env('STRIPE_SECRET'));

                 // Create a token from the credit card details
                 $token = Token::create([
                     'card' => [
                         'number' => $request->checkout_card_number,
                         'exp_month' => $request->checkout_expire_date_month,
                         'exp_year' => $request->checkout_expire_date_year,
                         'cvc' => $request->checkout_security_code,
                     ],
                 ]);

                 // Create a payment method object using Stripe's API
                 $paymentMethod = $stripe->paymentMethods->create([
                     'type' => 'card',
                     'card' => [
                         'token' => $token->id,
                     ],
                 ]);

                 $paymentIntent = $stripe->paymentIntents->create([
                     'amount' => round($total_with_shipping * 100),
                     'currency' => 'usd',
                     'receipt_email' => $request->checkout_email,
                     'confirmation_method' => 'manual',
                     'confirm' => true,
                 ]); */

                // $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                $stripe = \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

                // Create a token from the credit card details
                $token = Token::create([
                    'card' => [
                        'number' => $request->checkout_card_number,
                        'exp_month' => $request->checkout_expire_date_month,
                        'exp_year' => $request->checkout_expire_date_year,
                        'cvc' => $request->checkout_security_code,
                    ],
                ]);

                // Create a payment method object using Stripe's API
                $stripe->paymentMethods->create([
                    'type' => 'card',
                    'card' => [
                        'token' => $token->id,
                    ],
                ]);

                $stripe->paymentIntents->create([
                    'amount' => round($total_with_shipping * 100),
                    'currency' => 'usd',
                    'source' => $token->id,
                    'receipt_email' => $request->checkout_email,
                    'confirmation_method' => 'manual',
                    'confirm' => true,
                ]);

                /*
                                // Create a payment intent
                                $stripe->paymentIntents->create([
                                    'amount' => round($total_with_shipping * 100), // Amount in cents
                                    'currency' => 'usd',
                                    'payment_method_types' => ['card'],
                                    'confirmation_method' => 'manual',
                                    'confirm' => true,
                                    'payment_method' => $token->id, // Use token ID directly as payment method
                                    'receipt_email' => $request->checkout_email,
                                ]); */
                //end of payment

                // Create order
                $order = Order::create([
                    'checkout_token' => Str::uuid(),
                    'checkout_shipping' => $shipping_val,
                    'checkout_total' => $total,
                    'checkout_total_with_shipping' => $total_with_shipping,
                    'checkout_email' => $request->checkout_email,
                    'checkout_phone_number' => $request->checkout_phone_number,
                    'checkout_first_name' => $request->checkout_first_name,
                    'checkout_last_name' => $request->checkout_last_name,
                    'checkout_address' => $request->checkout_address,
                    'checkout_city' => $request->checkout_city,
                    'checkout_country' => $request->checkout_country,
                    'checkout_payment_method' => $request->checkout_payment_method,
                    'checkout_card_number' => $request->checkout_card_number,
                    'checkout_expire_date' => $request->checkout_expire_date,
                    'checkout_security_code' => $request->checkout_security_code,
                ]);

                // Save order items
                $orderItems = array_map(function ($item) use ($order) {
                    $orderItem = OrderItems::create([
                        'order_id' => $order->id,
                        'token' => $order->checkout_token,
                        'product_id' => $item['id'],
                        'quantity' => $item['quantity'],
                        'subtotal' => $item['subtotal'],
                    ]);

                    // Decrease the stock quantity
                    $product = Product::findOrFail($item['id']);
                    $product->quantity -= $item['quantity'];
                    $product->save();

                    return $orderItem;
                }, $cartItemsArray);
                //send mail to  customer with order details and adminstrator with order details

                if ($order) {
                    $mail = new PHPMailer(true);
                    $name = $request->checkout_first_name . " " . $request->checkout_last_name;
                    $email = $request->checkout_email;

                    /* Email SMTP Settings */
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();
                    $mail->Host = env('MAIL_HOST');
                    $mail->SMTPAuth = true;
                    $mail->Username = env('MAIL_USERNAME');
                    $mail->Password = env('MAIL_PASSWORD');
                    $mail->SMTPSecure = env('MAIL_ENCRYPTION');
                    $mail->Port = env('MAIL_PORT');

                    //Recipients
                    $mail->setFrom('hassan@shawermakrakow.com', 'Shawerma krakow');
                    $mail->addAddress($email, $name);     //Add a recipient

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Thank you for your Order';
                    $mail->Body = "<h1 style='text-align:center;color:black;'>Shawerma Krakow</h1>" .
                        "<p style='font-size:1.25rem;'> Hi $name, we are getting your order ready </p>.
                    <p style='font-size:1rem;'> <b> Here is The Id Of Your Order :</b> $order->checkout_token</p>" .
                        "<p> If you want to track your order <a href='https://shawermakrakow.com/'>Click Here</a></p>" .
                        "<h2>Order Summary</h2>" .
                        "<table style='text-align:center;color:black;width:80%;'>" .
                        "<thead>" .
                        "<tr>" .
                        "<th>Item</th>" .
                        "<th>Quantity</th>" .
                        "<th>Image</th>" .
                        "<th>Price</th>" .
                        "</tr>" .
                        "</thead>" .
                        "<tbody>";

                    foreach ($orderItems as $orderItem) {
                        $product = Product::findOrFail($orderItem->product_id);
                        $imagePath = asset('storage/images/products/' . $product->image);
                        $mail->Body .= "<tr>" .
                            "<td>$product->name</td>" .
                            "<td>$orderItem->quantity</td>" .
                            "<td><img src=$imagePath width='100px'></td>" .
                            "<td>$orderItem->subtotal \$</td>" .
                            "</tr>";
                    }

                    $mail->Body .= "</tbody>" .
                        "</table>";

                    $mail->Body .= "<p><b>Total:</b> \$$order->checkout_total</p>" .
                        "<p><b>Total With Shipping:</b> \$$order->checkout_total_with_shipping</p>";

                    $mail->send();
                }
                /* end mail */

                return response()->json([
                    "success" => true,
                    "message" => "Order Created",
                ]);

            } elseif ($paymethod === 'cash') {
                $request->validate([
                    'checkout_phone_number' => 'numeric',
                    'checkout_email' => 'required|email',
                    'checkout_first_name' => 'required|string|min:3',
                    'checkout_last_name' => 'required|string|max:20',
                    'checkout_address' => 'required',
                    'checkout_city' => 'required|string|min:3',
                    'checkout_country' => 'required|string|min:3',
                    'checkout_payment_method' => 'required',
                ]);
                // Create order
                $order = Order::create([
                    'checkout_token' => Str::uuid(),
                    'checkout_shipping' => $shipping_val,
                    'checkout_total' => $total,
                    'checkout_total_with_shipping' => $total_with_shipping,
                    'checkout_email' => $request->checkout_email,
                    'checkout_phone_number' => $request->checkout_phone_number,
                    'checkout_first_name' => $request->checkout_first_name,
                    'checkout_last_name' => $request->checkout_last_name,
                    'checkout_address' => $request->checkout_address,
                    'checkout_city' => $request->checkout_city,
                    'checkout_country' => $request->checkout_country,
                    'checkout_payment_method' => $request->checkout_payment_method,
                ]);

                // Save order items
                $orderItems = array_map(function ($item) use ($order) {
                    $orderItem = OrderItems::create([
                        'order_id' => $order->id,
                        'token' => $order->checkout_token,
                        'product_id' => $item['id'],
                        'quantity' => $item['quantity'],
                        'subtotal' => $item['subtotal'],
                    ]);

                    // Decrease the stock quantity
                    $product = Product::findOrFail($item['id']);
                    $product->quantity -= $item['quantity'];
                    $product->save();

                    return $orderItem;
                }, $cartItemsArray);
                //send mail to  customer with order details and adminstrator with order details

                if ($order) {
                    $mail = new PHPMailer(true);
                    $name = $request->checkout_first_name . " " . $request->checkout_last_name;
                    $email = $request->checkout_email;

                    /* Email SMTP Settings */
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();
                    $mail->Host = env('MAIL_HOST');
                    $mail->SMTPAuth = true;
                    $mail->Username = env('MAIL_USERNAME');
                    $mail->Password = env('MAIL_PASSWORD');
                    $mail->SMTPSecure = env('MAIL_ENCRYPTION');
                    $mail->Port = env('MAIL_PORT');

                    //Recipients
                    $mail->setFrom('hassan@shawermakrakow.com', 'Shawerma krakow');
                    $mail->addAddress($email, $name);     //Add a recipient

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Thank you for your Order';
                    $mail->Body = "<h1 style='text-align:center;color:black;'>Shawerma Krakow</h1>" .
                        "<p style='font-size:1.25rem;'> Hi $name, we are getting your order ready </p>.
                    <p style='font-size:1rem;'> <b> Here is The Id Of Your Order :</b> $order->checkout_token</p>" .
                        "<p> If you want to track your order <a href='https://shawermakrakow.com/'>Click Here</a></p>" .
                        "<h2>Order Summary</h2>" .
                        "<table style='text-align:center;color:black;width:80%;'>" .
                        "<thead>" .
                        "<tr>" .
                        "<th>Item</th>" .
                        "<th>Quantity</th>" .
                        "<th>Image</th>" .
                        "<th>Price</th>" .
                        "</tr>" .
                        "</thead>" .
                        "<tbody>";

                    foreach ($orderItems as $orderItem) {
                        $product = Product::findOrFail($orderItem->product_id);
                        $imagePath = asset('storage/images/products/' . $product->image);
                        $mail->Body .= "<tr>" .
                            "<td>$product->name</td>" .
                            "<td>$orderItem->quantity</td>" .
                            "<td><img src=$imagePath width='100px'></td>" .
                            "<td>$orderItem->subtotal \$</td>" .
                            "</tr>";
                    }

                    $mail->Body .= "</tbody>" .
                        "</table>";

                    $mail->Body .= "<p><b>Total:</b> \$$order->checkout_total</p>" .
                        "<p><b>Total With Shipping:</b> \$$order->checkout_total_with_shipping</p>";

                    $mail->send();
                }
                /* end mail */
                return response()->json([
                    "success" => true,
                    "message" => "Order Created",
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            // If not, return a message
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to access this page.'
            ], 401);
        }
        // Find the order by its
        $order = Order::findOrFail($id);

        // Check if the order exists
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Update the status of the order
        $order->checkout_status = $request->checkout_status; // assuming the status is sent in the request
        $order->save();

        // Return a JSON response
        return response()->json(['message' => 'Order status updated successfully']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Get the order
        $order = Order::findOrFail($id);
        // Delete the order and all associated order items
        $order->orderItems()->delete();
        $order->delete();
        // Return a success message
        return response()->json('Order deleted', 200);
    }
}
