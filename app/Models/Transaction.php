<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        "transaction_number",
        "type",
        "transaction_date",
        "status",
        "notes",
        "supplier_id",
        "customer_name",
        "created_by_user_id",
        "approved_by_user_id",
    ];
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class,"product_transaction")->withPivot("quantity");
    }
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(User::class, "supplier_id");
    }
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class,"created_by_user_id");
    }
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class,"approved_by_user_id");
    }
}
