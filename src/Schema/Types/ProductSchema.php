<?php

namespace AutoSEO\Schema\Types;

class ProductSchema
{
    public static function fromModel($model): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $model->name ?? $model->seoTitle(),
            'description' => $model->seoDescription(),
            'image' => $model->seoImage(),
            'sku' => $model->sku ?? null,
            'offers' => [
                '@type' => 'Offer',
                'url' => url()->current(),
                'priceCurrency' => $model->currency ?? 'IDR',
                'price' => $model->price ?? 0,
                'availability' => ($model->stock ?? 1) > 0
                    ? 'https://schema.org/InStock'
                    : 'https://schema.org/OutOfStock',
            ],
        ];
    }
}
