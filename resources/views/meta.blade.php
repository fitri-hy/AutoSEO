<title>{{ $meta['title'] }}</title>

<meta name="description" content="{{ $meta['description'] }}">
<meta name="robots" content="{{ $meta['robots'] }}">

@if($meta['canonical'])
<link rel="canonical" href="{{ $meta['canonical'] }}">
@endif

{{-- OPEN GRAPH --}}
<meta property="og:title" content="{{ $meta['og_title'] }}">
<meta property="og:description" content="{{ $meta['og_description'] }}">
<meta property="og:type" content="{{ $meta['og_type'] }}">
<meta property="og:url" content="{{ $meta['og_url'] }}">
<meta property="og:image" content="{{ $meta['og_image'] }}">
<meta property="og:site_name" content="{{ config('seo.site.name') }}">

{{-- TWITTER --}}
<meta name="twitter:card" content="{{ $meta['twitter_card'] }}">
<meta name="twitter:title" content="{{ $meta['twitter_title'] }}">
<meta name="twitter:description" content="{{ $meta['twitter_description'] }}">
<meta name="twitter:image" content="{{ $meta['twitter_image'] }}">
