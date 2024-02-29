<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            'description' => $this->description,
            'category' => $this->category,
            'quantity' => $this->quantity,
            'availability' => $this->availability,
            'top_product' => $this->top_product,
            'weight' => $this->weight,
            'price_before_discount' => $this->price_before_discount,
            'price_after_discount' => $this->price_after_discount,
            'image' => asset($this->image),
            'shawermakrakows_id' => $this->shawermakrakows_id,
        ];
    }
}
