@if(app()->isLocal())
@php
    $meta = Seo::meta()->get();
    $audit = Seo::audit()->check($meta);
@endphp

<div style="background:#111;color:#0f0;padding:10px">
    SEO SCORE: {{ $audit['score'] }}<br>

    @foreach($audit['issues'] as $issue)
        - {{ $issue }}<br>
    @endforeach
</div>
@endif
