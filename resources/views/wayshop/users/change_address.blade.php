@extends('wayshop.layouts.master')
@section('content')

    <div class="contact-box-main">
        <div class="container">
            @if(Session::has('flash_message_error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{ session('flash_message_error') }}</strong>
                </div>
            @endif
            @if(Session::has('flash_message_success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{ session('flash_message_success') }}</strong>
                </div>
            @endif
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="contact-form-right">
                        <h2>Change Address</h2>
                        <form action="{{url('/change-address')}}" method="post" id="contactForm registerForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{$userDetails->name}}" name="name" id="name" required data-error="Please Enter Your Name">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{$userDetails->address}}" name="address" id="address" required data-error="Please Enter Your Address">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{$userDetails->city}}" name="city" id="city" required data-error="Please Enter Your City">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{$userDetails->state}}" name="state" id="state" required data-error="Please Enter Your State">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                      <select name="country" id="country" class="form-control">
                                          <option value="1">Select Country</option>
                                          @foreach($countries as $country)
                                              <option value="{{$country->name}}"@if($country->name==$userDetails->country) selected @endif>{{$country->name}}</option>
                                          @endforeach
                                      </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{$userDetails->pincode}}" name="pincode" id="pincode" required data-error="Please Enter Your Pincode">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{$userDetails->mobile}}" name="mobile" id="mobile" required data-error="Please Enter Your Mobile">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="submit-button text-center">
                                        <button class="btn hvr-hover" id="submit" type="submit">Signup</button>
                                        <div id="msgSubmit" class="h3 text-center hidden"></div>
                                        <div class="clearfix"></div>

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="col-md-3"></div>

@endsection
