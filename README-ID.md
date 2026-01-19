# AutoSEO

**AutoSEO** adalah package Laravel untuk **otomatisasi SEO modern**:

* Meta SEO (title, description, robots, canonical)
* Schema JSON-LD (Article, Product, Breadcrumb, dll)
* Open Graph & Twitter Card (OG Image & Twitter Image)
* Auto Breadcrumb dari route
* Multibahasa (`hreflang`)
* SEO Audit helper

---

## Fitur

* Auto meta SEO per halaman
* Open Graph & Twitter Card otomatis
* Schema JSON-LD otomatis
* Trait `Seoable` untuk Model
* Auto Breadcrumb dari Route
* Multibahasa
* SEO Audit

---

## Instalasi

### 1. Buat Project Laravel

```bash
composer create-project laravel/laravel autoseo-demo
cd autoseo-demo
```

---

### 2. Install Package (Local Path)

Edit **composer.json (root project)**:

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

Install & publish config:

```bash
composer update
php artisan vendor:publish --tag=autoseo-config
```

---

## Konfigurasi

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
        'description' => 'Website demo AutoSEO Laravel',
        'robots' => 'index,follow',
        'canonical' => null,
        'og_type' => 'website',
        'og_image' => '/logo.png',
        'twitter_card' => 'summary_large_image',
    ],
];
```

`default.og_image` akan digunakan sebagai **fallback global** jika tidak ada image lain yang diset.

---

## Model SEO (Seoable)

Gunakan trait `Seoable` agar SEO & Schema bisa dibuat otomatis dari model.

```php
use AutoSEO\Traits\Seoable;

class Post extends Model
{
    use Seoable;

    protected $fillable = ['title', 'excerpt', 'content', 'image'];
}
```

`image` dari model otomatis dipakai sebagai **OG Image**.

---

## Impor

```
use AutoSEO\Facades\Seo;
use AutoSEO\Page\PageContext;
use AutoSEO\Page\PageType;
use AutoSEO\Traits\Seoable;
```

---

## Penggunaan Berdasarkan Jenis Halaman

AutoSEO mendukung **berbagai tipe halaman** melalui `PageType`.

### Home Page

```php
Seo::forPage(
    new PageContext(PageType::HOME, [
        'title' => 'Homepage AutoSEO',
        'description' => 'AutoSEO Laravel modern & otomatis',
        'og_image' => '/images/og/home.png',  // opsional
    ])
);
```

Meta default, Schema `WebSite`, Open Graph & Twitter Image.

---

### Article / Blog / Content

```php
Seo::forPage(
    new PageContext(PageType::ARTICLE, [
        'model' => $post,
        'og_image' => '/images/og/custom-article.png' // opsional
    ])
);

Seo::fromModel($post);
```

Meta dari model, Schema `Article`, Breadcrumb otomatis, OG Image dari model atau override.

---

### Product / Ecommerce

```php
Seo::forPage(
    new PageContext(PageType::PRODUCT, [
        'model' => $product,
        'og_image' => '/images/og/product.png' // opsional
    ])
);

Seo::fromModel($product);
```

Schema `Product`, Price & availability, OG Image otomatis atau custom.

---

### Category / Archive

```php
Seo::forPage(
    new PageContext(PageType::CATEGORY, [
        'title' => 'Kategori Teknologi',
        'og_image' => '/images/og/category.png'  // opsional
    ])
);
```

SEO aman untuk halaman list, Breadcrumb aktif, OG Image custom.

---

### Static Page (About, Contact, dll)

```php
Seo::forPage(
    new PageContext(PageType::STATIC, [
        'title' => 'Tentang Kami',
        'description' => 'Informasi tentang perusahaan kami',
        'og_image' => '/images/og/about.png'  // opsional
    ])
);
```

Meta manual, Tanpa schema berat, OG Image custom.

---

### Search Page

```php
Seo::forPage(
    new PageContext(PageType::SEARCH, [
        'og_image' => '/images/og/search.png' // opsional
    ])
);
```

`noindex, follow` otomatis, aman dari SEO penalty, OG Image custom.

---

### Prioritas OG Image (Fallback)

1. `og_image` dari `PageContext`
2. Image dari Model (`Seoable`)
3. `default.og_image` di `config/seo.php`
4. Tidak render tag image (fallback aman)

Path relatif akan otomatis dikonversi menjadi **absolute URL**.

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

## Output Contoh

```html
<title>Judul Post</title>
<meta name="description" content="Excerpt post">

<meta property="og:title" content="Judul Post">
<meta property="og:description" content="Excerpt post">
<meta property="og:type" content="article">
<meta property="og:image" content="https://example.com/images/og/custom-article.png">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:image" content="https://example.com/images/og/custom-article.png">

<script type="application/ld+json">
{
  "@type": "Article",
  "headline": "Judul Post"
}
</script>

<link rel="alternate" hreflang="id" href="https://example.com/id/post/1">
<link rel="alternate" hreflang="en" href="https://example.com/en/post/1">
```

---

## API Reference

| API                | Contoh                                           | Keterangan                      |
| ------------------ | ------------------------------------------------ | ------------------------------- |
| `Seo::forPage()`   | `Seo::forPage(new PageContext(PageType::HOME))`  | Set tipe halaman SEO + OG Image |
| `Seo::fromModel()` | `Seo::fromModel($post)`                          | Generate SEO & OG dari model    |
| `Seo::meta()`      | `Seo::meta()->title('Judul')`                    | Atur meta tag                   |
| `Seo::schema()`    | `Seo::schema()->get()`                           | Ambil schema JSON-LD            |
| `Seo::hreflang()`  | `Seo::hreflang()`                                | Generate hreflang multi-bahasa  |
| `Seoable`          | `use Seoable;`                                   | Trait SEO untuk model           |
| `PageType::*`      | `HOME`, `ARTICLE`, `PRODUCT`, `STATIC`, `SEARCH` | Tipe halaman yang didukung      |
| `SeoAudit`         | `@include('autoseo::audit')`                     | Audit SEO (development only)    |