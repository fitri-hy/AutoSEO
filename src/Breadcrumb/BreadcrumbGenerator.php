<?php

namespace AutoSEO\Breadcrumb;

class BreadcrumbGenerator
{
    public static function generate(): array
    {
        $segments = request()->segments();
        $url = url('/');
        $items = [];

        foreach ($segments as $segment) {
            $url .= '/' . $segment;
            $items[] = [
                'name' => ucfirst($segment),
                'url' => $url,
            ];
        }

        return $items;
    }
}
