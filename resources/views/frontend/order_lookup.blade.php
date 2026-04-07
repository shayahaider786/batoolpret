@extends('layouts.frontend')

@push('canonical')
    <link rel="canonical" href="{{ route('order.lookup') }}">
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
            {{ __('messages.orderLookup.title') }}
        </span>
    </div>
</div>

<!-- Order Lookup Section -->
<section class="bg0 p-t-75 p-b-85">
    <div class="container">
        <!-- Error Messages -->
        @if(session('error'))
            <div class="container" style="margin-top: 20px; margin-bottom: 20px;">
                <div class="alert alert-danger" style="padding: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px;">
                    <strong>Error!</strong> {{ session('error') }}
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="container" style="margin-top: 20px; margin-bottom: 20px;">
                <div class="alert alert-danger" style="padding: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px;">
                    <strong>Please fix the following errors:</strong>
                    <ul style="margin-top: 10px; margin-bottom: 0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="row">
            <!-- Order Lookup Form -->
            <div class="col-lg-6 m-lr-auto m-b-50">
                <div class="bor10 p-lr-40 p-t-30 p-b-40 m-lr-0-xl p-lr-15-sm">
                    <h4 class="mtext-109 cl2 p-b-30">
                        {{ __('messages.orderLookup.findOrder') }}
                    </h4>

                    <p class="stext-107 cl6 p-b-20">
                        {{ __('messages.orderLookup.description') }}
                    </p>

                    <form method="POST" action="{{ route('order.lookup.submit') }}">
                        @csrf
                        <div class="form-group-checkout">
                            <label class="form-label-checkout">{{ __('messages.orderLookup.orderNumber') }} *</label>
                            <input type="text" 
                                   class="form-input-checkout @error('order_number') is-invalid @enderror" 
                                   id="order_number" 
                                   name="order_number" 
                                   value="{{ old('order_number') }}" 
                                   placeholder="{{ __('messages.orderLookup.orderNumberPlaceholder') }}" 
                                   required>
                            <small class="stext-107 cl6" style="display: block; margin-top: 5px;">
                                {{ __('messages.orderLookup.orderNumberExample') }}
                            </small>
                            @error('order_number')
                                <span class="invalid-feedback" role="alert" style="display: block; color: #f44336; margin-top: 5px;">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer" style="width: 100%; margin-top: 20px;">
                            {{ __('messages.orderLookup.checkOrder') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Order Details -->
        @if(isset($order) && $order)
            <div class="row">
                <div class="col-lg-10 m-lr-auto m-b-50">
                    <div class="bor10 p-lr-40 p-t-30 p-b-40 m-lr-0-xl p-lr-15-sm">
                        <div class="flex-w flex-sb-m p-b-20">
                            <div>
                                <h4 class="mtext-109 cl2 p-b-10">
                                    {{ __('messages.orderLookup.order') }} #{{ $order->order_number }}
                                </h4>
                                <p class="stext-107 cl6">
                                    {{ __('messages.orderLookup.placedBy') }} {{ $order->first_name }} {{ $order->last_name }}
                                </p>
                            </div>
                            <div>
                                @php
                                    $statusColor = '#666';
                                    $statusBg = '#f5f5f5';
                                    if($order->status == 'pending') {
                                        $statusColor = '#ff9800';
                                        $statusBg = '#fff3e0';
                                    } elseif($order->status == 'processing') {
                                        $statusColor = '#2196f3';
                                        $statusBg = '#e3f2fd';
                                    } elseif($order->status == 'completed') {
                                        $statusColor = '#4caf50';
                                        $statusBg = '#e8f5e9';
                                    } elseif($order->status == 'cancelled') {
                                        $statusColor = '#f44336';
                                        $statusBg = '#ffebee';
                                    }
                                @endphp
                                <span class="stext-101 p-lr-15 p-tb-5" style="display: inline-block; padding: 8px 15px; border-radius: 4px; text-transform: uppercase; font-weight: 600; color: {{ $statusColor }}; background-color: {{ $statusBg }};">
                                    @if($order->status == 'pending')
                                        {{ __('messages.orderLookup.status.pending') }}
                                    @elseif($order->status == 'processing')
                                        {{ __('messages.orderLookup.status.processing') }}
                                    @elseif($order->status == 'completed')
                                        {{ __('messages.orderLookup.status.completed') }}
                                    @elseif($order->status == 'cancelled')
                                        {{ __('messages.orderLookup.status.cancelled') }}
                                    @else
                                        {{ ucfirst($order->status) }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Customer Information -->
                        <div class="p-b-20">
                            <h5 class="mtext-108 cl2 p-b-10">Customer Information</h5>
                            <div class="flex-w flex-t p-b-10">
                                <div class="size-208">
                                    <span class="stext-110 cl2">
                                        {{ __('messages.orderLookup.email') }}:
                                    </span>
                                </div>
                                <div class="size-209">
                                    <span class="mtext-110 cl6">
                                        {{ $order->email }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex-w flex-t p-b-10">
                                <div class="size-208">
                                    <span class="stext-110 cl2">
                                        {{ __('messages.orderLookup.phone') }}:
                                    </span>
                                </div>
                                <div class="size-209">
                                    <span class="mtext-110 cl6">
                                        {{ $order->phone }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex-w flex-t">
                                <div class="size-208">
                                    <span class="stext-110 cl2">
                                        {{ __('messages.orderLookup.address') }}:
                                    </span>
                                </div>
                                <div class="size-209">
                                    <span class="mtext-110 cl6">
                                        {{ $order->address }}
                                        @if($order->apartment), {{ $order->apartment }} @endif,
                                        {{ $order->state_country }} {{ $order->postal_zip }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="p-t-20 p-b-20">
                            <h5 class="mtext-108 cl2 p-b-20">{{ __('messages.orderLookup.items') }}</h5>
                            <div class="wrap-table-shopping-cart">
                                <table class="table-shopping-cart">
                                    <tr class="table_head">
                                        <th class="column-1">{{ __('messages.orderLookup.product') }}</th>
                                        <th class="column-2"></th>
                                        <th class="column-3">{{ __('messages.orderLookup.qty') }}</th>
                                        <th class="column-5">{{ __('messages.orderLookup.price') }}</th>
                                    </tr>

                                    @foreach($order->items as $item)
                                        <tr class="table_row">
                                            <td class="column-1">
                                                <div class="how-itemcart1">
                                                    @if($item->product && $item->product->image)
                                                        <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" loading="lazy">
                                                    @else
                                                        <img src="{{ asset('frontend/images/item-cart-04.jpg') }}" alt="Product" loading="lazy">
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="column-2">
                                                <span class="stext-110 cl2">
                                                    {{ $item->product->name ?? __('messages.orderLookup.product') }}
                                                </span>
                                            </td>
                                            <td class="column-3">
                                                <span class="mtext-110 cl2">{{ $item->quantity }}</span>
                                            </td>
                                            <td class="column-5">
                                                <span class="mtext-110 cl2">Rs. {{ number_format($item->price * $item->quantity, 0) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <!-- Order Totals -->
                        <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                            <div class="size-208 w-full-ssm">
                                <span class="stext-110 cl2">
                                    {{ __('messages.orderLookup.subtotal') }}:
                                </span>
                            </div>
                            <div class="size-209">
                                <span class="mtext-110 cl2">
                                    Rs. {{ number_format($order->subtotal, 0) }}
                                </span>
                            </div>
                        </div>

                        @if($order->discount_amount > 0)
                            <div class="flex-w flex-t p-t-10 p-b-10">
                                <div class="size-208 w-full-ssm">
                                    <span class="stext-110 cl2">
                                        {{ __('messages.orderLookup.discount') }}:
                                    </span>
                                </div>
                                <div class="size-209">
                                    <span class="mtext-110 cl2" style="color: #4caf50;">
                                        -Rs. {{ number_format($order->discount_amount, 0) }}
                                    </span>
                                </div>
                            </div>
                        @endif

                        <div class="flex-w flex-t p-t-27 p-b-33">
                            <div class="size-208 w-full-ssm">
                                <span class="mtext-101 cl2">
                                    {{ __('messages.orderLookup.total') }}:
                                </span>
                            </div>
                            <div class="size-209 p-t-1">
                                <span class="mtext-110 cl2" style="font-size: 24px; font-weight: 600;">
                                    Rs. {{ number_format($order->total, 0) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

