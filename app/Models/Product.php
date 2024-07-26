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
        'isActive',
        'image_url'
    ];

    public function scopeGetActiveProducts($query)
    {
        return $query->select(
            'products.id',
            'products.name',
            'products.price',
            'products.quantity',
        )->orderBy('name', 'ASC')
        ->paginate(10);
    }


    public function scopeShowProduct($query,$id)
    {
        return $query->select(
            'products.id',
            'products.name',
            'products.description',
            'products.isActive',
            'products.price',
            'products.quantity',
            'products.image_url',
            'product_categories.id AS product_category_id',
            'suppliers.id AS supplier_id'
        )->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
        ->join('suppliers', 'products.supplier_id', '=', 'suppliers.id')
        ->where('products.id', $id)
        ->first();
    }
}
