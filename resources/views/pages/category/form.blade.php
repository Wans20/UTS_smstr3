@extends('layouts.dashboard')
@section('content') 

<br>
<h3>{{ $category->id ? 'Form Edit' : 'Form Create' }}</h3>

@if($category->id)
    <form action="{{ route('category.update' , ['category' => $category->id]) }}" method="POST">
    @method('PUT')
@else
      <form action="{{ route('category.store') }}" method="POST">
@endif
    @csrf
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control" name="name" value="{{ $category->name }}">
      @error('name') <div class="text-muted text-danger">{{$message}}</div> @enderror
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea type="text" class="form-control" name="description">{{ $category->description }}</textarea>
      @error('description') <div class="text-muted text-danger">{{$message}}</div> @enderror
    </div>

    <select name="status" id="status" class="form-select mb-2">
      <option value="active">active</option>
      <option value="inactive">inactive</option>
    </select>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
@endsection