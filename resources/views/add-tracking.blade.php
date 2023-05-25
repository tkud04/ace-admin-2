@extends('layout')

@section('title',"New Tracking")

@section('content')
			<div class="col-md-12">
			<form method="post" action="{{url('new-tracking')}}" enctype="multipart/form-data">
				{!! csrf_field() !!}
				
                <div class="block">
                    <div class="header">
                        <h2>Add new tracking</h2>
                    </div>
                    <div class="content controls">
					     <div class="form-row">
                            <div class="col-md-3">Added by</div>
                           <div class="col-md-9">
							  <input type="text" class="form-control" placeholder="{{$user->fname.' '.$user->lname}}" readonly>
						   </div>
                        </div><br>
						<div class="form-row">
                            <div class="col-md-3">Order reference #</div>
                           <div class="col-md-9">
							  <input type="text" class="form-control" name="reference" value="{{$r}}" readonly>
						   </div>
                        </div><br>
                       
						<div class="form-row">
                            <div class="col-md-3">Status:</div>
                           <div class="col-md-9">
							  <select class="form-control" name="status">
							    <option value="none">Select status</option>
								<?php
								 $statuses = ['pickup' => "Scheduled for Pickup",
								              'transit' => "In Transit",
								              'delivered' => "Package delivered",
								              'return' => "Package Returned",
								              'receiver_not_present' => "Receiver Not Present at Delivery Address",
											 ];
								?>
								@foreach($statuses as $key=> $value)
								 <option value="{{$key}}">{{$value}}</option>
								@endforeach
							  </select>
							</div>
                        </div><br>
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