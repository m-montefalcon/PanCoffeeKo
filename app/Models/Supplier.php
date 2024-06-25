<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Supplier extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'name',
        'contact_number',
        'supply_type',
        'isActive'
    ];


    public function scopeGetActiveSuppliers($query)
    {
        return $query->select('id', 'name', 'contact_number', 'supply_type')
            ->where('isActive', true)
            ->get();
    }
}
