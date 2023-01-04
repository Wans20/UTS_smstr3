@extends('admin.layouts.index')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>MY CHART</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">General Form</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">My Charts</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>QTY</th>
                                <th>Total</th>
                                <th>Image</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['products'] as $product)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $product['id'] }}</td>
                                    @foreach ($products as $p)
                                        @if ($p['id'] == $product['id'])
                                            <td>{{ $p['title'] }}</td>
                                        @endif
                                    @endforeach
                                    <td>{{ $product['qty'] }}</td>
                                    @foreach ($products as $p)
                                        @if ($p['id'] == $product['id'])
                                            <td>{{ $p['price'] * $product['qty'] }}</td>
                                            <td>Gambar</td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>QTY</th>
                                <th>Total</th>
                                <th>Image</th>
                            </tr>
                        </tfoot>
                    </table>
                    <br>
                    <h5>Total Harga : Rp. {{ $totalPrice }}</h5>
                </div>
                <!-- /.card-body -->
                <div class="card-body">
                    <div class="form-group">
                        <form action="{{ route('checkout.store') }}" method="POST">
                            @csrf
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" class="form-control" placeholder="Enter name" name="customer_name"
                                value="">
                            @error('name')
                                <div class="text-muted text-danger">{{ $message }}</div>
                            @enderror
                            @foreach ($data['products'] as $product)
                                <input type="hidden" name="product_id[]" value="{{ $product['id'] }}">
                                <input type="hidden" name="qty[]" value="{{ $product['qty'] }}">
                                @foreach ($products as $p)
                                    <input type="hidden" name="price[]" value="{{ $p['price'] * $product['qty'] }}">
                                @endforeach
                            @endforeach
                            <input type="hidden" name="total_amount" value="{{ $totalPrice }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Alamat</label>
                        <textarea name="address" class="form-control" cols="30" rows="10"></textarea>
                        @error('address')
                            <div class="text-muted text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button class="btn btn-danger">Bayar</button>
                    </form>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
