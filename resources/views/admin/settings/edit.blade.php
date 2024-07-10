@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Forms</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit settings</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-12 col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Meta Information</h4>

                        <form action="{{ route('admin.settings.update', $setting->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="banner_title_a" class="form-label">Title 1</label>
                                        <input type="text" id="banner_title_a" class="form-control"
                                            value="{{ $setting->banner_title_a }}" name="banner_title_a">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="banner_title_b" class="form-label">Title 2</label>
                                        <input type="text" id="banner_title_b" class="form-control"
                                            value="{{ $setting->banner_title_b }}" name="banner_title_b">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="right_image" class="form-label">Right Image</label>
                                        <input type="file" id="right_image" class="form-control" name="right_image">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="left_image" class="form-label">Left Image</label>
                                        <input type="file" id="left_image" class="form-control" name="left_image">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <img id="imagePreview" src="{{ asset($setting->right_image) }}" alt="Selected Image"
                                            style="max-width: 100px;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <img src="{{ asset($setting->left_image) }}" alt="Selected Image"
                                            style="max-width: 100px;">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="home_video" class="form-label">Home Video (Embed code)</label>
                                        <textarea id="home_video" class="form-control" name="home_video" rows="3">{{ $setting->home_video }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="banner_description" class="form-label">Small Description</label>
                                        <textarea id="banner_description" class="form-control" name="banner_description" rows="3">{{ $setting->banner_description }}</textarea>
                                    </div>
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
