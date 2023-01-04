@extends('layouts.dashboard')
@section('content')

    <h3>{{ $product->id ? 'Form Edit' : 'Form Create' }}</h3>

    @if ($product->id)
        <form action="{{ route('product.update', ['product' => $product->id]) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
        @else
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
    @endif
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Form Product</label>
        <input type="text" class="form-control" name="title" id="title" value="{{ $product->title }}">
        @error('title')
            <div class="text-muted text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="gender" class="form-label">Status</label>
        <select name="status" class="form-control" id="status">
            <option disabled selected>--- Choose Your Status ---</option>
            <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive"{{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            <option value="draft"{{ $product->status == 'draft' ? 'selected' : '' }}>Draft</option>
        </select>
        @error('status')
            <div class="text-muted text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" cols="10" rows="5" class="form-control">{{ $product->description }}</textarea>
        @error('description')
            <div class="text-muted text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <select name="category_id" class="form-control" id="category_id">
            <option selected disabled>--- Choose Your Major ---</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? ' selected' : '' }}>
                    {{ $category->name }}</option>
            @endforeach
        </select>
        @error('address')
            <div class="text-muted text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="weight" class="form-label">Weight</label>
        <input type="text" class="form-control" name="weight" id="weight" value="{{ $product->weight }}">
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="text" class="form-control" name="price" id="price" value="{{ $product->price }}">
    </div>
    @error('price')
        <div class="text-muted text-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" name="image" class="form-control" id="image">
        <img src="/storage/{{ $product->image }}" class="img-thumbnail" width="200px" height="200px">
    </div>
    @error('image')
        <div class="text-muted text-danger">{{ $message }}</div>
    @enderror

    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
