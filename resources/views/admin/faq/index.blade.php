@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Faq Table</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="card-title">Faq</h6>
                            <div class="create-button">
                                <a href="{{ route('admin.faq.create') }}" class="btn btn-primary btn-icon">
                                    <i data-feather="plus-circle"></i>
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Question</th>
                                        <th>Ans</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($faqs as $key => $faq)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $faq->question }}</td>
                                            <td>{{ Str::limit($faq->answer, 50) }}</td>
                                            <td>{{ $faq->category }}</td>

                                            <td>
                                                @if ($faq->status === 1)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-primary">De Active</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.faq.edit', $faq->id) }}"
                                                    class="btn btn-primary btn-icon">
                                                    <i data-feather="edit"></i>
                                                </a>

                                                @if (Auth::user()->role_id == 1)
                                                    <form id="delete_form_{{ $faq->id }}"
                                                        action="{{ route('admin.faq.destroy', $faq->id) }}" method="post"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-icon delete-button"
                                                            onclick="deleteId({{ $faq->id }})">
                                                            <i data-feather="trash"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
