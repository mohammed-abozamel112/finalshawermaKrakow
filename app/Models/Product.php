<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'description',
        'category',
        'quantity',
        'availability',
        'top_product',
        'weight',
        'price_before_discount',
        'price_after_discount',
        'image',
        'shawermakrakows_id',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function shawermaKrakow()
    {
        return $this->belongsTo(Shawermakrakow::class, 'shawermakrakows_id');
    }
    public function order_item()
    {
        return $this->hasOne(OrderItems::class);
    }
}
