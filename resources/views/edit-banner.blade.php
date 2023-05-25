@extends('layout')

@section('title',"Edit Banner")

@section('content')
			<div class="col-md-12">
			<form method="post" action="{{url('edit-banner')}}" enctype="multipart/form-data">
				{!! csrf_field() !!}
				<input type="hidden" name="xf" value="{{$xf}}">
				<?php
                           	    $imgg = $b['img'];
	                            $subtitle = $b['subtitle'];
	                            $title = $b['title'];
	                            $copy = $b['copy'];
	                            $status = $b['status'];
								
								$du = url('delete-img')."?xf=".$b['img'];
							   ?>
                <div class="block">
                    <div class="header">
                        <h2>Add new banner</h2>
                    </div>
                    <div class="content controls">
					     <div class="form-row">
                            <div class="col-md-3">Subtitle</div>
                           <div class="col-md-9">
							  <input type="text" class="form-control" name="subtitle" value="{{$subtitle}}" placeholder="Enter subtitle">
						   </div>
                        </div><br>
						<div class="form-row">
                            <div class="col-md-3">Title</div>
                           <div class="col-md-9">
							  <input type="text" class="form-control" name="title" value="{{$title}}" placeholder="Enter title">
						   </div>
                        </div><br>
						<div class="form-row">
                            <div class="col-md-3">Copy (optional)</div>
                           <div class="col-md-9">
							  <input type="text" class="form-control" name="copy" value="{{$copy}}" placeholder="Enter copy">
						   </div>
                        </div><br>
					    <div class="form-row">
                            <div class="col-md-3">Upload image:</div>
                            <div class="col-md-9">
							   @if($imgg == "")
							    <p class="form-control-plaintext text-left"><i class="fa fa-asterik"></i> Upload ad image (<b>Recommended dimension: 1920 x 550</b>)</p>
								<input type="file" name="img" id="img-1" class="form-control" >
							   @else
							    <img class="img img-responsive" src="{{$imgg}}"><br>
							    <a href="#" class="btn btn-default btn-block btn-clean">delete</a>
                               @endif								
							</div>
                        </div><br>
                       
                       
						<div class="form-row">
                            <div class="col-md-3">Status:</div>
                           <div class="col-md-9">
							  <select class="form-control" name="status">
							    <option value="none">Select status</option>
								<?php
								 $stockStatuses = ['enabled' => "Enabled",'disabled' => "Disabled"];
								
								foreach($stockStatuses as $key=> $value){
									$ss = $key == $b['status'] ? "selected='selected'" : "";
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