@extends('layout')

@section('title',"Edit Ad")

@section('content')
			<div class="col-md-12">
			<form method="post" action="{{url('edit-ad')}}" enctype="multipart/form-data">
				{!! csrf_field() !!}
				<input type="hidden" name="xf" value="{{$xf}}">
                <div class="block">
                    <div class="header">
                        <h2>Edit ad information</h2>
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
									$ss = $key == $ad['type'] ? "selected='selected'" : "";
								?>
								 <option value="{{$key}}" {{$ss}}>{{$value}}</option>
								<?php
								}
								?>
							  </select>
							</div>
                        </div><br>
					    <div class="form-row">
                            <div class="col-md-3">Image:</div>
                            <div class="col-md-9">
							
							    <p class="form-control-plaintext text-left"><i class="fa fa-asterik"></i> Upload ad image (<b>Recommended dimension: 1170 x 100 for wide ads, 300 x 500 for side ads</b>)</p>
								<img class="img img-responsive" src="{{$ad['img']}}">	
							</div>
                        </div><br>
                       
                       
						<div class="form-row">
                            <div class="col-md-3">Status:</div>
                           <div class="col-md-9">
							  <select class="form-control" name="status">
							    <option value="none">Select status</option>
								<?php
								 $statuses = ['enabled' => "Enabled",'disabled' => "Disabled"];
								 
								 foreach($statuses as $key => $value)
								 {
								$ss = $key == $ad['status'] ? "selected='selected'" : "";
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