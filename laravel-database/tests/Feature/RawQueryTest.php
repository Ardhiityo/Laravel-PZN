<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RawQueryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        DB::delete("DELETE FROM categories");
    }

    public function testInsert()
    {
        DB::insert(
            "INSERT INTO categories (id, name, description) values (?, ?, ? )",
            ["c001", "ACC", "Accesories"]
        );

        $result = DB::select("SELECT * FROM categories");

        self::assertEquals(1, count($result));
        self::assertEquals("c001", $result[0]->id);
        self::assertEquals("ACC", $result[0]->name);
        self::assertEquals("Accesories", $result[0]->description);
    }

    public function testInsertWithNamedBinding()
    {
        DB::insert(
            "INSERT INTO categories (id, name, description) values (:id, :name, :description )",
            ["id" => "c001", "name" => "ACC", "description" => "Accesories"]
        );

        $result = DB::select("SELECT * FROM categories");

        self::assertEquals(1, count($result));
        self::assertEquals("c001", $result[0]->id);
        self::assertEquals("ACC", $result[0]->name);
        self::assertEquals("Accesories", $result[0]->description);
    }
}
