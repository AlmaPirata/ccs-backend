<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ParseRBK extends Facade
{
    protected static function getFacadeAccessor() {
        return \App\Services\ParseRBK::class;
    }
}
