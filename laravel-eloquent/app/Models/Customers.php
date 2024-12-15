<?php

namespace App\Models;

use App\Models\Like;
use App\Models\Review;
use App\Models\Wallets;
use App\Models\Products;
use App\Models\VirtualAccount;
use Illuminate\Support\Facades\Date;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Customers extends Model
{
    protected $table = "customers";
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false;

    protected $with = ["wallets", "images"];

    public function wallets(): HasOne
    {
        return $this->hasOne(Wallets::class, "customer_id", "id");
    }

    public function va(): HasOneThrough
    {
        return $this->hasOneThrough(VirtualAccount::class, Wallets::class, "customer_id", "wallet_id", "id", "id");
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, "customer_id", "id");
    }

    public function likesProducts(): BelongsToMany
    {
        return $this->belongsToMany(Products::class, "customers_likes_products", "customer_id", "product_id")->withPivot("created_at")->using(Like::class);
    }

    public function likesProductsLastWeek(): BelongsToMany
    {
        return $this->belongsToMany(Products::class, "customers_likes_products", "customer_id", "product_id")->withPivot("created_at")->using(Like::class)->wherePivot("created_at", ">=", Date::now()->addDays(-7));
    }

    public function images(): MorphOne
    {
        return $this->morphOne(Image::class, "imageable");
    }
}
