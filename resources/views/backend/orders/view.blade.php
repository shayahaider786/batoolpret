@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Order Details</h4>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('admin.orders.print', $order->id) }}" target="_blank"
                                    class="btn btn-info btn-sm">
                                    <i class="mdi mdi-printer"></i> Print Order
                                </a>
                                <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-primary btn-sm">
                                    <i class="mdi mdi-pencil"></i> Edit Order
                                </a>
                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete order #{{ $order->order_number }}? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="mdi mdi-delete"></i> Delete Order
                                    </button>
                                </form>
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="mdi mdi-arrow-left"></i> Back to Orders
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="mb-0">Order Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th width="40%">Order Number:</th>
                                                <td><strong class="text-primary">{{ $order->order_number }}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>Status:</th>
                                                <td>
                                                    @if ($order->status == 'pending')
                                                        <span class="badge badge-warning">Pending</span>
                                                    @elseif($order->status == 'processing')
                                                        <span class="badge badge-info">Processing</span>
                                                    @elseif($order->status == 'completed')
                                                        <span class="badge badge-success">Completed</span>
                                                    @elseif($order->status == 'cancelled')
                                                        <span class="badge badge-danger">Cancelled</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Payment Method:</th>
                                                <td>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</td>
                                            </tr>
                                            @if ($order->payment_screenshot)
                                                <tr>
                                                    <th>Payment Screenshot:</th>
                                                    <td>
                                                        <a href="{{ asset($order->payment_screenshot) }}" target="_blank"
                                                            class="btn btn-sm btn-info">
                                                            <i class="mdi mdi-image"></i> View Screenshot
                                                        </a>
                                                        <br>
                                                        <small class="text-muted">Click to view full size</small>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($order->coupon_code)
                                                <tr>
                                                    <th>Coupon Code:</th>
                                                    <td>
                                                        <code class="text-primary">{{ $order->coupon_code }}</code>
                                                        @if ($order->coupon)
                                                            <br><small class="text-muted">{{ $order->coupon->name }}
                                                                ({{ $order->coupon_discount }}% OFF)</small>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <th>Order Date:</th>
                                                <td>{{ $order->created_at->format('F d, Y h:i A') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Customer Type:</th>
                                                <td>
                                                    @if ($order->user)
                                                        <span class="badge badge-info">Registered User</span>
                                                        <br><small class="text-muted">User ID:
                                                            {{ $order->user_id }}</small>
                                                    @else
                                                        <span class="badge badge-secondary">Guest</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="mb-0">Billing Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th width="40%">Name:</th>
                                                <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                                            </tr>
                                            @if ($order->company_name)
                                                <tr>
                                                    <th>Company:</th>
                                                    <td>{{ $order->company_name }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <th>Email:</th>
                                                <td>{{ $order->email }}</td>
                                            </tr>
                                            <tr>
                                                <th>Phone:</th>
                                                <td>
                                                    {{ $order->phone }}<br> <br>
                                                    @php
                                                        // 1. Clean phone number (remove spaces, +, - etc)
                                                        $phoneNumber = preg_replace('/[^0-9]/', '', $order->phone);

                                                        // 2. Convert Pakistani number format
                                                        // 03001234567 → 923001234567
                                                        if (substr($phoneNumber, 0, 1) == '0') {
                                                            $phoneNumber = '92' . substr($phoneNumber, 1);
                                                        }

                                                        // 3. Build WhatsApp message
                                                        $message =
                                                            'Assalam o Alaikum ' .
                                                            $order->first_name .
                                                            ' ' .
                                                            $order->last_name .
                                                            "\n\n";
                                                        $message .= "Thank you for shopping with Zaylish Studio.\n";
                                                        $message .=
                                                            'Your order #' .
                                                            $order->order_number .
                                                            " has been received.\n\n";
                                                        $message .= "Products:\n";

                                                        foreach ($order->items as $item) {
                                                            $productName = $item->product
                                                                ? $item->product->name
                                                                : 'Product';
                                                            $sizeText = $item->size ? ' (' . $item->size . ')' : '';
                                                            $message .=
                                                                $productName .
                                                                $sizeText .
                                                                ' - PKR ' .
                                                                number_format($item->price, 0) .
                                                                "\n";
                                                        }

                                                        $message .=
                                                            "\nTotal: PKR " . number_format($order->total, 0) . "\n\n";
                                                        $message .=
                                                            "Kindly reply CONFIRM to proceed with your order.\n\n";
                                                        $message .= 'Thank you for choosing Zaylish Studio.';

                                                        // 4. Encode message for URL
                                                        $encodedMessage = urlencode($message);
                                                    @endphp

                                                    @if (strlen($phoneNumber) >= 11)
                                                        <a href="https://wa.me/{{ $phoneNumber }}?text={{ $encodedMessage }}"
                                                            target="_blank" class="btn btn-success btn-sm">
                                                            <i class="mdi mdi-whatsapp"></i> WhatsApp Customer
                                                        </a>
                                                    @endif

                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Address:</th>
                                                <td>
                                                    {{ $order->address }}
                                                    @if ($order->apartment)
                                                        <br>{{ $order->apartment }}
                                                    @endif
                                                    <br>{{ $order->state_country }}
                                                    <br>{{ $order->postal_zip }}
                                                </td>
                                            </tr>
                                            @if ($order->order_notes)
                                                <tr>
                                                    <th>Order Notes:</th>
                                                    <td>{{ $order->order_notes }}</td>
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($order->payment_screenshot)
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h5 class="mb-0">Payment Screenshot</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <a href="{{ asset($order->payment_screenshot) }}" target="_blank">
                                                <img src="{{ asset($order->payment_screenshot) }}" alt="Payment Screenshot"
                                                    class="img-fluid rounded"
                                                    style="max-height: 400px; cursor: pointer; border: 1px solid #ddd;">
                                            </a>
                                            <p class="mt-2 mb-0">
                                                <small class="text-muted">Click image to view full size</small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Order Items</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Product</th>
                                                <th>SKU</th>
                                                <th>Size</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->items as $item)
                                                <tr>
                                                    <td>
                                                        @if ($item->product)
                                                            @if ($item->product->image)
                                                                <img src="{{ asset($item->product->image) }}"
                                                                    alt="{{ $item->product->name }}" class="img-sm rounded"
                                                                    style="width: 60px; height: 60px; object-fit: cover;">
                                                            @else
                                                                <div class="img-sm rounded bg-light d-flex align-items-center justify-content-center"
                                                                    style="width: 60px; height: 60px;">
                                                                    <i class="mdi mdi-image"></i>
                                                                </div>
                                                            @endif
                                                        @else
                                                            <div class="img-sm rounded bg-light d-flex align-items-center justify-content-center"
                                                                style="width: 60px; height: 60px;">
                                                                <i class="mdi mdi-image-off"></i>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($item->product)
                                                            <strong>{{ $item->product->name }}</strong>
                                                        @else
                                                            <span class="text-muted">Product Deleted</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($item->product && $item->product->sku)
                                                            <code>{{ $item->product->sku }}</code>
                                                        @else
                                                            <span class="text-muted">—</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($item->size)
                                                            <span class="badge badge-info">{{ $item->size }}</span>
                                                        @else
                                                            <span class="text-muted">—</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>PKR {{ number_format($item->price, 2) }}</td>
                                                    <td><strong>PKR {{ number_format($item->total, 2) }}</strong></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="5" class="text-right">Subtotal:</th>
                                                <th>PKR {{ number_format($order->subtotal, 2) }}</th>
                                            </tr>
                                            @if ($order->discount_amount > 0)
                                                <tr>
                                                    <th colspan="5" class="text-right">
                                                        Coupon Discount
                                                        @if ($order->coupon_code)
                                                            <br><small
                                                                class="text-muted">({{ $order->coupon_code }})</small>
                                                        @endif
                                                    </th>
                                                    <th class="text-success">-PKR
                                                        {{ number_format($order->discount_amount, 2) }}</th>
                                                </tr>
                                            @endif
                                            <tr>
                                                <th colspan="5" class="text-right">Total:</th>
                                                <th class="text-primary">PKR {{ number_format($order->total, 2) }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
