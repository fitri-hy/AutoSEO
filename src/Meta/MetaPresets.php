<?php

namespace AutoSEO\Meta;

use AutoSEO\Page\PageType;

class MetaPresets
{
    public static function get(PageType $type): array
    {
		return match ($type) {
			PageType::HOME => ['og:type' => 'website'],
			PageType::ARTICLE => ['og:type' => 'article'],
			PageType::PRODUCT => ['og:type' => 'product'],
			default => ['og:type' => 'website'],
		};
    }
}
