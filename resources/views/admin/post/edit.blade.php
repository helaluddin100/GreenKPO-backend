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
                                    <select id="tag_id" name="tag_id[]" class="js-example-basic-multiple form-select" multiple="multiple" data-width="100%">
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
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
                                    <input type="file" id="image" class="form-control" name="image" onchange="previewImage(event)">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <img id="imagePreview" src="#" alt="Selected Image" style="max-width: 100px; display: none;">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-xl-12 col-lg-12 col-12 form-group">
                                    <label for="des">Description *</label>
                                    <textarea name="description" id="editor" class="form-control" cols="30" rows="10"></textarea>
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

@section('js')
<script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            ckfinder: {
                uploadUrl: '{{ route('admin.upload') . '?_token=' . csrf_token() }}'
            },
            toolbar: [
                'heading', '|', 
                'bold', 'italic', 'underline', 'link', '|',
                'bulletedList', 'numberedList', 'blockQuote', '|',
                'insertTable', 'mediaEmbed', '|',
                'undo', 'redo', '|',
                'imageUpload', 'imageResize', 'imageStyle:inline', 'imageStyle:block', 'imageStyle:side'
            ],
            image: {
                toolbar: [
                    'imageTextAlternative', 'imageStyle:inline', 'imageStyle:block', 'imageStyle:side', '|',
                    'imageResize'
                ],
                styles: [
                    'inline', 'block', 'side'
                ],
                resizeOptions: [
                    {
                        name: 'resizeImage:original',
                        value: null,
                        label: 'Original',
                        icon: 'original'
                    },
                    {
                        name: 'resizeImage:50',
                        value: '50',
                        label: '50%',
                        icon: 'medium'
                    },
                    {
                        name: 'resizeImage:75',
                        value: '75',
                        label: '75%',
                        icon: 'large'
                    }
                ],
                upload: {
                    types: [ 'jpg', 'jpeg', 'png', 'gif', 'svg' ]
                }
            },
        })
        .catch(error => {
            console.error(error);
        });

    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('imagePreview');
            output.src = reader.result;
            output.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

@endsection
