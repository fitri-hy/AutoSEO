<?php

namespace AutoSEO\Schema\Types;

class WebSiteSchema
{
    public static function make(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => config('seo.site.name'),
            'url' => config('seo.site.url'),
            'inLanguage' => app()->getLocale(),
        ];
    }
}
