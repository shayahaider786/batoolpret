@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Best Seller Videos</h4>
                            <a href="{{ route('admin.best-seller-videos.create') }}" class="btn btn-primary btn-sm">
                                <i class="mdi mdi-plus"></i> Add New Video
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
                                        <th>Video</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Link</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bestSellerVideos ?? [] as $video)
                                        <tr>
                                            <td>{{ $video->id }}</td>
                                            <td>
                                                @if($video->video)
                                                    <video width="150" height="100" controls style="border-radius: 4px;">
                                                        <source src="{{ asset($video->video) }}" type="video/{{ pathinfo($video->video, PATHINFO_EXTENSION) }}">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($video->title)
                                                    <strong>{{ Str::limit($video->title, 30) }}</strong>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($video->description)
                                                    {{ Str::limit($video->description, 50) }}
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($video->link)
                                                    <a href="{{ $video->link }}" target="_blank" class="text-primary">
                                                        <i class="mdi mdi-link"></i> View Link
                                                    </a>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2" role="group">
                                                    <a href="{{ route('admin.best-seller-videos.edit', $video->id) }}" 
                                                       class="btn btn-sm btn-info" 
                                                       title="Edit">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('admin.best-seller-videos.destroy', $video->id) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete this video? This will also delete the video file.');">
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
                                            <td colspan="6" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="mdi mdi-video-outline" style="font-size: 48px;"></i>
                                                    <p class="mt-2">No videos found</p>
                                                    <a href="{{ route('admin.best-seller-videos.create') }}" class="btn btn-primary btn-sm mt-2">
                                                        <i class="mdi mdi-plus"></i> Add Your First Video
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if(isset($bestSellerVideos) && $bestSellerVideos->hasPages())
                            <div class="mt-4">
                                {{ $bestSellerVideos->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

