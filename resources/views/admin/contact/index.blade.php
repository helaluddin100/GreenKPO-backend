@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Contact Table</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="card-title">Contact</h6>
                            <div class="create-button">
                                <a href="{{ route('admin.contact.create') }}" class="btn btn-primary btn-icon">
                                    <i data-feather="plus-circle"></i>
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Message</th>
                                        <th>Date</th>

                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($contacts as $key => $contact)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
                                            <td>{{ $contact->email }}</td>
                                            <td>{{ Str::limit($contact->message, 100) }}</td>
                                            <td>{{ $contact->created_at->format('M d Y, H:i') }}</td>

                                            <td>
                                                @if ($contact->status === 0)
                                                    <span class="badge bg-primary">UnRead</span>
                                                @else
                                                    <span class="badge bg-success">Read</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.contact.show', $contact->id) }}"
                                                    class="btn btn-primary btn-icon">
                                                    <i data-feather="eye"></i>
                                                </a>

                                                @if (Auth::user()->role_id == 1)
                                                    <form id="delete_form_{{ $contact->id }}"
                                                        action="{{ route('admin.contact.destroy', $contact->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-icon delete-button"
                                                            onclick="deleteId({{ $contact->id }})">
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
