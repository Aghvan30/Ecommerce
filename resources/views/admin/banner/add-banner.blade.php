@extends('admin.layouts.master')
@section('title','Add Banner')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="header-icon">
                <i class="fa fa-image"></i>
            </div>
            <div class="header-title">
                <h1>Add Banner</h1>
                <small>Add Banners</small>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <!-- Form controls -->
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="btn-group" id="buttonlist">
                                <a class="btn btn-add " href="{{url('admin/banners')}}">
                                    <i class="fa fa-eye"></i>  View Banners </a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="col-sm-6" action="{{url('admin/add-banner')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" placeholder="Enter  Name" name="banner_name" id="banner_name" required>
                                </div>
                                <div class="form-group">
                                    <label>Text Style</label>
                                    <input type="text" class="form-control" placeholder="Text Style" name="text_style" id="text_style"  required>
                                </div>
                                <div class="form-group">
                                    <label>Content</label>
                                    <textarea name='banner_content' id="banner_content" class="form-control">

                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label>Link</label>
                                    <input type="text" class="form-control" placeholder="Link" name="link" id="link" required>
                                </div>
                                <div class="form-group">
                                    <label>Sort Order</label>
                                    <input type="text" class="form-control" placeholder="Sort Order" name="sort_order" id="sort_order" required>
                                </div>
                                <div class="form-group">
                                    <label>Banner Image</label>
                                    <input type="file" name="image">

                                </div>
                                <div class="reset-button">

                                    <input type="submit" class="btn btn-success" value="Add Banner">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection

