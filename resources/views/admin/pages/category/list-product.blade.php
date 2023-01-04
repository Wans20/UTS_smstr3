@extends('admin.layouts.index')
@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
          <br>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                              @section('content')
                              <h3>Category : {{ $category->name }}</h3>
                              <h5>All Products : {{ count($category->products) }}</h5>
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">NO</th>
                                            <th scope="col">Product Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>@foreach ($category->products as $product)
                                      <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $product->title }}</td>
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