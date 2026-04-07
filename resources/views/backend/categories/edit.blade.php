@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Edit Category</h4>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm">
                                <i class="mdi mdi-arrow-left"></i> Back to Categories
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

                        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="name">Category Name <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               id="name" 
                                               name="name" 
                                               value="{{ old('name', $category->name) }}" 
                                               placeholder="Enter category name"
                                               required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select class="form-control @error('status') is-invalid @enderror" 
                                                id="status" 
                                                name="status" 
                                                required>
                                            <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="parent_id">Parent Category (Optional - Leave empty for main category)</label>
                                <select class="form-control @error('parent_id') is-invalid @enderror" 
                                        id="parent_id" 
                                        name="parent_id">
                                    <option value="">None (Main Category)</option>
                                    @foreach($parentCategories ?? [] as $parent)
                                        <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">
                                    @if($category->isSubcategory() && $category->parent)
                                        Current parent: <strong>{{ $category->parent->name }}</strong>. Select a different parent or "None" to make it a main category.
                                    @else
                                        Select a parent category to make this a subcategory, or leave empty to keep it as a main category.
                                    @endif
                                </small>
                                @error('parent_id')
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
                                          placeholder="Enter category description">{{ old('description', $category->description) }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">Category Image</label>
                                @if($category->image)
                                    <div class="mb-3">
                                        <img src="{{ asset($category->image) }}" 
                                             alt="Current Image" 
                                             style="max-width: 200px; max-height: 200px; border-radius: 4px; border: 1px solid #ddd;">
                                        <p class="text-muted mt-2">Current Image</p>
                                    </div>
                                @endif
                                <input type="file" 
                                       class="form-control-file @error('image') is-invalid @enderror" 
                                       id="image" 
                                       name="image"
                                       accept="image/*">
                                        <small class="form-text text-muted">Upload new image to replace current one (JPG, PNG, GIF, WEBP - Max: 2MB). Images will be converted to WebP format.</small>
                                @error('image')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div id="image-preview" class="mt-3" style="display: none;">
                                    <img id="preview-img" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 4px; border: 1px solid #ddd;">
                                    <p class="text-muted mt-2">New Image Preview</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="banner_image">Banner Image</label>
                                        @if($category->banner_image)
                                            <div class="mb-3">
                                                <img src="{{ asset($category->banner_image) }}" 
                                                     alt="Current Banner Image" 
                                                     style="max-width: 200px; max-height: 200px; border-radius: 4px; border: 1px solid #ddd;">
                                                <p class="text-muted mt-2">Current Banner Image</p>
                                            </div>
                                        @endif
                                        <input type="file" 
                                               class="form-control-file @error('banner_image') is-invalid @enderror" 
                                               id="banner_image" 
                                               name="banner_image"
                                               accept="image/*">
                                        <small class="form-text text-muted">Upload new banner image to replace current one (JPG, PNG, GIF, WEBP - Max: 2MB). Images will be converted to WebP format.</small>
                                        @error('banner_image')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <div id="banner-image-preview" class="mt-3" style="display: none;">
                                            <img id="preview-banner-img" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 4px; border: 1px solid #ddd;">
                                            <p class="text-muted mt-2">New Banner Image Preview</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-light mr-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-content-save"></i> Update Category
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Image preview
        const imageInput = document.getElementById('image');
        if (imageInput) {
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                const previewImg = document.getElementById('preview-img');
                const imagePreview = document.getElementById('image-preview');
                
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

        // Banner image preview
        const bannerImageInput = document.getElementById('banner_image');
        if (bannerImageInput) {
            bannerImageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                const previewBannerImg = document.getElementById('preview-banner-img');
                const bannerImagePreview = document.getElementById('banner-image-preview');
                
                if (file && previewBannerImg && bannerImagePreview) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewBannerImg.src = e.target.result;
                        bannerImagePreview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                } else if (bannerImagePreview) {
                    bannerImagePreview.style.display = 'none';
                }
            });
        }
    </script>
@endsection

