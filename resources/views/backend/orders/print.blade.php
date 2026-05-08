<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Invoice - {{ $order->order_number }} - Batool Pret</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: 10in 4in landscape;
            margin: 0.2in;
        }

        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #000;
            background: #fff;
            padding: 0;
            width: 10in;
            height: 4in;
            font-weight: 600;
        }

        .print-container {
            width: 100%;
            height: 100%;
            padding: 15px 18px;
            display: flex;
            flex-direction: column;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            background: #fff;
        }

        .brand-logo {
            width: 30%;
        }

        .brand-logo img {
            max-width: 100%;
            height: auto;
            max-height: 45px;
        }

        .order-header-info {
            text-align: right;
            width: 65%;
        }

        .invoice-title {
            font-size: 22px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 6px;
            color: #000;
        }

        .order-number {
            font-size: 14px;
            font-weight: bold;
            color: #000;
            margin-bottom: 4px;
        }

        .order-date {
            font-size: 11px;
            color: #333;
        }

        .content-row {
            display: flex;
            gap: 15px;
            flex: 1;
            margin-bottom: 10px;
        }

        .left-column {
            width: 35%;
        }

        .right-column {
            width: 65%;
        }

        .info-box {
            margin-bottom: 10px;
        }

        .info-box h4 {
            font-size: 15px;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            margin-bottom: 8px;
            color: #000;
        }

        .info-box p {
            font-size: 16px;
            margin: 4px 0;
            color: #000;
            line-height: 1.5;
            font-weight: 600;
        }

        .info-box strong {
            font-weight: bold;
            font-size: 20px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-bottom: 10px;
        }

        .items-table thead th {
            background: #fff;
            color: #000;
            padding: 7px 5px;
            text-align: left;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 16px;
            border: 1.5px solid #000;
            letter-spacing: 0.5px;
        }

        .items-table tbody td {
            padding: 6px 5px;
            border: 1px solid #000000;
            color: #000;
            font-size: 14px;
            font-weight: 600;
        }

        .items-table tbody td:nth-child(2) {
            word-wrap: break-word;
            white-space: normal;
            max-width: 200px;
        }

        .items-table tbody tr:nth-child(even) {
            background: #fff;
        }

        .items-table tbody tr:nth-child(odd) {
            background: #fff;
        }

        .items-table tfoot th {
            text-align: left;
            padding: 6px 5px;
            border: 1.5px solid #000;
            background: #fff;
            color: #000;
            font-size: 18px;
            font-weight: bold;
        }

        .items-table tfoot td {
            padding: 6px 5px;
            border: 1.5px solid #000;
            font-weight: bold;
            font-size: 15px;
            color: #000;
            background: #fff;
        }

        .total-row {
            background: #fff !important;
            color: #000 !important;
        }

        .total-row th,
        .total-row td {
            background: #fff !important;
            color: #000 !important;
            font-size: 14px;
            font-weight: bold;
            padding: 7px 5px;
            border: 2px solid #000 !important;
        }

        .delivery-row th,
        .delivery-row td {
            background: #fff !important;
            color: #000 !important;
            font-size: 14px;
            font-weight: bold;
            padding: 7px 5px;
            border: 2px solid #000 !important;
        }

        .grand-total-row th,
        .grand-total-row td {
            background: #fff !important;
            color: #000 !important;
            font-size: 16px;
            font-weight: bold;
            padding: 7px 5px;
            border: 2px solid #000 !important;
        }

        .footer-section {
            border-top: 2px solid #000;
            padding-top: 8px;
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-logo {
            width: 25%;
        }

        .footer-logo img {
            max-width: 100%;
            height: auto;
            max-height: 30px;
        }

        .footer-text {
            text-align: center;
            flex: 1;
            font-size: 15px;
            color: #000;
            font-weight: 600;
        }

        .order-notes-box {
            margin-top: 8px;
            padding: 6px;
            border: 1.5px solid #000;
            font-size: 10px;
        }

        .order-notes-box strong {
            display: block;
            margin-bottom: 4px;
            font-size: 11px;
            text-transform: uppercase;
        }

        .no-print {
            display: none;
        }

        @media print {
            body {
                padding: 0;
                margin: 0;
            }

            .print-container {
                width: 10in;
                height: 4in;
            }

            .no-print {
                display: none !important;
            }

            @page {
                size: 10in 4in landscape;
                margin: 0.2in;
            }

            .items-table {
                page-break-inside: avoid;
            }

            .items-table tbody tr {
                page-break-inside: avoid;
            }
        }

        @media screen {
            body {
                padding: 20px;
                width: auto;
                height: auto;
                min-height: 400px;
                background: #f8f9fa;
            }

            .print-container {
                width: 10in;
                height: 4in;
                border: 2px dashed #ccc;
                background: #fff;
                margin: 0 auto;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            }

            .print-actions {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 1000;
                background: #fff;
                padding: 15px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            }

            .print-actions button {
                background: #000;
                color: #fff;
                border: none;
                padding: 10px 20px;
                cursor: pointer;
                font-size: 14px;
                font-weight: bold;
                text-transform: uppercase;
                margin-right: 10px;
                border-radius: 5px;
                transition: all 0.3s ease;
            }

            .print-actions button:hover {
                background: #333;
                transform: translateY(-2px);
            }
        }
    </style>
</head>
<body>
    <div class="print-actions no-print">
        <button onclick="window.print()" class="btn btn-dark">🖨️ Print</button>
        <button onclick="window.close()" class="btn btn-secondary">❌ Close</button>
    </div>

    <div class="print-container">
        <!-- Header -->
        <div class="header-section">
            <div class="brand-logo">
                <img src="{{ asset('../../frontend/images/icons/batoollogo.png') }}" alt="Batool Pret">
            </div>
            <div class="order-header-info">
                <div class="invoice-title">Order Invoice</div>
                <div class="order-number">#{{ $order->order_number }}</div>
                <div class="order-date">Date: {{ $order->created_at->format('F d, Y') }}</div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content-row">
            <!-- Left Column: Customer Info -->
            <div class="left-column">
                <div class="info-box">
                    <h4>Billing Details</h4>
                    <p><strong>{{ $order->first_name }} {{ $order->last_name }}</strong></p>
                    <p>{{ $order->email }}</p>
                    <p>{{ $order->phone }}</p>
                    <p>{{ $order->address }}</p>
                    @if($order->apartment)
                    <p>{{ $order->apartment }}</p>
                    @endif
                    <p>{{ $order->state_country }}, {{ $order->postal_zip }}</p>
                </div>

                @if($order->order_notes)
                <div class="order-notes-box">
                    <strong>Notes:</strong>
                    <p>{{ $order->order_notes }}</p>
                </div>
                @endif
            </div>

            <!-- Right Column: Items Table -->
            <div class="right-column">
                <table class="items-table">
                    <thead>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 30%;">Product</th>
                            <th style="width: 10%;">SKU</th>
                            <th style="width: 10%;">Size</th>
                            <th style="width: 8%;">Qty</th>
                            <th style="width: 15%;">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td style="word-wrap: break-word; white-space: normal;"><strong>{{ $item->product ? $item->product->name : 'N/A' }}</strong></td>
                            <td>{{ $item->product && $item->product->sku ? $item->product->sku : '—' }}</td>
                            <td>{{ $item->size ?? '—' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>PKR {{ number_format($item->price, 0) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        {{-- <tr class="total-row">
                            <th colspan="5">Subtotal:</th>
                            <td>PKR {{ number_format($order->subtotal, 0) }}</td>
                        </tr> --}}

                        @if($order->discount_amount > 0)
                        <tr class="total-row">
                            <th colspan="5">
                                Discount
                                @if($order->coupon_code)
                                    ({{ $order->coupon_code }})
                                @endif
                                :
                            </th>
                            <td style="color: #000;">-PKR {{ number_format($order->discount_amount, 0) }}</td>
                        </tr>
                        @endif

                        {{-- Conditional Delivery Charges Row --}}
                        @php
                            // Check if delivery charges exist and are greater than 0
                            $deliveryCharges = $order->delivery_charges ?? null;
                            $showDelivery = !is_null($deliveryCharges) && $deliveryCharges > 0;
                            $deliveryAmount = $showDelivery ? $deliveryCharges : 0;

                            // Calculate grand total based on whether delivery charges are applied
                            $grandTotal = $showDelivery
                                ? ($order->grand_total ?? ($order->total + $deliveryAmount))
                                : ($order->grand_total ?? $order->total);
                        @endphp

                        @if($showDelivery)
                        <tr class="delivery-row">
                            <th colspan="5">Delivery Charges:</th>
                            <td>PKR {{ number_format($deliveryAmount, 0) }}</td>
                        </tr>
                        @endif

                        <tr class="grand-total-row">
                            <th colspan="5">Grand Total:</th>
                            <td style="font-size: 16px; font-weight: bold;">PKR {{ number_format($grandTotal, 0) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer-section">
            <div class="footer-logo">
                <img src="{{ asset('../../frontend/images/icons/batoollogo.png') }}" alt="Batool Pret">
            </div>
            <div class="footer-text">
                <strong>Thank you for your order!</strong>
            </div>
            <div style="width: 25%; text-align: right; font-size: 11px;">
                <strong>Powered by Batool Pret</strong>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle (optional, for interactivity) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Auto-print when page loads (optional)
        // Uncomment the line below if you want auto-print
        // window.onload = function() { window.print(); }

        // Keyboard shortcut for printing (Ctrl+P)
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
        });
    </script>
</body>
</html>
