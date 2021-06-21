@extends('admin.layouts.master')
@section('title','Edit Attributes')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="header-icon">
                <i class="fa fa-product-hunt"></i>
            </div>
            <div class="header-title">
                <h1>Edit Attribute</h1>
                <small>Edit Attributes</small>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <!-- Form controls -->
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="btn-group" id="buttonlist">
                                <a class="btn btn-add " href="{{url('admin/view-products')}}">
                                    <i class="fa fa-eye"></i>  View Products </a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="col-sm-6" action="{{url('admin/update-attribute/'.$editattribute->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control" name="attr[]" value="{{$editattribute->id}}" required>{{$editattribute->id}}
                                <div class="form-group">
                                    <label>SKU</label>
                                    <input type="text" class="form-control" placeholder="SKU" name="sku[]" id="sku" value="{{$editattribute->sku}}" required>
                                </div>
                                <div class="form-group">
                                    <label>Size</label>
                                    <input type="text" class="form-control" placeholder="Size" name="size[]" id="size" value="{{$editattribute->size}}"  required>
                                </div>
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="text" class="form-control" placeholder="Price" name="price[]" id="price" value="{{$editattribute->price}}" required>
                                </div>
                                <div class="form-group">
                                    <label>Stock</label>
                                    <input type="text" class="form-control" placeholder="Stock" name="stock[]" id="stock" value="{{$editattribute->stock}}" required>
                                </div>

                                <div class="reset-button">

                                    <input type="submit" class="btn btn-success" value="Edit Attribute">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection
