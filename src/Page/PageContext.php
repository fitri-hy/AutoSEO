<?php

namespace AutoSEO\Page;

class PageContext
{
    public function __construct(
        public PageType $type,
        protected array $data = []
    ) {}

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->data[$key] ?? $default;
    }

    public function canonical(): string
    {
        return url()->current();
    }
}
