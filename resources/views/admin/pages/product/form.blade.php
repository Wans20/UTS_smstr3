@extends('admin.layouts.index')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $product->id ? 'Form Edit' : 'Form Create Product' }}</h1>
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

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">

                            <!-- /.card-header -->
                            <!-- form start -->

                            @if ($product->id)
                                <form action="{{ route('product.update', ['product' => $product->id]) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @method('PUT')
                                @else
                                    <form action="{{ route('product.store') }}" method="POST"
                                        enctype="multipart/form-data">
                            @endif
                            @csrf

                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Title</label>
                                    <input type="text" class="form-control" name="title" id="title"
                                        value="{{ $product->title }}">
                                    @error('title')
                                        <div class="text-muted text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="gender" class="form-label">Status</label>
                                    <select name="status" class="form-control" id="status">
                                        <option disabled selected>--- Choose Your Status ---</option>
                                        <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive"{{ $product->status == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                        <option value="draft"{{ $product->status == 'draft' ? 'selected' : '' }}>Draft
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="text-muted text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" cols="10" rows="5" class="form-control">{{ $product->description }}</textarea>
                                    @error('description')
                                        <div class="text-muted text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="category" class="form-label">Category</label>
                                    <select name="category_id" class="form-control" id="category_id">
                                        <option selected disabled>--- Choose Your Category ---</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $product->category_id == $category->id ? ' selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('address')
                                        <div class="text-muted text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="weight" class="form-label">Weight</label>
                                    <input type="text" class="form-control" name="weight" id="weight"
                                        value="{{ $product->weight }}">
                                </div>
                                <div class="form-group">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="text" class="form-control" name="price" id="price"
                                        value="{{ $product->price }}">
                                </div>
                                @error('price')
                                    <div class="text-muted text-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" name="image" class="form-control" id="image">
                                    <img src="/storage/{{ $product->image }}" class="img-thumbnail" width="200px"
                                        height="200px">
                                </div>
                                @error('image')
                                    <div class="text-muted text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            </form>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
