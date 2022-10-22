@extends('layouts.dashboard')
@section('content') 

<h3>{{ $student->id ? 'Form Edit' : 'Form Create' }}</h3>

@if($student->id)
    <form action="{{ route('student.update' , ['student' => $student->id]) }}" method="POST" enctype="multipart/form-data">
    @method('PUT')
@else
      <form action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data">
@endif
    @csrf
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control" name="name" value="{{ $student->name }}">
      @error('name') <div class="text-muted text-danger">{{$message}}</div> @enderror
    </div>

    <div class="mb-3">
        <label for="gender" class="form-label">Gender</label>
        <select name="gender" class="form-select">
            <option disabled selected>--- Choose Your Gender ---</option>
            <option value="male" {{ $student->gender == 'male' ? 'selected' : ''}}>Male</option>
            <option value="female"{{ $student->gender == 'female' ? 'selected' : ''}}>Female</option>
        </select>
        @error('gender') <div class="text-muted text-danger">{{$message}}</div> @enderror
    </div>

    <div class="mb-3">
        <label for="date" class="form-label">Date-Birth</label>
        <input type="date" class="form-control" name="date_birth" value="{{ $student->date_birth }}">
        @error('date_birth') <div class="text-muted text-danger">{{$message}}</div> @enderror
      </div>

    <div class="mb-3">
      <label for="address" class="form-label">Address</label>
      <textarea type="text" class="form-control" name="address">{{ $student->address }}</textarea>
      @error('address') <div class="text-muted text-danger">{{$message}}</div> @enderror
    </div>

    <div class="mb-3">
      <label for="major" class="form-label">Major</label>
      <select name="major_id" class="form-select">
        <option disabled selected>--- Choose Your Major ---</option>
        @foreach ($majors as $major)
          <option value="{{ $major->id }}">{{ $major->name }}</option>
        @endforeach
      </select>
      @error('major') <div class="text-muted text-danger">{{$message}}</div> @enderror
    </div>
    <div class="mb-3">
      <label for="image" class="form-label">Image</label>
      @if ($student->image != null)
        <br><img src="/storage/{{ $student->image }}" alt="" width="100px">
        
      @endif
      <input type="file" class="form-control" name="image">
      @error('image') <div class="text-muted text-danger">{{$message}}</div> @enderror
    </div>
    
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
  
@endsection
{{-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  Hello world!
</body>
</html> --}}