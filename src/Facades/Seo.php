<?php

namespace AutoSEO\Facades;

use Illuminate\Support\Facades\Facade;

class Seo extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'seo';
    }
}
