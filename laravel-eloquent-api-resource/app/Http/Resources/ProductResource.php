<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public static $wrap = "values";

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "category" => new CategorySimpleResource($this->whenLoaded("category")),
            "price" => $this->price,
            "is_expensive" => $this->when($this->price > 150, true, false)
        ];
    }

    public function withResponse(Request $request, \Illuminate\Http\JsonResponse $response)
    {
        return $response->header("X-POWERED-BY", "PZN");
    }
}
