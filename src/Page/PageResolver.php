<?php

namespace AutoSEO\Page;

use Illuminate\Http\Request;

class PageResolver
{
    public static function resolve(Request $request): PageType
    {
        return match (true) {
            $request->routeIs('home') => PageType::HOME,
            $request->routeIs('post.*') => PageType::ARTICLE,
            $request->routeIs('product.*') => PageType::PRODUCT,
            $request->routeIs('search') => PageType::SEARCH,
            default => PageType::STATIC,
        };
    }
}
