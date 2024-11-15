<?php

namespace App\Data;

class Bar
{
    public function __construct(public Foo $foo) {}

    public function bar()
    {
        return $this->foo->foo() . " and bar";
    }
}
