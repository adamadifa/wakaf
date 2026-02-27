{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ now()->tz('GMT')->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>{{ route('wakaf.index') }}</loc>
        <lastmod>{{ now()->tz('GMT')->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('about') }}</loc>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>{{ route('vision-mission') }}</loc>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>{{ route('contact') }}</loc>
        <priority>0.5</priority>
    </url>

    @foreach ($campaigns as $campaign)
        <url>
            <loc>{{ route('campaign.show', $campaign->slug) }}</loc>
            <lastmod>{{ $campaign->updated_at->tz('GMT')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

    @foreach ($news as $item)
        <url>
            <loc>{{ route('news.show', $item->slug) }}</loc>
            <lastmod>{{ $item->updated_at->tz('GMT')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach

    @foreach ($albums as $album)
        <url>
            <loc>{{ route('gallery.show', $album->id) }}</loc>
            <lastmod>{{ $album->updated_at->tz('GMT')->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach
</urlset>
