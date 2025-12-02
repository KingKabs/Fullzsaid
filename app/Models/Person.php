<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model {

    use HasFactory;
    use SoftDeletes;

    protected $table = 'persons';
    protected $fillable = [
        'firstName', 'lastName', 'country', 'email', 'emailPass',
        'faUname', 'faPass', 'backupCode', 'securityQa', 'state',
        'gender', 'zip', 'dob', 'address', 'description', 'ssn',
        'cs', 'city', 'purchaseDate'
    ];
    protected $dates = ['dob', 'purchaseDate'];

    public function cartItems() {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class);
    }
}
