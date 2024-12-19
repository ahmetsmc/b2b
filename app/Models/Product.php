<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'title',
        'category_id',
        'price',
        'tax_rate',
        'stock',
        'code',
        'content',
        'unit_id',
        'status',
        'ranking'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function unit(): HasOne
    {
        return $this->hasOne(ProductUnit::class, 'id', 'unit_id');
    }

    public function isActive(): bool
    {
        return $this->status == "ACTIVE";
    }
}
