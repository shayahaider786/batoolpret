@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Sliders</h4>
                            <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary btn-sm">
                                <i class="mdi mdi-plus"></i> Add New Slider
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
                                        <th>Website Image</th>
                                        <th>Mobile Image</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Link</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sliders ?? [] as $slider)
                                        <tr>
                                            <td>{{ $slider->id }}</td>
                                            <td>
                                                @if($slider->website_slider_image)
                                                    <img src="{{ asset($slider->website_slider_image) }}" 
                                                         alt="Website Slider" 
                                                         style="width: 80px; height: 50px; object-fit: cover; border-radius: 4px;">
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($slider->mobile_slider_image)
                                                    <img src="{{ asset($slider->mobile_slider_image) }}" 
                                                         alt="Mobile Slider" 
                                                         style="width: 50px; height: 80px; object-fit: cover; border-radius: 4px;">
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($slider->title)
                                                    <strong>{{ Str::limit($slider->title, 30) }}</strong>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($slider->description)
                                                    {{ Str::limit($slider->description, 50) }}
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($slider->link)
                                                    <a href="{{ $slider->link }}" target="_blank" class="text-primary">
                                                        <i class="mdi mdi-link"></i> View Link
                                                    </a>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2" role="group">
                                                    <a href="{{ route('admin.sliders.edit', $slider->id) }}" 
                                                       class="btn btn-sm btn-info" 
                                                       title="Edit">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('admin.sliders.destroy', $slider->id) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete this slider? This will also delete the images.');">
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
                                                    <i class="mdi mdi-image-multiple-outline" style="font-size: 48px;"></i>
                                                    <p class="mt-2">No sliders found</p>
                                                    <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary btn-sm mt-2">
                                                        <i class="mdi mdi-plus"></i> Add Your First Slider
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if(isset($sliders) && $sliders->hasPages())
                            <div class="mt-4">
                                {{ $sliders->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

