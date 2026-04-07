@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Add New Slider</h4>
                            <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary btn-sm">
                                <i class="mdi mdi-arrow-left"></i> Back to Sliders
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

                        <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="website_slider_image">Website Slider Image</label>
                                        <input type="file" 
                                               class="form-control-file @error('website_slider_image') is-invalid @enderror" 
                                               id="website_slider_image" 
                                               name="website_slider_image"
                                               accept="image/png,image/jpg,image/jpeg,image/webp">
                                        <small class="form-text text-muted">Upload website slider image (PNG, JPG, JPEG, WEBP - Max: 2MB)</small>
                                        @error('website_slider_image')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <div id="website-image-preview" class="mt-3" style="display: none;">
                                            <img id="preview-website-img" src="" alt="Preview" style="max-width: 300px; max-height: 200px; border-radius: 4px; border: 1px solid #ddd;">
                                            <p class="text-muted mt-2">Website Image Preview</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile_slider_image">Mobile Slider Image</label>
                                        <input type="file" 
                                               class="form-control-file @error('mobile_slider_image') is-invalid @enderror" 
                                               id="mobile_slider_image" 
                                               name="mobile_slider_image"
                                               accept="image/png,image/jpg,image/jpeg,image/webp">
                                        <small class="form-text text-muted">Upload mobile slider image (PNG, JPG, JPEG, WEBP - Max: 2MB)</small>
                                        @error('mobile_slider_image')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <div id="mobile-image-preview" class="mt-3" style="display: none;">
                                            <img id="preview-mobile-img" src="" alt="Preview" style="max-width: 200px; max-height: 300px; border-radius: 4px; border: 1px solid #ddd;">
                                            <p class="text-muted mt-2">Mobile Image Preview</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title') }}" 
                                       placeholder="Enter slider title">
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
                                          placeholder="Enter slider description">{{ old('description') }}</textarea>
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
                                       value="{{ old('link') }}" 
                                       placeholder="https://example.com">
                                <small class="form-text text-muted">Optional link for the slider (e.g., product page, category page)</small>
                                @error('link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.sliders.index') }}" class="btn btn-light mr-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-content-save"></i> Create Slider
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Website image preview
        const websiteImageInput = document.getElementById('website_slider_image');
        if (websiteImageInput) {
            websiteImageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                const previewImg = document.getElementById('preview-website-img');
                const imagePreview = document.getElementById('website-image-preview');
                
                if (file && previewImg && imagePreview) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        imagePreview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                } else if (imagePreview) {
                    imagePreview.style.display = 'none';
                }
            });
        }

        // Mobile image preview
        const mobileImageInput = document.getElementById('mobile_slider_image');
        if (mobileImageInput) {
            mobileImageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                const previewImg = document.getElementById('preview-mobile-img');
                const imagePreview = document.getElementById('mobile-image-preview');
                
                if (file && previewImg && imagePreview) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        imagePreview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                } else if (imagePreview) {
                    imagePreview.style.display = 'none';
                }
            });
        }
    </script>
@endsection

