@foreach($hreflangs as $lang)
<link rel="alternate" hreflang="{{ $lang['locale'] }}" href="{{ $lang['url'] }}">
@endforeach
