@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Testimonials</h4>
                            <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary btn-sm">
                                <i class="mdi mdi-plus"></i> Add New Testimonial
                            </a>
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
                                        <th>Name</th>
                                        <th>Rating</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Order</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($testimonials ?? [] as $testimonial)
                                        <tr>
                                            <td>{{ $testimonial->id }}</td>
                                            <td>
                                                <strong>{{ Str::limit($testimonial->name, 40) }}</strong>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fa fa-star{{ $i <= $testimonial->rating ? '' : '-o' }}" 
                                                           style="color: {{ $i <= $testimonial->rating ? '#e6a23c' : '#ddd' }}; font-size: 14px;"></i>
                                                    @endfor
                                                    <span class="ml-2 text-muted">({{ $testimonial->rating }}/5)</span>
                                                </div>
                                            </td>
                                            <td>
                                                {{ Str::limit($testimonial->description, 60) }}
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $testimonial->status === 'active' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($testimonial->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $testimonial->order }}</td>
                                            <td>
                                                <div class="d-flex gap-2" role="group">
                                                    <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}" 
                                                       class="btn btn-sm btn-info" 
                                                       title="Edit">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete this testimonial?');">
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
                                            <td colspan="7" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="mdi mdi-comment-text-multiple-outline" style="font-size: 48px;"></i>
                                                    <p class="mt-2">No testimonials found</p>
                                                    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary btn-sm mt-2">
                                                        <i class="mdi mdi-plus"></i> Add Your First Testimonial
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if(isset($testimonials) && $testimonials->hasPages())
                            <div class="mt-4">
                                {{ $testimonials->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
