<?php

namespace AutoSEO\Audit;

class SeoAudit
{
    public function check(array $meta): array
    {
        $issues = [];

        if (strlen($meta['title'] ?? '') < 30) {
            $issues[] = 'Title terlalu pendek';
        }

        if (strlen($meta['description'] ?? '') < 70) {
            $issues[] = 'Description terlalu pendek';
        }

        return [
            'score' => max(0, 100 - count($issues) * 20),
            'issues' => $issues,
        ];
    }
}
