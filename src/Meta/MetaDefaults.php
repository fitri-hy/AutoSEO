<?php

namespace AutoSEO\Meta;

class MetaDefaults
{
    public static function get(): array
    {
        return config('seo.default');
    }
}
