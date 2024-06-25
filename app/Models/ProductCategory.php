<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'name',
        'isActive'
    ];
    public function scopeGetActiveProducts($query)
    {
        return $query->select('id', 'name')
            ->where('isActive', true)
            ->get();
    }
}
