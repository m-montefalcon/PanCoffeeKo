<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'id',
        'user_id',
        'total_amount',
        'received_amount',
        'change_amount',
    ];
}
