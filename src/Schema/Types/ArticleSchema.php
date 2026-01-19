<?php

namespace AutoSEO\Schema\Types;

class ArticleSchema
{
    public static function fromModel($model): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $model->seoTitle(),
            'description' => $model->seoDescription(),
            'image' => $model->seoImage(),
            'author' => [
                '@type' => 'Person',
                'name' => $model->author->name ?? config('seo.site.name'),
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('seo.site.name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset(config('seo.site.logo', '/logo.png')),
                ],
            ],
            'datePublished' => optional($model->created_at)->toIso8601String(),
            'dateModified' => optional($model->updated_at)->toIso8601String(),
            'mainEntityOfPage' => url()->current(),
        ];
    }
}
