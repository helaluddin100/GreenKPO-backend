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

                        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Meta Information -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="meta_title" class="form-label">Meta Title</label>
                                        <input type="text" id="meta_title" class="form-control" name="meta_title">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="meta_keyword" class="form-label">Meta Keyword</label>
                                        <input type="text" id="meta_keyword" class="form-control" name="meta_keyword">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="meta_description" class="form-label">Meta Description</label>
                                        <textarea id="meta_description" class="form-control" name="meta_description" rows="3"></textarea>
                                    </div>
                                </div>

                                <!-- Product Information -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" id="name" class="form-control" name="name">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div id="input-container">
                                        <div class="input-row">
                                            <label for="feature_list" class="form-label">Feature List</label>
                                            <input type="text" id="feature_list" class="form-control"
                                                name="feature_list[]"required>
                                            <button type="button"
                                                class="btn btn-danger btn-sm delete-feature-btn mt-2">Delete</button>
                                        </div>
                                    </div>
                                    <button id="add-input-btn" type="button" class="btn btn-primary my-3">Add New
                                        Input</button>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="small_description" class="form-label">Small Description</label>
                                        <textarea id="small_description" class="form-control" name="small_description" rows="3"></textarea>
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
                                        <img id="imagePreview" src="#" alt="Selected Image"
                                            style="max-width: 100px; display: none;">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-xl-12 col-lg-12 col-12 form-group">
                                        <label for="des">Description *</label>
                                        <textarea name="description" id="open-source-plugins" class="form-control" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" checked name="status" id="termsCheck">
                                    <label class="form-check-label" for="termsCheck">Active</label>
                                </div>
                            </div>
                            <input class="btn btn-primary" type="submit" value="Submit">
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script>
        document.getElementById('add-input-btn').addEventListener('click', function() {
            var container = document.getElementById('input-container');
            var newInputRow = document.createElement('div');
            newInputRow.className = 'input-row';
            newInputRow.innerHTML = `
        <label for="feature_list" class="form-label mt-3">Feature List</label>
        <input type="text" class="form-control" name="feature_list[]" required>
        <button type="button" class="btn btn-danger btn-sm delete-feature-btn mt-2">Delete</button>
    `;
            container.appendChild(newInputRow);

            // Add event listener to the new delete button
            newInputRow.querySelector('.delete-feature-btn').addEventListener('click', function() {
                deleteFeature(this);
            });
        });

        function deleteFeature(button) {
            var container = document.getElementById('input-container');
            var inputRows = container.getElementsByClassName('input-row');

            if (inputRows.length > 1) {
                button.parentNode.remove();
            } else {
                alert('At least one feature list input must be present.');
            }
        }

        // Add event listener to existing delete buttons
        document.querySelectorAll('.delete-feature-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                deleteFeature(this);
            });
        });
    </script>
@endsection
