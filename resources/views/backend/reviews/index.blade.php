@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Reviews</h4>
                        </div>
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product</th>
                                        <th>Reviewer</th>
                                        <th>Rating</th>
                                        <th>Title</th>
                                        <th>Comment</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($reviews ?? [] as $review)
                                        <tr>
                                            <td>{{ $review->id }}</td>
                                            <td>
                                                @if($review->product)
                                                    <strong>{{ $review->product->name }}</strong>
                                                @else
                                                    <span class="text-muted">Product Deleted</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $review->name }}
                                                @if($review->user)
                                                    <br><small class="text-muted">User ID: {{ $review->user_id }}</small>
                                                @else
                                                    <br><small class="text-muted">Guest</small>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating)
                                                            <i class="fa fa-star text-warning" style="font-size: 0.9rem;"></i>
                                                        @else
                                                            <i class="far fa-star text-warning" style="font-size: 0.9rem;"></i>
                                                        @endif
                                                    @endfor
                                                    <span class="ms-1">({{ $review->rating }})</span>
                                                </div>
                                            </td>
                                            <td>
                                                @if($review->title)
                                                    <strong>{{ Str::limit($review->title, 30) }}</strong>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small>{{ Str::limit($review->comment, 50) }}</small>
                                            </td>
                                            <td>
                                                @if($review->status == 'pending')
                                                    <span class="badge badge-warning">Pending</span>
                                                @elseif($review->status == 'approved')
                                                    <span class="badge badge-success">Approved</span>
                                                @elseif($review->status == 'rejected')
                                                    <span class="badge badge-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $review->created_at->format('M d, Y') }}
                                                <br><small class="text-muted">{{ $review->created_at->format('h:i A') }}</small>
                                            </td>
                                            <td>
                                                <div class="d-grid gap-3">
                                                    @if($review->status == 'pending')
                                                        <form action="{{ route('admin.reviews.approve', $review->id) }}" 
                                                              method="POST" 
                                                              class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success" title="Approve">
                                                                <i class="mdi mdi-check"></i>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.reviews.reject', $review->id) }}" 
                                                              method="POST" 
                                                              class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-warning" title="Reject">
                                                                <i class="mdi mdi-close"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete this review?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                            <i class="mdi mdi-delete"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-4">
                                                <p class="text-muted mb-0">No reviews found.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if(isset($reviews) && $reviews->hasPages())
                            <div class="mt-4">
                                {{ $reviews->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

