<?php

namespace Tests\Feature;

use App\Models\Category;
use Tests\TestCase;
use App\Models\Voucher;
use Database\Seeders\CommentSeeder;
use Database\Seeders\VoucherSeeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VoucherTest extends TestCase
{
    public function testUUID()
    {
        $voucher = new Voucher();
        $voucher->name = "vc123";
        $voucher->save();

        self::assertNotNull($voucher->id);
        self::assertNotNull($voucher->voucher_code);

        Log::info($voucher);
    }

    public function testSoftDelete()
    {
        $this->testUUID();

        $voucher = Voucher::where("name", "vc123")->first();
        $voucher->delete();

        $result = Voucher::where("name", "vc123")->first();

        self::assertNull($result);

        Log::info($result);
    }

    public function testWithTrashed()
    {
        $this->testSoftDelete();

        $result = Voucher::withTrashed()->get();

        self::assertCount(1, $result);

        Log::info($result);
    }

    public function testLocalScope()
    {
        $this->testUUID();

        $result = Voucher::isActive()->get();

        self::assertNotNull($result);
        Log::info($result);

        $voucher = new Voucher();
        $voucher->id = "vc2";
        $voucher->name = "voucher2";
        $voucher->is_active = false;
        $voucher->save();

        $result = Voucher::isNonActive()->get();

        self::assertNotNull($result);
        Log::info($result);
    }

    public function testOneToManyPolymorphic()
    {
        $this->seed([VoucherSeeder::class, CommentSeeder::class]);

        $voucher = Voucher::find("v001");
        $comment = $voucher->comments;

        self::assertCount(1, $comment);

        Log::info($comment);
    }
}
