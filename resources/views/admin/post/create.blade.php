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

                        <form action="{{ route('admin.post.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

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
                                        <label for="meta_descriptions" class="form-label">Meta Description</label>
                                        <textarea id="meta_descriptions" class="form-control" name="meta_descriptions" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <br>
                            <h4 class="card-title">Post Information</h4>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" id="title" class="form-control" name="title">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tag_id" class="form-label">Tag</label>
                                        <select id="tag_id" name="tag_id[]" class="js-example-basic-multiple form-select"
                                            multiple="multiple" data-width="100%">
                                            @foreach ($tags as $tag)
                                                <option value="{{ $tag->id }}">
                                                    {{ $tag->name }}
                                                </option>
                                            @endforeach

                                        </select>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="read_time" class="form-label">Read Time</label>
                                        <input type="text" id="read_time" class="form-control" name="read_time">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Category</label>
                                        <input type="text" id="category" class="form-control" name="category">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="small_title" class="form-label">Small Description</label>
                                        <textarea id="small_title" class="form-control" name="small_title" rows="3"></textarea>
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
                                    <label class="form-check-label" for="termsCheck">
                                        Active
                                    </label>
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
