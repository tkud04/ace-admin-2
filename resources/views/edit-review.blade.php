@extends('layout')

@section('title',"Edit Review")

@section('content')
			<div class="col-md-12">
			<form method="post" action="{{url('edit-review')}}" enctype="multipart/form-data">
				{!! csrf_field() !!}
				<input type="hidden" name="xf" value="{{$xf}}">
				<?php
                           	     $name = $r['name'];
                           	   $sku = $r['sku'];
	                            $review = $r['review'];
	                            $status = $r['status'];
	                            $rating = $r['rating'];
	                            $status = $r['status'];
	                            $pu = url('edit-product?id=').$sku;
								
							   ?>
                <div class="block">
                    <div class="header">
                        <h2>Edit user review</h2>
                    </div>
                    <div class="content controls">
					     <div class="form-row">
                            <div class="col-md-3">Name</div>
                           <div class="col-md-9">
							  <input type="text" class="form-control" name="name" value="{{$name}}" placeholder="Name">
						   </div>
                        </div><br>
						<div class="form-row">
                            <div class="col-md-3">Rating</div>
                           <div class="col-md-9">
							  <span class="form-control">
							   @for($i = 0; $i < $rating; $i++)
							    <span class="icon-star"></span>
							   @endfor
							  </span>
						   </div>
                        </div><br>
						<div class="form-row">
                            <div class="col-md-3">Review</div>
                           <div class="col-md-9">
							  <p class="form-control">
							  {{$review}}
							  </p>
						   </div>
                        </div><br>
                       
                       
						<div class="form-row">
                            <div class="col-md-3">Status:</div>
                           <div class="col-md-9">
							  <select class="form-control" name="status">
							    <option value="none">Select status</option>
								<?php
								 $statuses = ['enabled' => "Enabled",'pending' => "Pending",'disabled' => "Disabled"];
								
								foreach($statuses as $key=> $value){
									$ss = $key == $status ? "selected='selected'" : "";
								?>
								 <option value="{{$key}}" {{$ss}}>{{$value}}</option>
								<?php
								}
								?>
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