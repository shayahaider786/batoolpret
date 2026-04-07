@extends('layouts.frontend')

@push('canonical')
    <link rel="canonical" href="{{ route('wishlist') }}">
@endpush

@section('content')

<div class="bg-white"> 
    <div class="container headerTop p-5">
    </div>
</div>
<!-- breadcrumb -->
<div class="container">
    <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
        <a href="{{ route('index') }}" class="stext-109 cl8 hov-cl1 trans-04">
            Home
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <span class="stext-109 cl4">
            My Wishlist
        </span>
    </div>
</div>

<!-- Wishlist -->
<section class="bg0 p-t-75 p-b-85">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 20px;">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 20px;">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-10 col-xl-10 m-lr-auto m-b-50">
                <div class="m-l-25 m-r--38 m-lr-0-xl">
                    <h4 class="mtext-109 cl2 p-b-30">
                        My Wishlist
                    </h4>

                    <div class="wrap-table-shopping-cart">
                        <table class="table-shopping-cart">
                            <tr class="table_head">
                                <th class="column-1">Product</th>
                                <th class="column-2"></th>
                                <th class="column-3">Price</th>
                                <th class="column-2" style="padding-right: 25px;">Action</th>
                            </tr>

                            @if(isset($wishlistItems) && $wishlistItems->count() > 0)
                                @foreach($wishlistItems as $wishlistItem)
                                    @php
                                        $product = $wishlistItem->product;
                                        $productImage = $product && $product->image 
                                            ? asset($product->image) 
                                            : asset('frontend/images/item-cart-04.jpg');
                                        $price = $product ? ($product->discount_price ?? $product->price) : 0;
                                    @endphp
                                    <tr class="table_row">
                                        <td class="column-1">
                                            <div class="how-itemcart1">
                                                <a href="{{ $product ? route('productDetail', $product->slug) : '#' }}">
                                                    <img src="{{ $productImage }}" alt="{{ $product ? $product->name : 'Product' }}" loading="lazy">
                                                </a>
                                            </div>
                                        </td>
                                        <td class="column-2">
                                            <a href="{{ $product ? route('productDetail', $product->slug) : '#' }}" class="stext-110 cl2 hov-cl1 trans-04" style="text-decoration: none;">
                                                {{ $product ? $product->name : 'Product Not Available' }}
                                            </a>
                                        </td>
                                        <td class="column-3">
                                            @if($product)
                                                @if($product->discount_price && $product->discount_price < $product->price)
                                                    <span class="mtext-110 cl2">Rs. {{ number_format($product->discount_price, 0) }}</span>
                                                    <br><span style="text-decoration: line-through; color: #999; font-size: 0.9em;">Rs. {{ number_format($product->price, 0) }}</span>
                                                @else
                                                    <span class="mtext-110 cl2">Rs. {{ number_format($product->price, 0) }}</span>
                                                @endif
                                            @else
                                                <span class="mtext-110 cl2">N/A</span>
                                            @endif
                                        </td>
                                        <td class="column-6" style="padding-right: 25px;">
                                            <div style="display: flex; gap: 10px; align-items: center;">
                                                @if($product)
                                                    <form action="{{ route('cart.add') }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                        <input type="hidden" name="quantity" value="1">
                                                        <input type="hidden" name="remove_from_wishlist" value="1">
                                                        <input type="hidden" name="wishlist_item_id" value="{{ $wishlistItem->id }}">
                                                        @if($product->size && is_array($product->size) && count($product->size) > 0)
                                                            <input type="hidden" name="size" value="{{ $product->size[0] }}">
                                                        @endif
                                                        <button type="submit" class="btn btn-sm" style="background: #717fe0; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer;" title="Add to Cart">
                                                            <i class="zmdi zmdi-shopping-cart"></i> Add to Cart
                                                        </button>
                                                    </form>
                                                @endif
                                                <a href="{{ route('wishlist.remove', $wishlistItem->id) }}" 
                                                    class="btn btn-sm btn-link text-danger" 
                                                    onclick="event.preventDefault(); if(confirm('Are you sure you want to remove this item from wishlist?')) { document.getElementById('remove-wishlist-{{ $wishlistItem->id }}').submit(); }"
                                                    style="border: none; background: none; font-size:25px" title="Remove from Wishlist">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </a>
                                                <form id="remove-wishlist-{{ $wishlistItem->id }}" action="{{ route('wishlist.remove', $wishlistItem->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="table_row">
                                    <td colspan="4" class="text-center p-t-50 p-b-50">
                                        <p class="stext-102 cl3">Your wishlist is empty</p>
                                        <a href="{{ route('shop') }}" class="stext-101 cl0 hov-cl1 trans-04">Continue Shopping</a>
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>

                    @if(isset($wishlistItems) && $wishlistItems->count() > 0)
                        <div class="cart-actions-buttons" style="margin-top: 30px;">
                            <div class="flex-c-m stext-101 cl0 size-119 bg3 bor13 hov-btn3 p-lr-15 trans-04 pointer">
                                <a href="{{ route('shop') }}" style="text-decoration: none; color: #fff;">Continue Shopping</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

