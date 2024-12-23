<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDebugResource extends JsonResource
{
    // public $additional = [
    //     "author" => "Eko Kurniawan Khannedy"
    // ];

    public static $wrap = "data";

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "data" => [
                "id" => $this->id,
                "name" => $this->name,
                "category_id" => new CategorySimpleResource($this->category),
                "price" => $this->price
            ],
            "author" => "Eko Kurniawan Khannedy",
            "server_time" => now()->toDayDateTimeString()
        ];
    }
}
