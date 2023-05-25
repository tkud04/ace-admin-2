@extends('layout')

@section('title',"New Ad")

@section('content')
			<div class="col-md-12">
			<form method="post" action="{{url('new-ad')}}" enctype="multipart/form-data">
				{!! csrf_field() !!}
                <div class="block">
                    <div class="header">
                        <h2>Add new ad</h2>
                    </div>
                    <div class="content controls">
					     <div class="form-row">
                            <div class="col-md-3">Type</div>
                           <div class="col-md-9">
							  <select class="form-control" name="type">
							    <option value="none">Select type</option>
								<?php
								 $types = ['wide-ad' => "Wide ad",'side-ad' => "Side ad"];
								foreach($types as $key=> $value){
								?>
								 <option value="{{$key}}">{{$value}}</option>
								<?php
								}
								?>
							  </select>
							</div>
                        </div><br>
					    <div class="form-row">
                            <div class="col-md-3">Upload ad:</div>
                            <div class="col-md-9">
							    <p class="form-control-plaintext text-left"><i class="fa fa-asterik"></i> Upload ad image (<b>Recommended dimension: 1170 x 100 for wide ads, 300 x 500 for side ads</b>)</p>
								<input type="file" name="img" id="img-1" class="form-control" >		
							</div>
                        </div><br>
                       
                       
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