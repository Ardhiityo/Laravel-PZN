<?php

namespace App\Models;

use App\Casts\AsAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Person extends Model
{
    protected $table = "people";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;

    protected $casts = [
        "created_at" => "datetime:U",
        "updated_at" => "datetime",
        "address" => AsAddress::class
    ];

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->first_name . " " . $this->last_name;
            },
            set: function ($value) {
                $name = explode(" ", $value);
                return [
                    "first_name" => $name[0],
                    "last_name" => $name[1] ?? ""
                ];
            }
        );
    }

    protected function firstName(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes): string {
                return strtoupper($value);
            },
            set: function ($value) {
                return [
                    "first_name" => $value
                ];
            }
        );
    }
}
