<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'category_id',
        'price',
        'tax_rate',
        'stock',
        'code',
        'content',
        'unit_id',
        'lead_time',
        'status',
        'ranking',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function unit(): HasOne
    {
        return $this->hasOne(ProductUnit::class, 'id', 'unit_id');
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(ProductGallery::class, 'product_id')->orderBy('ranking');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function isActive(): bool
    {
        return $this->status == "ACTIVE";
    }
}
