@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Edit Order</h4>
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">
                                <i class="mdi mdi-arrow-left"></i> Back to Orders
                            </a>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h5 class="mb-0">Order Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="order_number">Order Number</label>
                                                <input type="text" class="form-control" value="{{ $order->order_number }}" disabled>
                                                <small class="form-text text-muted">Order number cannot be changed</small>
                                            </div>

                                            <div class="form-group">
                                                <label for="status">Order Status</label>
                                                <select class="form-control @error('status') is-invalid @enderror"
                                                        id="status"
                                                        name="status">
                                                    <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="processing" {{ old('status', $order->status) == 'processing' ? 'selected' : '' }}>Processing</option>
                                                    <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                                    <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                                @error('status')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label>Order Date</label>
                                                <input type="text" class="form-control" value="{{ $order->created_at->format('F d, Y h:i A') }}" disabled>
                                            </div>

                                            {{-- <div class="form-group">
                                                <label>Subtotal</label>
                                                <input type="number" step="0.01" class="form-control" name="subtotal" value="{{ old('subtotal', $order->subtotal) }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Coupon Code</label>
                                                <input type="text" class="form-control" name="coupon_code" value="{{ old('coupon_code', $order->coupon_code) }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Coupon Discount (%)</label>
                                                <input type="number" step="0.01" class="form-control" name="coupon_discount" value="{{ old('coupon_discount', $order->coupon_discount) }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Discount Amount</label>
                                                <input type="number" step="0.01" class="form-control text-success" name="discount_amount" value="{{ old('discount_amount', $order->discount_amount) }}">
                                            </div> --}}
                                            <div class="form-group">
                                                <label>Total Amount</label>
                                                <input type="number" step="0.01" class="form-control" name="total" value="{{ old('total', $order->total) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h5 class="mb-0">Billing Details</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="first_name">First Name</label>
                                                <input type="text"
                                                       class="form-control @error('first_name') is-invalid @enderror"
                                                       id="first_name"
                                                       name="first_name"
                                                       value="{{ old('first_name', $order->first_name) }}">
                                                @error('first_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="last_name">Last Name</label>
                                                <input type="text"
                                                       class="form-control @error('last_name') is-invalid @enderror"
                                                       id="last_name"
                                                       name="last_name"
                                                       value="{{ old('last_name', $order->last_name) }}">
                                                @error('last_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email"
                                                       class="form-control @error('email') is-invalid @enderror"
                                                       id="email"
                                                       name="email"
                                                       value="{{ old('email', $order->email) }}">
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="phone">Phone</label>
                                                <input type="text"
                                                       class="form-control @error('phone') is-invalid @enderror"
                                                       id="phone"
                                                       name="phone"
                                                       value="{{ old('phone', $order->phone) }}">
                                                @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="company_name">Company Name</label>
                                                <input type="text"
                                                       class="form-control @error('company_name') is-invalid @enderror"
                                                       id="company_name"
                                                       name="company_name"
                                                       value="{{ old('company_name', $order->company_name) }}">
                                                @error('company_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="address">Address </label>
                                                <input type="text"
                                                       class="form-control @error('address') is-invalid @enderror"
                                                       id="address"
                                                       name="address"
                                                       value="{{ old('address', $order->address) }}">
                                                @error('address')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="apartment">Apartment/Suite</label>
                                                <input type="text"
                                                       class="form-control @error('apartment') is-invalid @enderror"
                                                       id="apartment"
                                                       name="apartment"
                                                       value="{{ old('apartment', $order->apartment) }}">
                                                @error('apartment')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="state_country">State / Country </label>
                                                      <input type="text"
                                                          class="form-control @error('state_country') is-invalid @enderror"
                                                          id="state_country"
                                                          name="state_country"
                                                          value="{{ old('state_country', $order->state_country) }}">
                                                @error('state_country')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="postal_zip">Postal / Zip </label>
                                                      <input type="text"
                                                          class="form-control @error('postal_zip') is-invalid @enderror"
                                                          id="postal_zip"
                                                          name="postal_zip"
                                                          value="{{ old('postal_zip', $order->postal_zip) }}">
                                                @error('postal_zip')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="order_notes">Order Notes</label>
                                                <textarea class="form-control @error('order_notes') is-invalid @enderror"
                                                          id="order_notes"
                                                          name="order_notes"
                                                          rows="3">{{ old('order_notes', $order->order_notes) }}</textarea>
                                                @error('order_notes')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3">
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
                                                @foreach($order->items as $item)
                                                    <tr>
                                                        <td>
                                                            @if($item->product)
                                                                @if($item->product->image)
                                                                    <img src="{{ asset($item->product->image) }}"
                                                                         alt="{{ $item->product->name }}"
                                                                         class="img-sm rounded"
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
                                                            @if($item->product)
                                                                <strong>{{ $item->product->name }}</strong>
                                                            @else
                                                                <span class="text-muted">Product Deleted</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($item->product && $item->product->sku)
                                                                <code>{{ $item->product->sku }}</code>
                                                            @else
                                                                <span class="text-muted">—</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <input type="text" name="items[{{ $item->id }}][size]" class="form-control" value="{{ old('items.' . $item->id . '.size', $item->size) }}" placeholder="Size">
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
                                                @if($order->discount_amount > 0)
                                                <tr>
                                                    <th colspan="5" class="text-right">
                                                        Coupon Discount
                                                        @if($order->coupon_code)
                                                            <br><small class="text-muted">({{ $order->coupon_code }})</small>
                                                        @endif
                                                    </th>
                                                    <th class="text-success">-PKR {{ number_format($order->discount_amount, 2) }}</th>
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

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

