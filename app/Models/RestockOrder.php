<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RestockOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        "po_number",
        "order_date",
        "expected_delivery_date",
        "status",
        "notes",
        "supplier_id",
        "created_by_user_id",
    ];
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, "product_restock_order")->withPivot("quantity");
    }
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(User::class, "supplier_id");
    }
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, "created_by_user_id");
    }
}
