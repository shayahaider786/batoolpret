@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Edit Testimonial</h4>
                            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary btn-sm">
                                <i class="mdi mdi-arrow-left"></i> Back to Testimonials
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

                        <form action="{{ route('admin.testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">Name / Title <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name', $testimonial->name) }}"
                                       placeholder="e.g., Rimsha, Jharna K., Maham F."
                                       required>
                                <small class="form-text text-muted">Enter the customer's name</small>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">Customer Image</label>
                                        @if($testimonial->image)
                                            <div class="mb-2">
                                                <img src="{{ asset($testimonial->image) }}" alt="Current Image" style="max-width: 200px; max-height: 200px; object-fit: cover;">
                                                <p class="text-muted small mt-1">Current Image</p>
                                            </div>
                                        @endif
                                        <input type="file"
                                               class="form-control-file @error('image') is-invalid @enderror"
                                               id="image"
                                               name="image"
                                               accept="image/*">
                                        <small class="form-text text-muted">Upload new customer photo to replace (JPG, PNG, GIF - Max: 2MB)</small>
                                        @error('image')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="video">Video Testimonial</label>
                                        @if($testimonial->video)
                                            <div class="mb-2">
                                                <video width="200" height="150" controls>
                                                    <source src="{{ asset($testimonial->video) }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                                <p class="text-muted small mt-1">Current Video</p>
                                            </div>
                                        @endif
                                        <input type="file"
                                               class="form-control-file @error('video') is-invalid @enderror"
                                               id="video"
                                               name="video"
                                               accept="video/*">
                                        <small class="form-text text-muted">Upload new video to replace (MP4, MOV, AVI - Max: 50MB)</small>
                                        @error('video')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="rating">Rating <span class="text-danger">*</span></label>
                                <select class="form-control @error('rating') is-invalid @enderror"
                                        id="rating"
                                        name="rating"
                                        required>
                                    <option value="">Select Rating</option>
                                    @for($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}" {{ old('rating', $testimonial->rating) == $i ? 'selected' : '' }}>
                                            {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                        </option>
                                    @endfor
                                </select>
                                <small class="form-text text-muted">Select rating from 1 to 5 stars</small>
                                @error('rating')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Description / Review Text <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description"
                                          name="description"
                                          rows="5"
                                          placeholder="Enter the testimonial description/review text"
                                          maxlength="1000"
                                          required>{{ old('description', $testimonial->description) }}</textarea>
                                <small class="form-text text-muted">Enter the testimonial text (Max: 1000 characters)</small>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select class="form-control @error('status') is-invalid @enderror"
                                                id="status"
                                                name="status"
                                                required>
                                            <option value="active" {{ old('status', $testimonial->status) === 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status', $testimonial->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        <small class="form-text text-muted">Only active testimonials will be displayed on the frontend</small>
                                        @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="order">Order</label>
                                        <input type="number"
                                               class="form-control @error('order') is-invalid @enderror"
                                               id="order"
                                               name="order"
                                               value="{{ old('order', $testimonial->order) }}"
                                               min="0"
                                               placeholder="0">
                                        <small class="form-text text-muted">Lower numbers appear first (optional, default: 0)</small>
                                        @error('order')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-light mr-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-content-save"></i> Update Testimonial
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
