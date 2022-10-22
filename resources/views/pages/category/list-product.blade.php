@extends('layouts.dashboard')

@section('content')
<h3>Category {{ $category->name }}</h3>
{{-- fungsi count dari php asli --}}
<h5>All Students : {{ count($category->products) }}</h5>
{{-- fungsi count dari laravel --}}
{{-- <p>Jumlah Siswa : {{ $major->students->count() }}</p> --}}
<table class="table table-striped table-hover">
    <thead class="table-dark">
      <tr>
        <th scope="col">No</th>
        <th scope="col">Products Name</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($category->products as $prooduct)
            <tr>
              <th scope="row">{{ $loop->iteration }}</th>
              <td>{{ $product->name }}</td>
            </tr>
        @endforeach
    </tbody>
  </table>
@endsection