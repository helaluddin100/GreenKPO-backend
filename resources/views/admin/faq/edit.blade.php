@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Forms</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Faq</li>
            </ol>
        </nav>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12 col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create Faq</h4>

                        <form action="{{ route('admin.faq.update', $faq->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Category</label>
                                        <select class="js-example-basic-single form-select" name="category"
                                            data-width="100%">
                                            <option value="Carbon Democratisation"
                                                {{ $faq->category == 'Carbon Democratisation' ? 'selected' : '' }}>Carbon
                                                Democratisation</option>
                                            <option value="Why should I consider Green KPO?"
                                                {{ $faq->category == 'Why should I consider Green KPO?' ? 'selected' : '' }}>
                                                Why should I consider Green KPO?</option>
                                            <option value="Product" {{ $faq->category == 'Product' ? 'selected' : '' }}>
                                                Product</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="question" class="form-label">Question</label>
                                        <input id="question" class="form-control" name="question" type="text"
                                            value="{{ $faq->question }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="answer" class="form-label">Answer</label>
                                        <textarea id="answer" class="form-control" name="answer" type="text" rows="5">{{ $faq->answer }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <label class="form-check-label" for="termsCheck">
                                        Active
                                    </label>
                                    <input type="checkbox" class="form-check-input"
                                        @if ($faq->status) checked @endif name="status" id="termsCheck">
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
