<?php

namespace AutoSEO;

use Illuminate\Support\ServiceProvider;
use AutoSEO\Meta\MetaBuilder;
use AutoSEO\Schema\SchemaBuilder;
use AutoSEO\Audit\SeoAudit;

class SeoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/seo.php', 'seo');

        $this->app->singleton(MetaBuilder::class, fn () => new MetaBuilder());
        $this->app->singleton(SchemaBuilder::class, fn () => new SchemaBuilder());
        $this->app->singleton(SeoAudit::class, fn () => new SeoAudit());

        $this->app->singleton('seo', function ($app) {
            return new SeoManager(
                $app->make(MetaBuilder::class),
                $app->make(SchemaBuilder::class),
                $app->make(SeoAudit::class)
            );
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/seo.php' => config_path('seo.php'),
        ], 'autoseo-config');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'autoseo');
    }
}
