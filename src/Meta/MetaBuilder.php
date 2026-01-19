<?php

namespace AutoSEO\Meta;

use AutoSEO\Page\PageType;

class MetaBuilder
{
    protected array $custom = [];
    protected array $defaults = [];
    protected PageType $pageType;

    public function __construct()
    {
        $this->pageType = PageType::STATIC;
    }

    public function setPageType(PageType $type): self
    {
        $this->pageType = $type ?? PageType::STATIC;
        return $this;
    }

    public function setDefaults(array $data): self
    {
        $this->defaults = array_filter($data);
        return $this;
    }

    public function fromModel($model): self
    {
        $this->custom['title'] = $model->seoTitle();
        $this->custom['description'] = $model->seoDescription();
        $this->custom['image'] = $model->seoImage();

        return $this;
    }

    public function title(string $title): self
    {
        $this->custom['title'] = $title;
        return $this;
    }

    public function description(string $desc): self
    {
        $this->custom['description'] = $desc;
        return $this;
    }

    public function image(string $url): self
    {
        $this->custom['image'] = $url;
        return $this;
    }

    public function canonical(string $url): self
    {
        $this->custom['canonical'] = $url;
        return $this;
    }

public function get(): array
{
    $meta = array_merge(
        MetaDefaults::get(),
        MetaPresets::get($this->pageType),
        $this->defaults,
        $this->custom
    );

    $meta['title'] = $meta['title'] ?? '';
    $meta['description'] = $meta['description'] ?? '';
    $meta['canonical'] = $meta['canonical'] ?? url()->current();

    $meta['og_title'] = $meta['og_title'] ?? $meta['title'];
    $meta['og_description'] = $meta['og_description'] ?? $meta['description'];
    $meta['og_type'] = $meta['og_type'] ?? 'website';
    $meta['og_url'] = $meta['og_url'] ?? $meta['canonical'];

    $rawImage =
        $this->custom['image']
        ?? $meta['og_image']
        ?? config('seo.site.logo');

    if ($rawImage) {
        $meta['og_image'] = str_starts_with($rawImage, 'http')
            ? $rawImage
            : asset($rawImage);
    } else {
        $meta['og_image'] = asset(config('seo.site.logo'));
    }

    $meta['twitter_card'] = $meta['twitter_card'] ?? 'summary_large_image';
    $meta['twitter_title'] = $meta['twitter_title'] ?? $meta['og_title'];
    $meta['twitter_description'] = $meta['twitter_description'] ?? $meta['og_description'];
    $meta['twitter_image'] = $meta['twitter_image'] ?? $meta['og_image'];

    return $meta;
}

	
    protected function og(): array
    {
        $title = $this->custom['title']
            ?? $this->defaults['title']
            ?? config('seo.default.title');

        $description = $this->custom['description']
            ?? $this->defaults['description']
            ?? '';

        $image = $this->custom['image']
            ?? config('seo.default.image');

        $url = $this->custom['canonical']
            ?? url()->current();

        return [
            'og:title' => $title,
            'og:description' => $description,
            'og:type' => 'website',
            'og:url' => $url,
            'og:image' => $image,
            'og:site_name' => config('seo.site.name'),

            'twitter:card' => 'summary_large_image',
            'twitter:title' => $title,
            'twitter:description' => $description,
            'twitter:image' => $image,
        ];
    }
}
