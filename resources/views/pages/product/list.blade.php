@extends('layouts.dashboard')
@section('content')

<br>

@if ($message = Session::get('notif'))
    <div class="alert alert-primary  alert-dismissible fade show" role="alert">
      <strong>{{ $message }}</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<H1>List Product</H1>
<a href="/product/create" class="btn btn-primary mb-3">Input</a>
<form class="row g-3" action="  " method="GET">
  <div class="col-auto">
    <select class="form-select" name="filter" id="filter">
      <option value="">All</option>
      @foreach ($categories as $category)
      <option value="{{ $category->id }}" {{ request('filter') == $category->id?'selected':'' }}>{{ $category->name }}</option>
      @endforeach
    </select>
  </div>

  <div class="col-auto">
    <label for="search" class="visually-hidden"></label>
    <input type="text" name="search" value="{{ request('search') }}" class="form-control" id="search" placeholder="Search">
  </div>
  <div class="col-auto">
    <button type="submit" class="btn btn-primary mb-3">Search</button>
  </div>

</form>
<table class="table table-striped table-hover">
    <thead class="table-dark">
      <tr>
        <th scope="col">No</th>
        <th scope="col">Title</th>
        <th scope="col">Description</th>
        <th scope="col">Status</th>
        <th scope="col">Price</th>
        <th scope="col">Weight</th>
        <th scope="col">Category</th>
        <th scope="col">Image</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
            {{-- urutan manual --}}
            {{-- <th scope="row">{{ $loop->iteration }}</th> --}}
            
            {{-- urutan angka sesuai page --}}
            <th scope="row">{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</th>
                <td>{{ $item->title }}</td>
                <td>{{ $item->description }}</td>
                <td>
                  @if ($item->status == 'active')
                    <h5><span class="badge bg-success">{{ $item->status }}</span></h5>
                  @elseif ($item->status == 'active')
                    <h5><span class="badge bg-warning">{{ $item->status }}</span></h5>
                  @else
                    <h5><span class="badge bg-danger">{{ $item->status }}</span></h5>
                  @endif
                </td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->weight }}</td>
                <td>{{ $item->category->name }}</td>
                <td><img src="/storage/{{ $item->image }}" alt="" width="100px" height="100px" class="img-thumbnail"></td>
                <td>
                  <a href="{{ route('product.edit', ['product' => $item->id]) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('product.destroy', ['product' =>$item->id]) }}" class="d-inline" method="POST">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
  </table>
  {{-- memberu tampilan next privious --}}
{{ $data->withQueryString()->links()}}
@endsection