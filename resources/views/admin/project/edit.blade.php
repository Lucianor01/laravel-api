@extends('layouts.app')

@section('title')
    Project | Edit
@endsection

@section('content')
    <div class="container">
        <h1 class="text-center mt-3 text-uppercase">Edit Project</h1>

        {{-- VALIDATION ERRORS LISTS --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ! FORM --}}
        <form action="{{ route('admin.project.update', $project) }}" method="POST" enctype="multipart/form-data">

            @csrf

            @method('PUT')
            {{-- ? INPUT TITLE --}}
            <div class="mb-3">
                <label for="project-title" class="form-label">Title</label>
                <input type="text" class="form-control" name="title" id="project-title" aria-describedby="helpId"
                    value="{{ old('title') ?? $project->title }}">
                @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            {{-- ? INPUT DESCRIPTION --}}
            <div class="mb-3">
                <label for="project-description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="project-description" rows="3">{{ old('description') ?? $project->description }}</textarea>
                @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            {{-- ? INPUT PRICE --}}
            <div class="mb-3">
                <label for="project-price" class="form-label">Price</label>
                <input type="number" class="form-control" name="price" step="0.01" id="project-price"
                    aria-describedby="helpId" value="{{ old('price') ?? $project->price }}">
                @error('price')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            {{-- ? INPUT FILE --}}
            <div class="mb-3">
                <label for="project-image" class="form-label">Project Image</label>
                <input type="file" class="form-control" name="project_image" id="project-image"
                    aria-describedby="helpId">
                @error('project_image')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            {{-- ? CICLO SELECT TYPES --}}
            <div class="mb-3">
                <label for="project-types" class="form-label">Types</label>
                <select class="form-select form-select-lg @error('type_id') is-invalid @enderror" name="type_id"
                    id="project-types">
                    <option value="">-- Choose a category --</option>
                    @foreach ($types as $elem)
                        <option value="{{ $elem->id }}"
                            {{ old('type_id', $project->type_id) == $elem->id ? 'selected' : '' }}>{{ $elem->name }}
                        </option>
                    @endforeach
                </select>
                @error('type_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- ? TECHNOLOGIES CHECKBOX --}}
            <div class="mb-3 mt-4">
                <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                    @foreach ($technologies as $item)
                        @if ($errors->any())
                            <input type="checkbox" class="btn-check" name="technologies[]" value="{{ $item->id }}"
                                id="project-checkbox-{{ $item->id }}"
                                {{ in_array($item->id, old('technologies', [])) ? 'checked' : '' }}>
                        @else
                            <input type="checkbox" class="btn-check" name="technologies[]" value="{{ $item->id }}"
                                id="project-checkbox-{{ $item->id }}"
                                {{ $project->technologies->contains($item) ? 'checked' : '' }}>
                        @endif
                        <label class="btn btn-outline-primary"
                            for="project-checkbox-{{ $item->id }}">{{ $item->name }}</label>
                    @endforeach
                </div>
                @error('technologies')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Confirm Edit</button>
        </form>
    </div>
@endsection
