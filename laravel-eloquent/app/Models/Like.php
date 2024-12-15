<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Like extends Pivot
{
    protected $table = "customers_likes_products";
    protected $foreignKey = "customer_id";
    protected $relatedKey = "product_id";

    public function usesTimestamps(): bool
    {
        return false;
    }

    public function customers(): BelongsTo
    {
        return $this->belongsTo(Customers::class, "customer_id", "id");
    }

    public function products(): BelongsTo
    {
        return $this->belongsTo(Products::class, "product_id", "id");
    }
}
