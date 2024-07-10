@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Settings Table</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="card-title">Settings</h6>
                            <div class="create-button">
                                <a href="{{ route('admin.settings.create') }}" class="btn btn-primary btn-icon">
                                    <i data-feather="plus-circle"></i>
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Title 2</th>
                                        <th>Description</th>
                                        <th>Right</th>
                                        <th>Left</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($setting)
                                        <tr>
                                            <td>{{ $setting->banner_title_a }}</td>
                                            <td>{{ $setting->banner_title_b }}</td>
                                            <td>{{ Str::limit($setting->banner_description, 50) }}</td>
                                            <td><img src="{{ asset($setting->right_image) }}" alt=""></td>
                                            <td><img src="{{ asset($setting->left_image) }}" alt=""></td>
                                            <td>
                                                <a href="{{ route('admin.settings.edit', $setting->id) }}"
                                                    class="btn btn-primary btn-icon">
                                                    <i data-feather="edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="7">No settings found.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
