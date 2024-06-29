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

@section('js')
    <script src="https://cdn.tiny.cloud/1/qagffr3pkuv17a8on1afax661irst1hbr4e6tbv888sz91jc/tinymce/5/tinymce.min.js">
    </script>

    <style>
        .progress-wrapper {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50%;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            z-index: 9999;
        }

        .progress-bar {
            width: 0;
            height: 30px;
            background-color: green;
            margin-top: 10px;
            border-radius: 5px;
        }
    </style>

    <div id="progressWrapper" class="progress-wrapper">
        <div id="progressText">Uploading...</div>
        <div class="progress-bar" id="progressBar"></div>
    </div>

    <script>
        const useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;

        tinymce.init({
            selector: 'textarea#open-source-plugins',
            plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
            editimage_cors_hosts: ['picsum.photos'],
            menubar: 'file edit view insert format tools table help',
            toolbar: "undo redo | bold italic underline strikethrough | align numlist bullist | link image media | forecolor backcolor removeformat | code fullscreen preview",
            autosave_ask_before_unload: true,
            autosave_interval: '30s',
            autosave_prefix: '{path}{query}-{id}-',
            autosave_restore_when_empty: false,
            autosave_retention: '2m',
            image_advtab: true,
            file_picker_callback: function(callback, value, meta) {
                if (meta.filetype === 'image') {
                    const input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.onchange = function() {
                        const file = this.files[0];
                        const formData = new FormData();
                        formData.append('file', file);

                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', '{{ route('admin.upload.image') }}', true); // Use the named route
                        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

                        xhr.upload.addEventListener('progress', function(e) {
                            if (e.lengthComputable) {
                                const percentComplete = (e.loaded / e.total) * 100;
                                document.getElementById('progressWrapper').style.display = 'block';
                                document.getElementById('progressBar').style.width =
                                    percentComplete + '%';
                                document.getElementById('progressText').innerText = 'Uploading: ' +
                                    Math.round(percentComplete) + '%';
                            }
                        }, false);

                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                const data = JSON.parse(xhr.responseText);
                                callback(data.location, {
                                    alt: file.name
                                });
                                document.getElementById('progressWrapper').style.display = 'none';
                                document.getElementById('progressText').innerText = 'Uploading...';
                                document.getElementById('progressBar').style.width = '0%';
                            } else {
                                console.error('Upload failed');
                            }
                        };

                        xhr.send(formData);
                    };

                    input.click();
                }
            },
            height: 600,
            image_caption: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            noneditable_class: 'mceNonEditable',
            toolbar_mode: 'sliding',
            contextmenu: 'link image table',
            skin: useDarkMode ? 'oxide-dark' : 'oxide',
            content_css: useDarkMode ? 'dark' : 'default',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
        });

        function previewImage(event) {
            var output = document.getElementById('imagePreview');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.style.display = 'block';
        }
    </script>
@endsection
