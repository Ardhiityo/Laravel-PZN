<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        DB::delete("DELETE FROM categories");
    }

    public function testTransactionSuccessTest(): void
    {
        DB::transaction(function () {
            DB::insert("INSERT INTO categories (id, name, description) values (?, ?, ?)", ["c001", "acc", "accessories"]);
        });

        $result = DB::select("SELECT * FROM categories");

        self::assertEquals(1, count($result));
    }

    public function testTransactionFailedTest(): void
    {
        try {
            DB::transaction(function () {
                DB::insert("INSERT INTO categories (id, name, description) values (?, ?, ?)", ["c001", "acc", "accessories"]);
                DB::insert("INSERT INTO categories (id, name, description) values (?, ?, ?)", ["c001", "acc", "accessories"]);
            });
        } catch (\Throwable $th) {
        }

        $result = DB::select("SELECT * FROM categories");

        self::assertEquals(0, count($result));
    }

    public function testManualSuccess()
    {
        try {
            DB::beginTransaction();

            DB::insert("INSERT INTO categories (id, name, description) values (?, ?, ?)", ["c001", "acc", "accessories"]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }

        $result = DB::select("SELECT * FROM categories");

        self::assertEquals(1, count($result));
    }

    public function testManualFailed()
    {
        try {
            DB::beginTransaction();

            DB::insert("INSERT INTO categories (id, name, description) values (?, ?, ?)", ["c001", "acc", "accessories"]);
            DB::insert("INSERT INTO categories (id, name, description) values (?, ?, ?)", ["c001", "acc", "accessories"]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }

        $result = DB::select("SELECT * FROM categories");

        self::assertEquals(0, count($result));
    }
}
