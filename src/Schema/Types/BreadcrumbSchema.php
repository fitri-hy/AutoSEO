<?php

namespace AutoSEO\Schema\Types;

class BreadcrumbSchema
{
    public static function make(array $items): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($items)->map(
                fn ($item, $index) => [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'name' => $item['name'],
                    'item' => $item['url'],
                ]
            )->values()->toArray(),
        ];
    }
}
