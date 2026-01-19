<?php

namespace AutoSEO\Schema;

use AutoSEO\Page\PageContext;
use AutoSEO\Page\PageType;
use AutoSEO\Schema\Types\{
    WebSiteSchema,
    ArticleSchema,
    ProductSchema
};

class SchemaFactory
{
    public static function make(PageContext $page): ?array
    {
        return match ($page->type) {
            PageType::HOME =>
                WebSiteSchema::make(),

            PageType::ARTICLE =>
                isset($page->data['model'])
                    ? ArticleSchema::fromModel($page->data['model'])
                    : null,

            PageType::PRODUCT =>
                isset($page->data['model'])
                    ? ProductSchema::fromModel($page->data['model'])
                    : null,

            default => null,
        };
    }

    public static function fromModel(object $model): array
    {
        if (
            property_exists($model, 'price') ||
            method_exists($model, 'getPriceAttribute')
        ) {
            return ProductSchema::fromModel($model);
        }

        return ArticleSchema::fromModel($model);
    }
}
