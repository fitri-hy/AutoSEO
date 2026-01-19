<?php

namespace AutoSEO;

use AutoSEO\Breadcrumb\BreadcrumbGenerator;
use AutoSEO\Hreflang\HreflangGenerator;
use AutoSEO\Page\PageContext;
use AutoSEO\Schema\SchemaFactory;
use AutoSEO\Schema\Types\BreadcrumbSchema;

class SeoManager
{
    public function __construct(
        protected Meta\MetaBuilder $meta,
        protected Schema\SchemaBuilder $schema,
        protected Audit\SeoAudit $audit
    ) {}

    public function forPage(PageContext $page): self
    {
        $this->meta->setPageType($page->type);

        $this->meta->setDefaults([
            'title' => $page->get('title'),
            'description' => $page->get('description'),
            'canonical' => $page->canonical(),
        ]);

        if ($schema = SchemaFactory::make($page)) {
            $this->schema->add($schema);
        }

        if ($breadcrumbs = BreadcrumbGenerator::generate()) {
            $this->schema->add(
                BreadcrumbSchema::make($breadcrumbs)
            );
        }

        return $this;
    }

    public function fromModel($model): self
    {
        if (method_exists($model, 'seoTitle')) {
            $this->meta->fromModel($model);

            if (method_exists($model, 'seoSchema')) {
                $this->schema->add($model->seoSchema());
            }
        }

        return $this;
    }

    public function meta() { return $this->meta; }
    public function schema() { return $this->schema; }
    public function audit() { return $this->audit; }
    public function hreflang() { return HreflangGenerator::generate(); }
}
