<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'checkout_token',
        'checkout_shipping',
        'checkout_total',
        'checkout_total_with_shipping',
        'checkout_email',
        'checkout_phone_number',
        'checkout_first_name',
        'checkout_last_name',
        'checkout_address',
        'checkout_city',
        'checkout_country',
        'checkout_post_code',
        'checkout_payment_method',
        'checkout_card_number',
        'checkout_expire_date_month',
        'checkout_expire_date_year',
        'checkout_security_code',
        'shawermakrakows_id'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function orderitems()
    {
        return $this->hasMany(OrderItems::class);
    }
    public function shawermakrakow()
    {
        return $this->belongsTo(Shawermakrakow::class, 'shawermakrakows_id');
    }
}
