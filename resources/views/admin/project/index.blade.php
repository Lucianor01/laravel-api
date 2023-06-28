@extends('layouts.app')

@section('title')
    Project
@endsection

@section('content')
    <h1 class="text-center mt-3 text-uppercase">My Project</h1>

    {{-- ! ALERT EDIT PROJECT --}}
    <div class="container">
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3">
                <strong>{!! Session::get('success') !!}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="container">
        <div class="row row-gap-4">
            @forelse ($project as $item)
                <div class="col-3">
                    <a class="text-decoration-none text-reset" href="{{ route('admin.project.show', $item) }}">
                        <div class="card h-100">
                            <img class="card-img-top" src="{{ asset('storage/' . $item->project_image) }}"
                                alt="{{ $item->title }}">
                            <div class="card-body">
                                <h4 class="card-title text-uppercase">{{ $item->title }}</h4>
                                <p class="card-text"><strong>Description:</strong> {{ $item->description }}</p>
                                <p class="card-text"><strong>Price:</strong> {{ $item->price }}&euro;</p>
                                @if ($item->type)
                                    <p class="card-text"><strong>Type:</strong> {{ $item->type->name }}</p>
                                @endif
                                <div class="d-flex mb-5 mt-3">
                                    <a class="m-auto btn btn-success"
                                        href="{{ route('admin.project.edit', $item) }}">Edit</a>
                                    <form class="m-auto" action="{{ route('admin.project.destroy', $item) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Are you sure you want to delete the project?')"
                                            type="submit" class="btn btn-outline-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <h2>There are no Projects!!</h2>
            @endforelse
        </div>
        <div>
            <a class="btn btn-success d-table m-auto mt-5" href="{{ route('admin.project.create') }}">Create Project</a>
        </div>
    </div>
@endsection
