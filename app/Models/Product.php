<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'description',
        'category_id',
        'purchase_price',
        'sale_price',
        'stock_current',
        'stock_minimum',
        'unit',
        'storage_location',
        'image_path',
    ];
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function transactions(): BelongsToMany
    {
        return $this->belongsToMany(Transaction::class,'product_transaction')->withpivot('quantity');
    }
    public function restockOrders(): BelongsToMany
    {
        return $this->belongsToMany(RestockOrder::class,'product_restock_order')->withpivot("quantity");
    }
}
