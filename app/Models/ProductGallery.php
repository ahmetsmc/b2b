<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductGallery extends Model
{
    protected $fillable = [
        'product_id',
        'small_path',
        'large_path',
        'is_cover',
        'size',
        'mimetype',
        'name',
        'ranking'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function isCover(): bool
    {
        return $this->is_cover == 1;
    }
}
