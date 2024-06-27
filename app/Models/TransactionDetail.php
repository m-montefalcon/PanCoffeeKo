<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'id',
        'user_id',
        'quantity',
        'amount',
        'transaction_id',
        'product_id'
    ];
}
