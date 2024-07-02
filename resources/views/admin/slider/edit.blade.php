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

                        <form action="{{ route('admin.slider.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" id="title" class="form-control" name="title" value="{{ $slider->title }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="small_title" class="form-label">Small Title</label>
                                        <input type="text" id="small_title" class="form-control" name="small_title" value="{{ $slider->small_title }}">
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
                                        <label for="mobile_image" class="form-label">Mobile Image</label>
                                        <input type="file" id="mobile_image" class="form-control" name="mobile_image"
                                            onchange="previewImage(event)">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <img src="{{ asset($slider->image) }}" alt="Selected Image"
                                            style="max-width: 100px; display: {{ $slider->image ? 'block' : 'none' }};">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <img  src="{{ asset($slider->mobile_image) }}" alt="Selected Image"
                                            style="max-width: 100px; display: {{ $slider->mobile_image ? 'block' : 'none' }};">
                                    </div>
                                </div>
                            </div>


                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" {{ $slider->status ? 'checked' : '' }}
                                        name="status" id="termsCheck">
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
