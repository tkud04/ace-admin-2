@extends('layout')

@section('title',"Add New Category")

@section('content')
			<div class="col-md-12">
			<form method="post" action="{{url('add-category')}}" enctype="multipart/form-data">
				{!! csrf_field() !!}
                <div class="block">
                    <div class="header">
                        <h2>Add new category to store</h2>
                    </div>
                    <div class="content controls">
                        <div class="form-row">
                            <div class="col-md-3">Category:</div>
                            <div class="col-md-9"><input type="text" class="form-control" name="category" placeholder="e.g necklaces, bracelets"/></div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-3">Special: <span class="label label-warning">Optional</span></div>
                           <div class="col-md-9">
							  <select class="form-control" name="special">
							    <option value="none">Select special</option>
								<?php
								 $specials = ['hot' => "Hot",'popular' => "Popular",'trending' => "Trending"];
								foreach($specials as $key=> $value){
								?>
								 <option value="{{$key}}">{{$value}}</option>
								<?php
								}
								?>
							  </select>
							</div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-3">Google Product Category (GPC): <a href="javascript:void(0)">What's this?</a></div>
                            <div class="col-md-9"><input type="number" class="form-control" name="gpc" placeholder="GPC number" value=""/></div>
                        </div>
						<div class="form-row">
                            <div class="col-md-3">Status:</div>
                           <div class="col-md-9">
							  <select class="form-control" name="status">
							    <option value="none">Select status</option>
								<?php
								 $stockStatuses = ['enabled' => "Enabled",'disabled' => "Disabled"];
								?>
								@foreach($stockStatuses as $key=> $value)
								 <option value="{{$key}}">{{$value}}</option>
								@endforeach
							  </select>
							</div>
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
