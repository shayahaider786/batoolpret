<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">
    <channel>
        <title>Batool Pret - Product Feed</title>
        <link>https://batoolpret.pk</link>
        <description>Batool Pret Product Catalog for Meta Commerce Manager</description>
        @foreach($products as $product)
        <item>
            <g:id>{{ $product->id }}</g:id>
            <g:title>{{ htmlspecialchars($product->name, ENT_XML1, 'UTF-8') }}</g:title>
            <g:description>{{ htmlspecialchars($product->short_description ?? strip_tags($product->long_description ?? $product->name), ENT_XML1, 'UTF-8') }}</g:description>
            <g:link>{{ route('productDetail', $product->slug) }}</g:link>
            <g:image_link>{{ $product->image ? url($product->image) : url('products/default.jpg') }}</g:image_link>
            <g:condition>new</g:condition>
            <g:availability>{{ $product->stock > 0 ? 'in stock' : 'out of stock' }}</g:availability>
            <g:price>{{ number_format($product->price, 2, '.', '') }} PKR</g:price>
            @if($product->discount_price && $product->discount_price < $product->price)
            <g:sale_price>{{ number_format($product->discount_price, 2, '.', '') }} PKR</g:sale_price>
            @endif
            <g:brand>Zaylish</g:brand>
        </item>
        @endforeach
    </channel>
</rss>

