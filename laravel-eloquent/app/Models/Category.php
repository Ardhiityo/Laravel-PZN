<?php

namespace App\Models;

use App\Models\Scopes\IsActiveScope;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductsSeeder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    protected $table = "categories";
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        "id",
        "name",
        "description"
    ];

    protected static function booted(): void
    {
        parent::booted();

        self::addGlobalScope(new IsActiveScope);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Products::class, "category_id", "id");
    }

    public function cheapestProducts(): HasOne
    {
        return $this->hasOne(Products::class, "category_id", "id")->oldest("price");
    }

    public function mostExpensiveProducts(): HasOne
    {
        return $this->hasOne(Products::class, "category_id", "id")->latest("price");
    }

    public function reviews(): HasManyThrough
    {
        return $this->hasManyThrough(Review::class, Products::class, "category_id", "product_id", "id", "id");
    }
}
