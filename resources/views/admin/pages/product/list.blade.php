@extends('admin.layouts.index')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>DataTables</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">DataTables</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <H1>List Category Product</H1>
                                <a href="/category/create" class="btn btn-primary mb-3">Input</a>
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
                                              <th scope="row">{{ $loop->iteration }}</th>
                          
                                              {{-- urutan angka sesuai page --}}
                                              {{-- <th scope="row">{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</th> --}}
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
                                              <td>{{ $item->category->name ?? 'none'}}</td>
                                              <td><img src="/storage/{{ $item->image }}" alt="" width="100px" height="100px"
                                                      class="img-thumbnail"></td>
                                              <td>
                                                  <a href="{{ route('product.edit', ['product' => $item->id]) }}" class="btn btn-primary">Edit</a>
                                                  <form action="{{ route('product.destroy', ['product' => $item->id]) }}" class="d-inline"
                                                      method="POST">
                                                      @method('delete')
                                                      @csrf
                                                      <button type="submit" class="btn btn-danger">Delete</button>
                                                  </form>
                                              </td>
                                          </tr>
                                      @endforeach
                                  </tbody>
                              </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection