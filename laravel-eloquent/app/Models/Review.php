<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $table = "reviews";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = false;

    public function products(): BelongsTo
    {
        return $this->belongsTo(Products::class, "product_id", "id");
    }

    public function customers(): BelongsTo
    {
        return $this->belongsTo(Customers::class, "customer_id", "id");
    }
}
