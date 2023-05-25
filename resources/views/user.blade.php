@extends('layout')

@section('title',$u['fname']." ".$u['lname'])

@section('content')
			<div class="col-md-12">
			<form method="post" action="{{url('user')}}" enctype="multipart/form-data">
				{!! csrf_field() !!}
				<input type="hidden" name="xf" value="{{$u['id']}}">
                <div class="block">
                    <div class="header">
                        <h2>Edit user information</h2>
                    </div>
                    <div class="content controls">
                        <div class="form-row">
                            <div class="col-md-3">First name:</div>
                            <div class="col-md-9"><input type="text" name="fname" class="form-control" placeholder="First name" value="{{$u['fname']}}"/></div>
                        </div>
						<div class="form-row">
                            <div class="col-md-3">Last name:</div>
                            <div class="col-md-9"><input type="text" name="lname" class="form-control" placeholder="Last name" value="{{$u['lname']}}"/></div>
                        </div> 
						<div class="form-row">
                            <div class="col-md-3">Email:</div>
                            <div class="col-md-9"><input type="text" class="form-control" name="email" placeholder="Email address" value="{{$u['email']}}"/></div>
                        </div> 
						<div class="form-row">
                            <div class="col-md-3">Phone:</div>
                            <div class="col-md-9"><input type="text" class="form-control" name="phone" placeholder="Phone number" value="{{$u['phone']}}"/></div>
                        </div> 
						<div class="form-row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
							  <center>
							    <button type="submit" class="btn btn-default btn-block btn-clean">Submit</button>
							  </center>
							</div>
                            <div class="col-md-4"></div>							
                        </div>
                                              
                    </div>
                </div>  
            </form>				
            </div>
@stop