<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'code',
        'title',
        'price',
        'image',
        'content',
        'stock'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function hasImage(): bool
    {
        return !is_null($this->image) && strlen($this->image) > 0;
    }

    public function getImage(): string
    {
        if ($this->hasImage()) {
            return asset('storage/' . $this->image);
        }

        return asset('assets/no-image.jpg');
    }
}
