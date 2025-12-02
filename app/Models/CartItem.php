<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model {

    use HasFactory;

    protected $fillable = ['cart_id', 'person_id', 'quantity', 'price'];

    public function cart() {
        return $this->belongsTo(Cart::class);
    }

    public function person() {
        return $this->belongsTo(Person::class);
    }

    public function subtotal() {
        return $this->quantity * $this->price;
    }
}
