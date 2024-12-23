<?php

namespace Tests\Feature;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function testResource()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::first();

        $this->get("/api/categories/$category->id")
            ->assertStatus(200)
            ->assertJson([
                "value" => [
                    "id" => "$category->id",
                    "name" => "$category->name"
                ]
            ]);
    }

    public function testCollectionResource()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::query()->get();

        $this->get("/api/categories")
            ->assertStatus(200)
            ->assertJson([
                "data" => [
                    [
                        "id" => $category[0]->id,
                        "name" => $category[0]->name
                    ],
                    [
                        "id" => $category[1]->id,
                        "name" => $category[1]->name
                    ],
                ]
            ]);
    }

    public function testCustomCollectionResource()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::query()->get();

        $this->get("/api/categories-custom")
            ->assertStatus(200)
            ->assertJson([
                "total" => count($category),
                "data" => [
                    [
                        "id" => $category[0]->id,
                        "name" => $category[0]->name,
                    ],
                    [
                        "id" => $category[1]->id,
                        "name" => $category[1]->name
                    ],
                ]
            ]);
    }
}
