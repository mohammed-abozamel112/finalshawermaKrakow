<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $shawermakrakow = $this->shawermakrakow;
        return [
            'id' => $this->id,
            'checkout_token' => $this->checkout_token,
            'checkout_shipping' => $this->checkout_shipping,
            'checkout_total' => $this->checkout_total,
            'checkout_total_with_shipping' => $this->checkout_total_with_shipping,
            'checkout_email' => $this->checkout_email,
            'checkout_phone_number' => $this->checkout_phone_number,
            'checkout_status' => $this->checkout_status,
            'checkout_first_name' => $this->checkout_first_name,
            'checkout_last_name' => $this->checkout_last_name,
            'checkout_address' => $this->checkout_address,
            'checkout_city' => $this->checkout_city,
            'checkout_payment_method' => $this->checkout_payment_method,
            'shawermakrakows_id' => $this->shawermakrakows_id,
            'shawermakrakow' => $shawermakrakow
                ? [
                    'id' => $shawermakrakow->id,
                    'name' => $shawermakrakow->name,
                ]
                : null,
            'orderItems' => $this->orderItems->map(function ($orderItem) {
                return [
                    'order_id' => $orderItem->order_id,
                    'quantity' => $orderItem->quantity,
                    'subtotal' => $orderItem->subtotal,
                    'product_id' => $orderItem->product_id,
                    'product' => [
                        'id' => $orderItem->product->id,
                        'name' => $orderItem->product->name,
                        'price' => $orderItem->product->price_before_discount,
                        'image' => $orderItem->product->image,
                        'weight' => $orderItem->product->weight,
                    ],
                ];
            }),
        ];
    }
}
