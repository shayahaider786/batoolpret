@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Add New Product</h4>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-sm">
                                <i class="mdi mdi-arrow-left"></i> Back to Products
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

                        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="name">Product Name <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control @error('name') is-invalid @enderror"
                                               id="name"
                                               name="name"
                                               value="{{ old('name') }}"
                                               placeholder="Enter product name"
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
                                        <label for="category_id">Category <span class="text-danger">*</span></label>
                                        <select class="form-control @error('category_id') is-invalid @enderror"
                                                id="category_id"
                                                name="category_id"
                                                required>
                                            <option value="">Select Category</option>
                                            @foreach($categories ?? [] as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="short_description">Short Description</label>
                                <textarea class="form-control @error('short_description') is-invalid @enderror"
                                          id="short_description"
                                          name="short_description"
                                          rows="3"
                                          placeholder="Enter short description (max 500 characters)">{{ old('short_description') }}</textarea>
                                <small class="form-text text-muted">Brief description that will appear in product listings (max 500 characters)</small>
                                @error('short_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="long_description">Long Description</label>
                                <textarea class="form-control @error('long_description') is-invalid @enderror"
                                          id="long_description"
                                          name="long_description"
                                          rows="6"
                                          placeholder="Enter detailed product description">{{ old('long_description') }}</textarea>
                                <small class="form-text text-muted">Detailed description of the product</small>
                                @error('long_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="price">Price (PKR) <span class="text-danger">*</span></label>
                                        <input type="number"
                                               class="form-control @error('price') is-invalid @enderror"
                                               id="price"
                                               name="price"
                                               value="{{ old('price') }}"
                                               step="0.01"
                                               min="0"
                                               placeholder="0.00"
                                               required>
                                        @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="discount_price">Discount Price (PKR)</label>
                                        <input type="number"
                                               class="form-control @error('discount_price') is-invalid @enderror"
                                               id="discount_price"
                                               name="discount_price"
                                               value="{{ old('discount_price') }}"
                                               step="0.01"
                                               min="0"
                                               placeholder="0.00">
                                        <small class="form-text text-muted">Discount percent will be calculated automatically</small>
                                        @error('discount_price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="stock">Stock Quantity <span class="text-danger">*</span></label>
                                        <input type="number"
                                               class="form-control @error('stock') is-invalid @enderror"
                                               id="stock"
                                               name="stock"
                                               value="{{ old('stock') }}"
                                               min="0"
                                               placeholder="0"
                                               required>
                                        @error('stock')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select class="form-control @error('status') is-invalid @enderror"
                                                id="status"
                                                name="status"
                                                required>
                                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tag">Tag</label>
                                        <select class="form-control @error('tag') is-invalid @enderror"
                                                id="tag"
                                                name="tag">
                                            <option value="">Select Tag (Optional)</option>
                                            <option value="new_arrival" {{ old('tag') == 'new_arrival' ? 'selected' : '' }}>New Arrival</option>
                                            <option value="best_selling" {{ old('tag') == 'best_selling' ? 'selected' : '' }}>Best Selling</option>
                                            <option value="trending" {{ old('tag') == 'trending' ? 'selected' : '' }}>Trending</option>
                                        </select>
                                        <small class="form-text text-muted">Optional tag to categorize the product</small>
                                        @error('tag')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sku">SKU (Stock Keeping Unit)</label>
                                        <input type="text"
                                               class="form-control @error('sku') is-invalid @enderror"
                                               id="sku"
                                               name="sku"
                                               value="{{ old('sku') }}"
                                               placeholder="Leave empty to auto-generate">
                                        <small class="form-text text-muted">SKU will be generated automatically if left empty</small>
                                        @error('sku')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="slug">Slug</label>
                                        <input type="text"
                                               class="form-control @error('slug') is-invalid @enderror"
                                               id="slug"
                                               name="slug"
                                               value="{{ old('slug') }}"
                                               placeholder="Leave empty to auto-generate">
                                        <small class="form-text text-muted">Slug will be generated automatically from product name if left empty</small>
                                        @error('slug')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Product Details Section -->
                            <hr class="my-4">
                            <h5 class="mb-3">Product Details</h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Sizes</label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="size[]" value="xs" id="size_xs" {{ in_array('xs', old('size', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="size_xs">XS</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="size[]" value="S" id="size_s" {{ in_array('S', old('size', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="size_s">S</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="size[]" value="M" id="size_m" {{ in_array('M', old('size', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="size_m">M</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="size[]" value="L" id="size_l" {{ in_array('L', old('size', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="size_l">L</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="size[]" value="XL" id="size_xl" {{ in_array('XL', old('size', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="size_xl">XL</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="size[]" value="XXL" id="size_xxl" {{ in_array('XXL', old('size', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="size_xxl">XXL</label>
                                                </div>
                                            </div>
                                        </div>
                                        <small class="form-text text-muted">Select one or more sizes available for this product</small>
                                        <div id="selected-sizes" class="mt-2"></div>
                                        @error('size')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        @error('size.*')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="outfit_type">Outfit Type</label>
                                        <input type="text"
                                               class="form-control @error('outfit_type') is-invalid @enderror"
                                               id="outfit_type"
                                               name="outfit_type"
                                               value="{{ old('outfit_type') }}"
                                               placeholder="e.g., Casual, Formal, Party">
                                        @error('outfit_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="color">Color</label>
                                        <input type="text"
                                               class="form-control @error('color') is-invalid @enderror"
                                               id="color"
                                               name="color"
                                               value="{{ old('color') }}"
                                               placeholder="e.g., Red, Blue, Black">
                                        @error('color')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="fabric">Fabric</label>
                                        <textarea class="form-control @error('fabric') is-invalid @enderror"
                                                  id="fabric"
                                                  name="fabric"
                                                  rows="2"
                                                  placeholder="e.g., 100% Cotton, Polyester Blend">{{ old('fabric') }}</textarea>
                                        @error('fabric')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="includes">Includes</label>
                                <textarea class="form-control @error('includes') is-invalid @enderror"
                                          id="includes"
                                          name="includes"
                                          rows="3"
                                          placeholder="e.g., 1 x T-Shirt, 1 x Belt, 1 x Gift Box">{{ old('includes') }}</textarea>
                                <small class="form-text text-muted">List what is included with this product</small>
                                @error('includes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="design_details">Design Details</label>
                                <textarea class="form-control @error('design_details') is-invalid @enderror"
                                          id="design_details"
                                          name="design_details"
                                          rows="3"
                                          placeholder="Enter design details, patterns, or special features">{{ old('design_details') }}</textarea>
                                <small class="form-text text-muted">Describe the design, patterns, or special features</small>
                                @error('design_details')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="care_instructions">Care Instructions</label>
                                <textarea class="form-control @error('care_instructions') is-invalid @enderror"
                                          id="care_instructions"
                                          name="care_instructions"
                                          rows="3"
                                          placeholder="e.g., Machine wash cold, Do not bleach, Hang dry">{{ old('care_instructions') }}</textarea>
                                <small class="form-text text-muted">Provide care and washing instructions</small>
                                @error('care_instructions')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="disclaimer">Disclaimer</label>
                                <textarea class="form-control @error('disclaimer') is-invalid @enderror"
                                          id="disclaimer"
                                          name="disclaimer"
                                          rows="3"
                                          placeholder="Enter any disclaimers or important notes">{{ old('disclaimer') }}</textarea>
                                <small class="form-text text-muted">Any disclaimers or important information about the product</small>
                                @error('disclaimer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="youtube_link">YouTube Video Link</label>
                                <input type="url"
                                       class="form-control @error('youtube_link') is-invalid @enderror"
                                       id="youtube_link"
                                       name="youtube_link"
                                       value="{{ old('youtube_link') }}"
                                       placeholder="https://www.youtube.com/watch?v=... or https://youtu.be/...">
                                <small class="form-text text-muted">Optional YouTube video link for the product (e.g., product demo, review, etc.)</small>
                                @error('youtube_link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <hr class="my-4">
                            <h5 class="mb-3">SEO Settings</h5>

                            <div class="form-group">
                                <label for="meta_title">Meta Title</label>
                                <input type="text"
                                       class="form-control @error('meta_title') is-invalid @enderror"
                                       id="meta_title"
                                       name="meta_title"
                                       value="{{ old('meta_title') }}"
                                       placeholder="Enter meta title for SEO (recommended: 50-60 characters)"
                                       maxlength="255">
                                <small class="form-text text-muted">The title that appears in search engine results. If left empty, product name will be used.</small>
                                <div class="mt-1">
                                    <small id="meta_title_count" class="text-muted">0 / 255 characters</small>
                                </div>
                                @error('meta_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="meta_description">Meta Description</label>
                                <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                          id="meta_description"
                                          name="meta_description"
                                          rows="3"
                                          placeholder="Enter meta description for SEO (recommended: 150-160 characters)"
                                          maxlength="500">{{ old('meta_description') }}</textarea>
                                <small class="form-text text-muted">Brief description that appears in search engine results. If left empty, short description will be used.</small>
                                <div class="mt-1">
                                    <small id="meta_description_count" class="text-muted">0 / 500 characters</small>
                                </div>
                                @error('meta_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="meta_keywords">Meta Keywords</label>
                                <input type="text"
                                       class="form-control @error('meta_keywords') is-invalid @enderror"
                                       id="meta_keywords"
                                       name="meta_keywords"
                                       value="{{ old('meta_keywords') }}"
                                       placeholder="e.g., fashion, clothing, dress, women's wear (comma-separated)"
                                       maxlength="500">
                                <small class="form-text text-muted">Comma-separated keywords relevant to this product for SEO purposes.</small>
                                <div class="mt-1">
                                    <small id="meta_keywords_count" class="text-muted">0 / 500 characters</small>
                                </div>
                                @error('meta_keywords')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="meta_tags">Meta Tags</label>
                                <input type="text"
                                       class="form-control @error('meta_tags') is-invalid @enderror"
                                       id="meta_tags"
                                       name="meta_tags"
                                       value="{{ old('meta_tags') }}"
                                       placeholder="e.g., premium, quality, elegant, stylish (comma-separated)"
                                       maxlength="500">
                                <small class="form-text text-muted">Additional tags for better categorization and SEO (comma-separated).</small>
                                <div class="mt-1">
                                    <small id="meta_tags_count" class="text-muted">0 / 500 characters</small>
                                </div>
                                @error('meta_tags')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <hr class="my-4">
                            <h5 class="mb-3">Product Images</h5>

                            <div class="form-group">
                                <label for="image">Main Product Image</label>
                                <input type="file"
                                       class="form-control-file @error('image') is-invalid @enderror"
                                       id="image"
                                       name="image"
                                       accept="image/*">
                                <small class="form-text text-muted">Upload main product image (JPG, PNG, GIF, WebP - Max: 2MB). Images will be automatically converted to WebP format.</small>
                                @error('image')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div id="image-preview" class="mt-3" style="display: none;">
                                    <img id="preview-img" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 4px; border: 1px solid #ddd;">
                                    <p class="text-muted mt-2">Image Preview</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="images">Additional Product Images</label>
                                <input type="file"
                                       class="form-control-file @error('images.*') is-invalid @enderror"
                                       id="images"
                                       name="images[]"
                                       accept="image/*"
                                       multiple>
                                <small class="form-text text-muted">Upload multiple images (JPG, PNG, GIF, WebP - Max: 2MB each). Images will be automatically converted to WebP format.</small>
                                @error('images.*')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div id="images-preview" class="mt-3 row"></div>
                            </div>

                            <div class="form-group">
                                <label for="size_guide_image">Size Guide Image</label>
                                <input type="file"
                                       class="form-control-file @error('size_guide_image') is-invalid @enderror"
                                       id="size_guide_image"
                                       name="size_guide_image"
                                       accept="image/*">
                                <small class="form-text text-muted">Upload size guide image (JPG, PNG, GIF, WebP - Max: 2MB). Image will be automatically converted to WebP format.</small>
                                @error('size_guide_image')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div id="size-guide-preview" class="mt-3" style="display: none;">
                                    <img id="preview-size-guide-img" src="" alt="Size Guide Preview" style="max-width: 300px; max-height: 400px; border-radius: 4px; border: 1px solid #ddd;">
                                    <p class="text-muted mt-2">Size Guide Image Preview</p>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.products.index') }}" class="btn btn-light mr-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-content-save"></i> Create Product
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Main image preview
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

        // Multiple images preview
        const imagesInput = document.getElementById('images');
        if (imagesInput) {
            imagesInput.addEventListener('change', function(e) {
                const files = e.target.files;
                const previewContainer = document.getElementById('images-preview');
                previewContainer.innerHTML = '';

                if (files && files.length > 0) {
                    Array.from(files).forEach((file, index) => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const col = document.createElement('div');
                            col.className = 'col-md-3 mb-3';
                            col.innerHTML = `
                                <div class="position-relative">
                                    <img src="${e.target.result}" alt="Preview ${index + 1}"
                                         style="width: 100%; height: 150px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
                                </div>
                            `;
                            previewContainer.appendChild(col);
                        }
                        reader.readAsDataURL(file);
                    });
                }
            });
        }

        // Size guide image preview
        const sizeGuideInput = document.getElementById('size_guide_image');
        if (sizeGuideInput) {
            sizeGuideInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                const previewImg = document.getElementById('preview-size-guide-img');
                const sizeGuidePreview = document.getElementById('size-guide-preview');

                if (file && previewImg && sizeGuidePreview) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        sizeGuidePreview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                } else if (sizeGuidePreview) {
                    sizeGuidePreview.style.display = 'none';
                }
            });
        }

        // Show selected sizes
        const sizeCheckboxes = document.querySelectorAll('input[name="size[]"]');
        const selectedSizesDiv = document.getElementById('selected-sizes');

        function updateSelectedSizes() {
            const selectedSizes = Array.from(sizeCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);

            if (selectedSizes.length > 0) {
                selectedSizesDiv.innerHTML = '<strong>Selected Sizes:</strong> ' + selectedSizes.join(', ');
                selectedSizesDiv.className = 'mt-2 text-success';
            } else {
                selectedSizesDiv.innerHTML = '';
            }
        }

        sizeCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedSizes);
        });

        // Initialize on page load
        updateSelectedSizes();

        // Character counters for SEO fields
        function setupCharacterCounter(inputId, counterId, maxLength) {
            const input = document.getElementById(inputId);
            const counter = document.getElementById(counterId);
            if (input && counter) {
                input.addEventListener('input', function() {
                    const length = this.value.length;
                    counter.textContent = length + ' / ' + maxLength + ' characters';
                    if (length > maxLength * 0.9) {
                        counter.className = 'text-warning';
                    } else {
                        counter.className = 'text-muted';
                    }
                });
                // Initialize counter on page load
                if (input.value) {
                    const length = input.value.length;
                    counter.textContent = length + ' / ' + maxLength + ' characters';
                }
            }
        }

        setupCharacterCounter('meta_title', 'meta_title_count', 255);
        setupCharacterCounter('meta_description', 'meta_description_count', 500);
        setupCharacterCounter('meta_keywords', 'meta_keywords_count', 500);
        setupCharacterCounter('meta_tags', 'meta_tags_count', 500);
    </script>
@endsection
