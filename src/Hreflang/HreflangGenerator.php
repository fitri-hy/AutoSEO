<?php

namespace AutoSEO\Hreflang;

class HreflangGenerator
{
    public static function generate(): array
    {
        $locales = config('seo.site.locales', []);
        $path = request()->path();

        return collect($locales)->map(fn ($locale) => [
            'locale' => $locale,
            'url' => url($locale . '/' . $path),
        ])->toArray();
    }
}
