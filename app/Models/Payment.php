<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model {

    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_id',
        'order_id',
        'pay_currency',
        'price_amount',
        'pay_amount',
        'pay_address',
        'status',
        'actually_paid',
        'network'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
