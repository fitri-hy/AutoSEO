<?php

namespace AutoSEO\Traits;

use AutoSEO\Schema\SchemaFactory;

trait Seoable
{
    public function seoTitle(): string
    {
        return $this->title ?? $this->name ?? '';
    }

    public function seoDescription(): string
    {
        return $this->excerpt
            ?? str(strip_tags($this->content ?? ''))->limit(160);
    }

    public function seoImage(): ?string
    {
        return $this->image ?? null;
    }

    public function seoSchema(): array
    {
        return SchemaFactory::fromModel($this);
    }
}
