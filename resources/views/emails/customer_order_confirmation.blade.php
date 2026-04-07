<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #28a745;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .order-info {
            background-color: white;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            border-left: 4px solid #28a745;
        }
        .order-details {
            margin: 15px 0;
        }
        .order-details table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .order-details th,
        .order-details td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .order-details th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .total {
            font-size: 18px;
            font-weight: bold;
            color: #28a745;
            margin-top: 15px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 12px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            text-transform: capitalize;
        }
        .status-pending {
            background-color: #ffc107;
            color: #000;
        }
        .status-processing {
            background-color: #17a2b8;
            color: white;
        }
        .status-completed {
            background-color: #28a745;
            color: white;
        }
        .status-cancelled {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Thank You for Your Order!</h1>
    </div>

    <div class="content">
        <p>Hello {{ $order->first_name }},</p>

        <p>We're excited to confirm that we've received your order! Your order is currently being processed and you'll receive another email when it ships.</p>

        <div class="order-info">
            <h2>Order Information</h2>
            <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y h:i A') }}</p>
            <p><strong>Status:</strong>
                <span class="status-badge status-{{ $order->status }}">
                    {{ ucfirst($order->status) }}
                </span>
            </p>
        </div>

        <div class="order-details">
            <h3>Shipping Address</h3>
            <table>
                <tr>
                    <th>Name</th>
                    <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $order->email }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $order->phone }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>
                        {{ $order->address }}<br>
                        @if($order->apartment)
                            {{ $order->apartment }}<br>
                        @endif
                        {{ $order->state_country }}, {{ $order->postal_zip }}
                    </td>
                </tr>
                @if($order->company_name)
                <tr>
                    <th>Company</th>
                    <td>{{ $order->company_name }}</td>
                </tr>
                @endif
            </table>
        </div>

        <div class="order-details">
            <h3>Order Items</h3>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name ?? 'Product Deleted' }}</td>
                        <td>{{ $item->size ?? 'N/A' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>PKR {{ number_format($item->price, 0) }}</td>
                        <td>PKR {{ number_format($item->total, 0) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="order-details">
            <table>
                <tr>
                    <th>Subtotal</th>
                    <td>PKR {{ number_format($order->subtotal, 0) }}</td>
                </tr>
                @if($order->discount_amount > 0)
                <tr>
                    <th>Discount
                        @if($order->coupon_code)
                            ({{ $order->coupon_code }})
                        @endif
                    </th>
                    <td>-PKR {{ number_format($order->discount_amount, 0) }}</td>
                </tr>
                @endif
                <tr class="total">
                    <th>Total</th>
                    <td>PKR {{ number_format($order->total, 0) }}</td>
                </tr>
            </table>
        </div>

        @if($order->order_notes)
        <div class="order-info">
            <h3>Order Notes</h3>
            <p>{{ $order->order_notes }}</p>
        </div>
        @endif

        <div style="text-align: center;">
            <a href="{{ route('order.lookup') }}" class="button">Track Your Order</a>
        </div>

        <p style="margin-top: 20px;">If you have any questions about your order, please don't hesitate to contact us. We're here to help!</p>
    </div>

    <div class="footer">
        <p>Thank you for shopping with {{ config('app.name') }}!</p>
        <p>This is an automated confirmation email. Please do not reply to this message.</p>
    </div>
</body>
</html>
