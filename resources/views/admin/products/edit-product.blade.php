@extends('admin.layouts.master')
@section('title','Edit Product')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="header-icon">
                <i class="fa fa-product-hunt"></i>
            </div>
            <div class="header-title">
                <h1>Edit Product</h1>
                <small>Edit Products</small>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <!-- Form controls -->
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="btn-group" id="buttonlist">
                                <a class="btn btn-add " href="{{url('admin/edit-product')}}">
                                    <i class="fa fa-eye"></i>  View Products </a>
                            </div>
                        </div>

                        <div class="panel-body">
                            <form class="col-sm-6" action="{{url('admin/edit-product/'.$products->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Under Category</label>
                                    <select name="category_id" id="category_id" class="form-control">
                                        <?php echo $categories_dropdown;?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Product Name</label>
                                    <input type="text" class="form-control" value="{{$products->name}}" placeholder="Enter Product Name" name="name" id="product_name" required>
                                </div>
                                <div class="form-group">
                                    <label>Product Code</label>
                                    <input type="text" class="form-control" value="{{$products->code}}" placeholder="Enter Product Code" name="product_code" id="product_code"  required>
                                </div>
                                <div class="form-group">
                                    <label>Product Color</label>
                                    <input type="text" class="form-control" value="{{$products->color}}" placeholder="Enter Product Color" name="product_color" id="product_color" required>
                                </div>
                                <div class="form-group">
                                    <label>Product Description</label>
                                    <textarea name='product_descr' id="product_descr" class="form-control">
                                   {{$products->description}}
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label>Product Price</label>
                                    <input type="text" class="form-control" value="{{$products->price}}" placeholder="Enter Price" name="product_price" id="product_price" required>
                                </div>
                                <div class="form-group">
                                    <label>Picture upload</label>
                                    <input type="file" name="image">
                                    <input type="hidden" name="current_image" value="{{$products->image}}">
                                    @if(!empty($products->image))
                                        <img src="{{asset('/upload/'.$products->image)}}" alt="" style="width: 100px; height: 100px">

                                    @endif

                                </div>
                                <div class="reset-button">

                                    <input type="submit" class="btn btn-success" value="Add Product">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection

