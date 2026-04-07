@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Edit Best Seller Video</h4>
                            <a href="{{ route('admin.best-seller-videos.index') }}" class="btn btn-secondary btn-sm">
                                <i class="mdi mdi-arrow-left"></i> Back to List
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

                        <form action="{{ route('admin.best-seller-videos.update', $bestSellerVideo->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <label for="video">Video</label>
                                @if($bestSellerVideo->video)
                                    <div class="mb-3">
                                        <video controls style="max-width: 400px; max-height: 300px; border-radius: 4px; border: 1px solid #ddd;">
                                            <source src="{{ asset($bestSellerVideo->video) }}" type="video/{{ pathinfo($bestSellerVideo->video, PATHINFO_EXTENSION) }}">
                                            Your browser does not support the video tag.
                                        </video>
                                        <p class="text-muted mt-2">Current Video</p>
                                    </div>
                                @endif
                                <input type="file" 
                                       class="form-control-file @error('video') is-invalid @enderror" 
                                       id="video" 
                                       name="video"
                                       accept="video/*">
                                <small class="form-text text-muted">Upload new video to replace current one (MP4, AVI, MOV, WMV, FLV, WEBM - Max: 50MB). Leave empty to keep current video.</small>
                                @error('video')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div id="video-preview" class="mt-3" style="display: none;">
                                    <video id="preview-video" controls style="max-width: 400px; max-height: 300px; border-radius: 4px; border: 1px solid #ddd;">
                                        Your browser does not support the video tag.
                                    </video>
                                    <p class="text-muted mt-2">New Video Preview</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title', $bestSellerVideo->title) }}" 
                                       placeholder="Enter video title">
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="4" 
                                          placeholder="Enter video description">{{ old('description', $bestSellerVideo->description) }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="link">Link</label>
                                <input type="url" 
                                       class="form-control @error('link') is-invalid @enderror" 
                                       id="link" 
                                       name="link" 
                                       value="{{ old('link', $bestSellerVideo->link) }}" 
                                       placeholder="https://example.com">
                                <small class="form-text text-muted">Optional link for the video</small>
                                @error('link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.best-seller-videos.index') }}" class="btn btn-light mr-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-content-save"></i> Update Video
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Video preview
        const videoInput = document.getElementById('video');
        if (videoInput) {
            videoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                const previewVideo = document.getElementById('preview-video');
                const videoPreview = document.getElementById('video-preview');
                
                if (file && previewVideo && videoPreview) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewVideo.src = e.target.result;
                        videoPreview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                } else if (videoPreview) {
                    videoPreview.style.display = 'none';
                }
            });
        }
    </script>
@endsection

