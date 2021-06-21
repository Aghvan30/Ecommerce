@extends('admin.layouts.master')
@section('title','Edit Coupon')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="header-icon">
                <i class="fa fa-image"></i>
            </div>
            <div class="header-title">
                <h1>Edit Coupon</h1>
                <small>Edit Coupons</small>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <!-- Form controls -->
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="btn-group" id="buttonlist">
                                <a class="btn btn-add " href="{{url('admin/view-coupons')}}">
                                    <i class="fa fa-eye"></i>  View Coupons </a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="col-sm-6" action="{{url('/admin/edit-coupons/'.$coupon->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Coupon Code</label>
                                    <input type="text" class="form-control" value="{{$coupon->coupon_code}}" placeholder="Enter coupon Code" name="coupon_code" id="banner_name" required>
                                </div>
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="text" class="form-control" value="{{$coupon->amount}}" placeholder="Amount" name="amount" id="amount"  required>
                                </div>
                                <div class="form-group">
                                    <label>Amount Type</label>
                                    <select name="amount_type" id="amount_type" class="form-control">
                                        <option value="percentage">Percentage</option>
                                        <option value="fixed">Fixed</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Expiry Date</label>
                                    <input type="text" class="form-control" value="{{$coupon->expiry_date}}" placeholder="Expiry Date" name="expiry_date" id="datepicker" required>
                                </div>

                                <div class="reset-button">

                                    <input type="submit" class="btn btn-success" value="Edit Coupon">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection



