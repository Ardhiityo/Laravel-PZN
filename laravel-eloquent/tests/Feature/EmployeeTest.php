<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Employee;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeTest extends TestCase
{
    public function testFactory()
    {
        Employee::factory()->programmer()->create([
            "id" => "1",
            "name" => "Budi"
        ]);

        $result = Employee::find("1");
        self::assertEquals("1", $result->id);
        Log::info($result);

        $seniorProgrammer = Employee::factory()->seniorProgrammer()->make();
        $seniorProgrammer->id = "2";
        $seniorProgrammer->name = "Eko";
        $seniorProgrammer->save();

        $result = Employee::find("2");
        self::assertEquals("2", $result->id);
        Log::info($result);
    }
}
