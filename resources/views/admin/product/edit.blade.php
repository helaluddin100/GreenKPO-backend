@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Forms</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Post</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-12 col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Meta Information</h4>

                        <form action="{{ route('admin.product.update', $product->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="meta_title" class="form-label">Meta Title</label>
                                        <input type="text" id="meta_title" class="form-control" name="meta_title"
                                            value="{{ old('meta_title', $product->meta_title) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="meta_keyword" class="form-label">Meta Keyword</label>
                                        <input type="text" id="meta_keyword" class="form-control" name="meta_keyword"
                                            value="{{ old('meta_keyword', $product->meta_keyword) }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="meta_description" class="form-label">Meta Description</label>
                                        <textarea id="meta_description" class="form-control" name="meta_description" rows="3">{{ old('meta_description', $product->meta_description) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <br>
                            <h4 class="card-title">Product Information</h4>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" id="name" class="form-control" name="name"
                                            value="{{ old('name', $product->name) }}">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div id="feature-list-container">
                                        @if (!empty($product->feature_list) && is_array($product->feature_list))
                                            @foreach ($product->feature_list as $key => $feature)
                                                <div class="input-row mb-3" data-can-delete="true">
                                                    <label for="feature_list_{{ $key }}" class="form-label">Feature
                                                        List</label>
                                                    <input type="text" id="feature_list_{{ $key }}"
                                                        class="form-control" name="feature_list[]"
                                                        value="{{ old('feature_list.' . $key, $feature) }}"required>
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm delete-feature-btn mt-2">Delete</button>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="input-row mb-3" data-can-delete="false">
                                                <label for="feature_list_0" class="form-label">Feature List</label>
                                                <input type="text" id="feature_list_0" class="form-control"
                                                    name="feature_list[]" value="{{ old('feature_list.0') }}"required>
                                            </div>
                                        @endif
                                    </div>
                                    <button id="add-feature-btn" type="button" class="btn btn-primary my-3">Add New
                                        Feature</button>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="small_description" class="form-label">Small Description</label>
                                        <textarea id="small_description" class="form-control" name="small_description" rows="3">{{ old('small_description', $product->small_description) }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Image</label>
                                        <input type="file" id="image" class="form-control" name="image"
                                            onchange="previewImage(event)">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        @if ($product->image)
                                            <img id="imagePreview" src="{{ asset($product->image) }}" alt="Selected Image"
                                                style="max-width: 100px;">
                                        @else
                                            <img id="imagePreview" src="#" alt="Selected Image"
                                                style="max-width: 100px; display: none;">
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-xl-12 col-lg-12 col-12 form-group">
                                        <label for="des">Description *</label>
                                        <textarea name="description" id="open-source-plugins" class="form-control" cols="30" rows="10">{{ old('description', $product->description) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="status" id="termsCheck"
                                        {{ $product->status ? 'checked' : '' }}>
                                    <label class="form-check-label" for="termsCheck">
                                        Active
                                    </label>
                                </div>
                            </div>
                            <input class="btn btn-primary" type="submit" value="Update">
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('feature-list-container');

            // Add new input row
            document.getElementById('add-feature-btn').addEventListener('click', function() {
                const inputRow = document.createElement('div');
                const key = container.querySelectorAll('.input-row').length; // Calculate new key
                inputRow.classList.add('input-row', 'mb-3');
                inputRow.setAttribute('data-can-delete', 'true');
                inputRow.innerHTML = `
                <label for="feature_list_${key}" class="form-label mt-3">Feature List</label>
                <input type="text" id="feature_list_${key}" class="form-control" name="feature_list[]"required>
                <button type="button" class="btn btn-danger btn-sm delete-feature-btn mt-2">Delete</button>
            `;
                container.appendChild(inputRow);
            });

            // Handle deletion of feature list items
            container.addEventListener('click', function(event) {
                if (event.target.classList.contains('delete-feature-btn')) {
                    const inputRows = container.querySelectorAll('.input-row');
                    if (inputRows.length > 1) {
                        event.target.closest('.input-row').remove();
                    } else {
                        alert('At least one feature must be present.');
                    }
                }
            });
        });
    </script>
@endsection
