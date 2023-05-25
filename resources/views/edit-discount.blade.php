@extends('layout')

@section('title',"Edit Discount")

@section('content')
			<div class="col-md-12">
			<form method="post" action="{{url('edit-discount')}}" enctype="multipart/form-data">
				{!! csrf_field() !!}
				<input type="hidden" name="xf" value="{{$xf}}">
                <div class="block">
                    <div class="header">
                        <h2>Edit discount</h2>
                    </div>
                    <div class="content controls">
					<div class="form-row">
					<div class="form-row">
                                <div class="col-md-3">Code:</div>
								<div class="col-md-9">
							      <input type="text" class="form-control" name="code" id="code" placeholder="Coupon code" value="{{$discount['code']}}"/>
							    </div>
							   </div> 
                                <div class="col-md-3">Type:</div>
								<div class="col-md-9">
							      <select class="form-control" id="add-discount-type" name="type" style="margin-bottom: 5px;">
							        <option value="none">Select type</option>
								    <?php
								     $types = ['single' => "Single product",'category' => "Category",'general' => "General"];
								     foreach($types as $key => $value){
										 $ss = $key == $discount['type'] ? "selected='selected'" : "";
								    ?>
								    <option value="{{$key}}" {{$ss}}>{{$value}}</option>
								    <?php
								    }
								    ?>
							      </select>
								 </div>
								</div>
						<div class="form-row" id="sku-form-row">
                            <div class="col-md-3">Product:</div>
                            <div class="col-md-9">
							  <select class="form-control" name="sku">
							    <option value="none">Select product</option>
								<?php
								foreach($products as $p){
								$ss = $discount['uid'] == $p['sku'] ? " selected='selected'" : "";
								?>
								 <option value="{{$p['sku']}}" {{$ss}}>{{$p['sku']}}</option>
								<?php
								}
								?>
							  </select>
							</div>
                        </div>
						<div class="form-row" id="category-form-row">
                            <div class="col-md-3">Category:</div>
                            <div class="col-md-9">
							  <select class="form-control" name="category">
							    <option value="none">Select category</option>
								<?php
								foreach($categories as $cc){
								$ss = $discount['uid'] == $cc['name'] ? " selected='selected'" : "";
								?>
								 <option value="{{$cc['id']}}" {{$ss}}>{{$cc['name']}}</option>
								<?php
								}
								?>
							  </select>
							</div>
                        </div>
						<div class="form-row">
                                <div class="col-md-3">Discount type:</div>
								<div class="col-md-9">
							      <select class="form-control" name="discount_type" style="margin-bottom: 5px;">
							        <option value="none">Select discount type</option>
								    <?php
								     $discTypes = ['flat' => "Flat(NGN)",'percentage' => "Percentage(%)"];
								     foreach($discTypes as $key => $value){
									  $ss = $discount['discount_type'] == $key ? " selected='selected'" : "";
								    ?>
								    <option value="{{$key}}" {{$ss}}>{{$value}}</option>
								    <?php
								    }
								    ?>
							      </select>
								 </div>
								</div>
								<div class="form-row">
                                <div class="col-md-3">Discount:</div>
								<div class="col-md-9">
							      <input type="number" class="form-control" name="discount" id="discount" placeholder="Discount in NGN or in %" value="{{$discount['discount']}}"/>
							    </div>
							   </div>           
						<div class="form-row">
                            <div class="col-md-3">Status:</div>
                            <div class="col-md-9">
							  <select class="form-control" name="status">
							  <option value="none">Select status</option>
								<?php
								$statuses = ['enabled' => "Enabled",'disabled' => "Disabled"];
								foreach($statuses as $key => $value){
								$ss = $discount['status'] == $key ? " selected='selected'" : "";
								?>
								 <option value="{{$key}}" {{$ss}}>{{$value}}</option>
								<?php
								}
								?>
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