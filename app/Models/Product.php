<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'product_category_id',
        'supplier_id',
        'isActive'
    ];

    public function scopeGetActiveProducts($query)
    {
        return $query->select(
            'products.id',
            'products.name',
            'products.price',
            'products.quantity',
        )->get();
    }
}
