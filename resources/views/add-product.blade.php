@extends('layout')

@section('title',"Add New Product")

@section('content')
			<div class="col-md-12">
			<form method="post" action="{{url('add-product')}}" enctype="multipart/form-data">
				{!! csrf_field() !!}
                <div class="block">
                    <div class="header">
                        <h2>Add new product to store</h2>
                    </div>
                    <div class="content controls">
                        <div class="form-row">
                            <div class="col-md-3">SKU:</div>
                            <div class="col-md-9"><input type="text" class="form-control" placeholder="Will be generated" readonly/></div>
                        </div>
						<div class="form-row">
                            <div class="col-md-3">Description:</div>
                            <div class="col-md-9"><textarea class="form-control" name="description" placeholder="Brief description.."></textarea></div>
                        </div> 
						<div class="form-row">
                            <div class="col-md-3">Price(&#8358;):</div>
                            <div class="col-md-9"><input type="number" class="form-control" name="amount" placeholder="Price in NGN"/></div>
                        </div> 
						<div class="form-row">
                            <div class="col-md-3">Quantity:</div>
                            <div class="col-md-9"><input type="number" class="form-control" name="qty" placeholder="Current stock e.g 10"/></div>
                        </div> 
						<div class="form-row">
                            <div class="col-md-3">Category:</div>
                            <div class="col-md-9">
							  <select class="form-control" name="category">
							    <option value="none">Select category</option>
								@foreach($c as $cc)
								 @if($cc['status'] == "enabled")
								 <option value="{{$cc['category']}}">{{$cc['name']}}</option>
								 @endif
								@endforeach
							  </select>
							</div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-3">Stock status:</div>
                           <div class="col-md-9">
							  <select class="form-control" name="in_stock">
							    <option value="none">Select stock status</option>
								<?php
								 $stockStatuses = ['in_stock' => "In stock",'new' => "New",'out_of_stock' => "Out of stock"];
								?>
								@foreach($stockStatuses as $key=> $value)
								 <option value="{{$key}}">{{$value}}</option>
								@endforeach
							  </select>
							</div>
                        </div>
						<div class="form-row">
                            <div class="col-md-3">Upload images:</div>
                            <div class="col-md-9">
							    <p class="form-control-plaintext text-left"><i class="fa fa-asterik"></i> Upload product images (<b>Recommended dimension: 700 x 700</b>)</p>
								<input type="file" name="img[]" id="img-1" class="form-control" >
								<input type="file" name="img[]" id="img-2" class="form-control" >		
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