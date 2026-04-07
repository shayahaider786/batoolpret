@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Edit Product</h4>
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

                        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="name">Product Name <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control @error('name') is-invalid @enderror"
                                               id="name"
                                               name="name"
                                               value="{{ old('name', $product->name) }}"
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
                                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                                          placeholder="Enter short description (max 500 characters)">{{ old('short_description', $product->short_description) }}</textarea>
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
                                          placeholder="Enter detailed product description">{{ old('long_description', $product->long_description) }}</textarea>
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
                                               value="{{ old('price', $product->price) }}"
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
                                               value="{{ old('discount_price', $product->discount_price) }}"
                                               step="0.01"
                                               min="0"
                                               placeholder="0.00">
                                        <small class="form-text text-muted">
                                            @if($product->discount_percent)
                                                Current discount: <strong>{{ $product->discount_percent }}%</strong>
                                            @else
                                                Discount percent will be calculated automatically
                                            @endif
                                        </small>
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
                                               value="{{ old('stock', $product->stock) }}"
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
                                            <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                                            <option value="new_arrival" {{ old('tag', $product->tag) == 'new_arrival' ? 'selected' : '' }}>New Arrival</option>
                                            <option value="best_selling" {{ old('tag', $product->tag) == 'best_selling' ? 'selected' : '' }}>Best Selling</option>
                                            <option value="trending" {{ old('tag', $product->tag) == 'trending' ? 'selected' : '' }}>Trending</option>
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
                                               value="{{ old('sku', $product->sku) }}"
                                               placeholder="Leave empty to auto-generate">
                                        <small class="form-text text-muted">
                                            @if($product->sku)
                                                Current SKU: <strong>{{ $product->sku }}</strong>. Leave empty to keep current SKU.
                                            @else
                                                SKU will be generated automatically if left empty
                                            @endif
                                        </small>
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
                                               value="{{ old('slug', $product->slug) }}"
                                               placeholder="Leave empty to auto-generate">
                                        <small class="form-text text-muted">
                                            @if($product->slug)
                                                Current slug: <strong>{{ $product->slug }}</strong>. Leave empty to auto-generate from name.
                                            @else
                                                Slug will be generated automatically from product name if left empty
                                            @endif
                                        </small>
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
                                        @php
                                            $currentSizes = old('size', $product->size ?? []);
                                            if (!is_array($currentSizes)) {
                                                $currentSizes = $currentSizes ? [$currentSizes] : [];
                                            }
                                        @endphp
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="size[]" value="xs" id="size_xs" {{ in_array('xs', $currentSizes) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="size_xs">XS</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="size[]" value="S" id="size_s" {{ in_array('S', $currentSizes) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="size_s">S</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="size[]" value="M" id="size_m" {{ in_array('M', $currentSizes) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="size_m">M</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="size[]" value="L" id="size_l" {{ in_array('L', $currentSizes) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="size_l">L</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="size[]" value="XL" id="size_xl" {{ in_array('XL', $currentSizes) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="size_xl">XL</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="size[]" value="XXL" id="size_xxl" {{ in_array('XXL', $currentSizes) ? 'checked' : '' }}>
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
                                               value="{{ old('outfit_type', $product->outfit_type) }}"
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
                                               value="{{ old('color', $product->color) }}"
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
                                                  placeholder="e.g., 100% Cotton, Polyester Blend">{{ old('fabric', $product->fabric) }}</textarea>
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
                                          placeholder="e.g., 1 x T-Shirt, 1 x Belt, 1 x Gift Box">{{ old('includes', $product->includes) }}</textarea>
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
                                          placeholder="Enter design details, patterns, or special features">{{ old('design_details', $product->design_details) }}</textarea>
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
                                          placeholder="e.g., Machine wash cold, Do not bleach, Hang dry">{{ old('care_instructions', $product->care_instructions) }}</textarea>
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
                                          placeholder="Enter any disclaimers or important notes">{{ old('disclaimer', $product->disclaimer) }}</textarea>
                                <small class="form-text text-muted">Any disclaimers or important information about the product</small>
                                @error('disclaimer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="youtube_link">YouTube Video Link</label>
                                @php
                                    $youtubeLink = old('youtube_link', $product->youtube_link);
                                    $youtubeVideoId = null;
                                    if ($youtubeLink) {
                                        // Extract YouTube video ID from various URL formats
                                        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/', $youtubeLink, $matches)) {
                                            $youtubeVideoId = $matches[1];
                                        }
                                    }
                                @endphp
                                @if($youtubeVideoId)
                                    <div class="mb-3">
                                        <label class="text-muted">Current Video Preview:</label>
                                        <div class="embed-responsive embed-responsive-16by9" style="max-width: 560px;">
                                            <iframe class="embed-responsive-item"
                                                    src="https://www.youtube.com/embed/{{ $youtubeVideoId }}"
                                                    frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                    allowfullscreen
                                                    style="width: 100%; height: 315px; border-radius: 4px;">
                                            </iframe>
                                        </div>
                                    </div>
                                @endif
                                <input type="url"
                                       class="form-control @error('youtube_link') is-invalid @enderror"
                                       id="youtube_link"
                                       name="youtube_link"
                                       value="{{ $youtubeLink }}"
                                       placeholder="https://www.youtube.com/watch?v=... or https://youtu.be/...">
                                <small class="form-text text-muted">Optional YouTube video link for the product (e.g., product demo, review, etc.)</small>
                                @error('youtube_link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div id="youtube-preview" class="mt-3" style="display: none;">
                                    <label class="text-muted">New Video Preview:</label>
                                    <div class="embed-responsive embed-responsive-16by9" style="max-width: 560px;">
                                        <iframe id="youtube-preview-iframe"
                                                class="embed-responsive-item"
                                                src=""
                                                frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen
                                                style="width: 100%; height: 315px; border-radius: 4px;">
                                        </iframe>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">
                            <h5 class="mb-3">SEO Settings</h5>

                            <div class="form-group">
                                <label for="meta_title">Meta Title</label>
                                <input type="text"
                                       class="form-control @error('meta_title') is-invalid @enderror"
                                       id="meta_title"
                                       name="meta_title"
                                       value="{{ old('meta_title', $product->meta_title) }}"
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
                                          maxlength="500">{{ old('meta_description', $product->meta_description) }}</textarea>
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
                                       value="{{ old('meta_keywords', $product->meta_keywords) }}"
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
                                       value="{{ old('meta_tags', $product->meta_tags) }}"
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
                                @if($product->image)
                                    <div class="mb-3">
                                        <img src="{{ asset($product->image) }}"
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
                                <small class="form-text text-muted">Upload new image to replace current one (JPG, PNG, GIF, WebP - Max: 2MB). Images will be automatically converted to WebP format.</small>
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

                            <div class="form-group">
                                <label>Existing Additional Images</label>
                                @if($product->images && $product->images->count() > 0)
                                    <div class="row mb-3">
                                        @foreach($product->images as $productImage)
                                            <div class="col-md-3 mb-3" id="image-{{ $productImage->id }}">
                                                <div class="position-relative">
                                                    <img src="{{ asset($productImage->image) }}"
                                                         alt="Product Image"
                                                         style="width: 100%; height: 150px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
                                                    <button type="button"
                                                            class="btn btn-sm btn-danger position-absolute"
                                                            style="top: 5px; right: 5px;"
                                                            onclick="deleteImage({{ $productImage->id }})"
                                                            title="Delete Image">
                                                        <i class="mdi mdi-delete"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted">No additional images</p>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="images">Add More Product Images</label>
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
                                @if($product->size_guide_image)
                                    <div class="mb-3">
                                        <img src="{{ asset($product->size_guide_image) }}"
                                             alt="Current Size Guide Image"
                                             style="max-width: 300px; max-height: 400px; border-radius: 4px; border: 1px solid #ddd;">
                                        <p class="text-muted mt-2">Current Size Guide Image</p>
                                    </div>
                                @endif
                                <input type="file"
                                       class="form-control-file @error('size_guide_image') is-invalid @enderror"
                                       id="size_guide_image"
                                       name="size_guide_image"
                                       accept="image/*">
                                <small class="form-text text-muted">Upload new size guide image to replace current one (JPG, PNG, GIF, WebP - Max: 2MB). Image will be automatically converted to WebP format.</small>
                                @error('size_guide_image')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div id="size-guide-preview" class="mt-3" style="display: none;">
                                    <img id="preview-size-guide-img" src="" alt="Size Guide Preview" style="max-width: 300px; max-height: 400px; border-radius: 4px; border: 1px solid #ddd;">
                                    <p class="text-muted mt-2">New Size Guide Image Preview</p>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.products.index') }}" class="btn btn-light mr-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-content-save"></i> Update Product
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

        // Delete product image
        function deleteImage(imageId) {
            if (confirm('Are you sure you want to delete this image?')) {
                fetch(`/admin/products/images/${imageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`image-${imageId}`).remove();
                    } else {
                        alert('Error deleting image');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting image');
                });
            }
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

        // YouTube link preview
        const youtubeInput = document.getElementById('youtube_link');
        const youtubePreview = document.getElementById('youtube-preview');
        const youtubePreviewIframe = document.getElementById('youtube-preview-iframe');

        function extractYouTubeId(url) {
            if (!url) return null;
            const regex = /(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/;
            const match = url.match(regex);
            return match ? match[1] : null;
        }

        if (youtubeInput && youtubePreview && youtubePreviewIframe) {
            youtubeInput.addEventListener('input', function(e) {
                const url = e.target.value;
                const videoId = extractYouTubeId(url);

                if (videoId) {
                    youtubePreviewIframe.src = 'https://www.youtube.com/embed/' + videoId;
                    youtubePreview.style.display = 'block';
                } else {
                    youtubePreview.style.display = 'none';
                    youtubePreviewIframe.src = '';
                }
            });
        }
    </script>
@endsection
