<?php

namespace App;

use Illuminate\Support\Facades\Log;

class MathHelper
{
    static function add(int $x, int $y)
    {
        return once(function () use ($x, $y) {
            $result = $x + $y;
            Log::info($result);
            return $result;
        });
    }
}
