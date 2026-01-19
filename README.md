# AutoSEO

**AutoSEO** is a Laravel package for **modern SEO automation**:

* Meta SEO (title, description, robots, canonical)
* JSON-LD Schema (Article, Product, Breadcrumb, etc.)
* Open Graph & Twitter Card (OG Image & Twitter Image)
* Auto Breadcrumbs from routes
* Multilanguage support (`hreflang`)
* SEO Audit helper

---

## Features

* Automatic meta SEO per page
* Automatic Open Graph & Twitter Card
* Automatic JSON-LD Schema
* `Seoable` trait for Models
* Auto Breadcrumbs from Routes
* Multilanguage support
* SEO Audit

---

## Installation

### 1. Create a Laravel Project

```bash
composer create-project laravel/laravel autoseo-demo
cd autoseo-demo
```

---

### 2. Install the Package (Local Path)

Edit **composer.json (project root)**:

```json
{
  "repositories": [
    {
      "type": "path",
      "url": "AutoSEO"
    }
  ],
  "require": {
    "fhylabs/autoseo": "*"
  }
}
```

Then install and publish the config:

```bash
composer update
php artisan vendor:publish --tag=autoseo-config
```

---

## Configuration

`config/seo.php`

```php
return [
    'site' => [
        'name' => 'AutoSEO Demo',
        'url' => env('APP_URL'),
        'logo' => '/logo.png',
        'locales' => ['id', 'en'],
    ],

    'default' => [
        'title' => 'AutoSEO Demo',
        'description' => 'AutoSEO Laravel demo website',
        'robots' => 'index,follow',
        'canonical' => null,
        'og_type' => 'website',
        'og_image' => '/logo.png',
        'twitter_card' => 'summary_large_image',
    ],
];
```

The `default.og_image` will be used as the **global fallback** if no other image is set.

---

## SEO Model (Seoable)

Use the `Seoable` trait so SEO & Schema can be generated automatically from models.

```php
use AutoSEO\Traits\Seoable;

class Post extends Model
{
    use Seoable;

    protected $fillable = ['title', 'excerpt', 'content', 'image'];
}
```

The `image` from the model will automatically be used as the **OG Image**.

---

## Imports

```
use AutoSEO\Facades\Seo;
use AutoSEO\Page\PageContext;
use AutoSEO\Page\PageType;
use AutoSEO\Traits\Seoable;
```

---

## Usage by Page Type

AutoSEO supports **different page types** through `PageType`.

### Home Page

```php
Seo::forPage(
    new PageContext(PageType::HOME, [
        'title' => 'AutoSEO Homepage',
        'description' => 'Modern & automated Laravel SEO',
        'og_image' => '/images/og/home.png',  // optional
    ])
);
```

Default meta, `WebSite` Schema, Open Graph & Twitter Image.

---

### Article / Blog / Content

```php
Seo::forPage(
    new PageContext(PageType::ARTICLE, [
        'model' => $post,
        'og_image' => '/images/og/custom-article.png' // optional
    ])
);

Seo::fromModel($post);
```

Meta from model, `Article` Schema, auto Breadcrumbs, OG Image from model or override.

---

### Product / E-commerce

```php
Seo::forPage(
    new PageContext(PageType::PRODUCT, [
        'model' => $product,
        'og_image' => '/images/og/product.png' // optional
    ])
);

Seo::fromModel($product);
```

`Product` Schema, price & availability, OG Image auto or custom.

---

### Category / Archive

```php
Seo::forPage(
    new PageContext(PageType::CATEGORY, [
        'title' => 'Technology Category',
        'og_image' => '/images/og/category.png'  // optional
    ])
);
```

SEO safe for list pages, Breadcrumbs active, OG Image custom.

---

### Static Page (About, Contact, etc.)

```php
Seo::forPage(
    new PageContext(PageType::STATIC, [
        'title' => 'About Us',
        'description' => 'Information about our company',
        'og_image' => '/images/og/about.png'  // optional
    ])
);
```

Manual meta, lightweight Schema, OG Image custom.

---

### Search Page

```php
Seo::forPage(
    new PageContext(PageType::SEARCH, [
        'og_image' => '/images/og/search.png' // optional
    ])
);
```

`noindex, follow` automatically applied, safe from SEO penalty, OG Image custom.

---

### OG Image Priority (Fallback)

1. `og_image` from `PageContext`
2. Image from Model (`Seoable`)
3. `default.og_image` in `config/seo.php`
4. No image tag rendered (safe fallback)

Relative paths are automatically converted to **absolute URLs**.

---

## Blade Layout

```blade
<head>
    @include('autoseo::meta', ['meta' => Seo::meta()->get()])
    @include('autoseo::schema', ['schemas' => Seo::schema()->get()])
    @include('autoseo::hreflang', ['hreflangs' => Seo::hreflang()])
    @include('autoseo::audit')
</head>
```

---

## Example Output

```html
<title>Post Title</title>
<meta name="description" content="Post excerpt">

<meta property="og:title" content="Post Title">
<meta property="og:description" content="Post excerpt">
<meta property="og:type" content="article">
<meta property="og:image" content="https://example.com/images/og/custom-article.png">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:image" content="https://example.com/images/og/custom-article.png">

<script type="application/ld+json">
{
  "@type": "Article",
  "headline": "Post Title"
}
</script>

<link rel="alternate" hreflang="id" href="https://example.com/id/post/1">
<link rel="alternate" hreflang="en" href="https://example.com/en/post/1">
```

---

## API Reference

| API                | Example                                          | Description                     |
| ------------------ | ------------------------------------------------ | ------------------------------- |
| `Seo::forPage()`   | `Seo::forPage(new PageContext(PageType::HOME))`  | Set page type SEO + OG Image    |
| `Seo::fromModel()` | `Seo::fromModel($post)`                          | Generate SEO & OG from model    |
| `Seo::meta()`      | `Seo::meta()->title('Title')`                    | Set meta tags                   |
| `Seo::schema()`    | `Seo::schema()->get()`                           | Get JSON-LD schema              |
| `Seo::hreflang()`  | `Seo::hreflang()`                                | Generate multilanguage hreflang |
| `Seoable`          | `use Seoable;`                                   | SEO trait for model             |
| `PageType::*`      | `HOME`, `ARTICLE`, `PRODUCT`, `STATIC`, `SEARCH` | Supported page types            |
| `SeoAudit`         | `@include('autoseo::audit')`                     | SEO Audit (development only)    |