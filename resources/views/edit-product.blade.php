@extends('layout')

@section('title',$product['sku'])

@section('scripts')
 <script>
 $(document).ready(() =>{
 $('.bup-hide').hide();
 
 <?php
 $cid = env('FACEBOOK_APP_ID');
 $sec = env('FACEBOOK_APP_SECRET');
 $uu = url('edit-product')."?id=".$product['sku'];
 
 if($code != ""){
 ?>
  getFBToken({code: '{{$code}}',cid: '{{$cid}}',edf: '{{$sec}}'});
 <?php
 }
 ?>
 
 //get fb permission
		let  fbp = localStorage.getItem('ace_fbp'), uu = "{{$uu}}";
		let fbPermRequired = true;
		if(fbp){
			let ace_fbp = JSON.parse(fbp);
			if(ace_fbp){
		        $('#bup-ftk').val(ace_fbp.access_token);
				fbPermRequired = false;
			}
			else{
				console.log("Invalid token");
			}
		   
		}
		if(fbPermRequired){
			//invoke dialog to get code
			/**
			Swal.fire({
             title: `Your permission is required`,
             imageUrl: "img/facebook.png",
             imageWidth: 64,
             imageHeight: 64,
             imageAlt: `Grant the app catalog permissions`,
             showCloseButton: true,
             html:
             "<h4 class='text-warning'>Facebook <b>requires your permission</b> to make any changes to your Catalog.</h4><p class='text-primary'>Click OK below to redirect to Facebook to grant this app access.</p>"
           }).then((result) => {
               if (result.value) {
                 let cid = "{{$cid}}", ss = "ksslal3wew";
			     window.location = `https://www.facebook.com/v8.0/dialog/oauth?client_id=${cid}&redirect_uri=${uu}&state=${ss}&scope=catalog_management`;
                }
              });
		  **/
		}
 });
 </script>
@stop

@section('content')
			<div class="col-md-12">
			<form method="post" action="{{url('edit-product')}}" enctype="multipart/form-data">
				{!! csrf_field() !!}
				 <input type="hidden" id="p-ftk" name="ftk">
                <div class="block">
                    <div class="header">
                        <h2>Edit product information</h2>
                    </div>
                    <div class="content controls">
                        <div class="form-row">
                            <div class="col-md-3">SKU:</div>
                            <div class="col-md-9"><input type="text" name="xf" class="form-control" placeholder="Will be generated" value="{{$product['sku']}}" readonly/></div>
                        </div>
						<div class="form-row">
                            <div class="col-md-3">Description:</div>
                            <div class="col-md-9"><textarea class="form-control" name="description" placeholder="Brief description..">{{$product['pd']['description']}}</textarea></div>
                        </div> 
						<div class="form-row">
                            <div class="col-md-3">Price(&#8358;):</div>
                            <div class="col-md-9"><input type="number" class="form-control" name="amount" placeholder="Price in NGN" value="{{$product['pd']['amount']}}"/></div>
                        </div> 
						<div class="form-row">
                            <div class="col-md-3">Quantity:</div>
                            <div class="col-md-9"><input type="number" class="form-control" name="qty" placeholder="Current stock e.g 10" value="{{$product['qty']}}"/></div>
                        </div> 
						<div class="form-row">
                            <div class="col-md-3">Discount:</div>
                           <div class="col-md-9">
						   		<input type="hidden" name="add_discount" id="add_discount" value="no"/>
						      <div id="add-discount-button">
							     <center>
								 <?php
								 if(isset($discounts) && count($discounts) > 0)
								 {
									foreach($discounts as $d)
									{
										$dtype = $d['discount_type'];
										$discount = $d['discount'];
										$rt = "";
										
										switch($dtype)
										{
											case "flat":
											 $rt = "&#8358;".number_format($discount,2);
											break;
											case "percentage":
											 $rt = $discount."%";
											break;
										}
										
										$du = url("delete-discount")."?xf=".$d['id'];
								 ?>
							     <p><b>{{strtoupper($d['type'])}}</b> - {!! $rt !!} - <a href="{{$du}}" class="btn btn-default btn-clean">Delete</a></p>
								 <?php
							        }
								 }
								 else
								 {
								 ?>
                                  <p>No discount</p>
                                 <?php								 
								 }
								 ?>
							     </center>
							  </div>
							  <div>
							    <center>
							      <a href="javascript:void(0)" id="toggle-discount-btn" class="btn btn-default btn-clean">Add discount</a>
							    </center>	<br>
							  </div>
						      <div id="add-discount-input">
							  <div class="form-row">
                                <div class="col-md-3">Discount type:</div>
								<div class="col-md-9">
							      <select class="form-control" name="discount_type" style="margin-bottom: 5px;">
							        <option value="none">Select discount type</option>
								    <?php
								     $discTypes = ['flat' => "Flat(NGN)",'percentage' => "Percentage(%)"];
								     foreach($discTypes as $key => $value){
								    ?>
								    <option value="{{$key}}">{{$value}}</option>
								    <?php
								    }
								    ?>
							      </select>
								 </div>
								</div>
								<div class="form-row">
                                <div class="col-md-3">Discount:</div>
								<div class="col-md-9">
							      <input type="number" class="form-control" name="discount" id="discount" placeholder="Discount in NGN or in %" value=""/>
							    </div>
							   </div>
							  </div>
						     
							</div>
                        </div>
						<div class="form-row">
                            <div class="col-md-3">Category:</div>
                            <div class="col-md-9">
							  <select class="form-control" name="category">
							    <option value="none">Select category</option>
								<?php
								foreach($categories as $c){
								$ss = $c['category'] == $product['pd']['category'] ? " selected='selected'" : "";
								?>
								 <option value="{{$c['category']}}" {{$ss}}>{{$c['name']}}</option>
								<?php
								}
								?>
							  </select>
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
								$ss = $product['status'] == $key ? " selected='selected'" : "";
								?>
								 <option value="{{$key}}" {{$ss}}>{{$value}}</option>
								<?php
								}
								?>
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
								
								foreach($stockStatuses as $key=> $value){
									$ss = $key == $product['pd']['in_stock'] ? " selected='selected'" : "";
								?>
								 <option value="{{$key}}" {{$ss}}>{{$value}}</option>
								<?php
								}
								?>
							  </select>
							</div>
                        </div>
						<div class="form-row">
                            <div class="col-md-3">Images:</div>
                            <div class="col-md-9">
							   <ul class="list-inline">
							    <?php
								  $imggs = $product['imggs'];
								  $imgs = $product['imgs'];
								  
								  if(count($imgs) < 1)
								  {
								?>
                                    <li>
								  <img class="img img-responsive" src="img/no-image.png" width="200" height="300" style="margin-bottom: 3px;">
									
								</li>
                                <?php								
								  }
								  else
								  {
								  for($ii = 0; $ii < count($imggs); $ii++){
									  $i = $imggs[$ii];
									  $i2 = $imgs[$ii];
									  $diu = url("delete-img")."?xf=".$imgs[$ii]['id'];
									  $ciu = "<a class='btn btn-default btn-block btn-clean' href='".url("set-cover-img")."?xf=".$imgs[$ii]['id']."'>Set as cover image</a>";
									  if($i2['cover'] == "yes") $ciu = "<p class='text-primary text-bold'>Cover image</p>";
                                ?>
								<li>
								  <img class="img img-responsive" src="{{$i}}" width="200" height="300" style="margin-bottom: 3px;">
									{!! $ciu !!}
								  <a href="{{$diu}}" class="btn btn-default btn-block btn-clean">Delete</a>
								</li>
                                <?php
								  }
								  }
                                ?>
                               </ul>
							    <p class="form-control-plaintext text-left"><i class="fa fa-asterik"></i> Upload product images (<b>Recommended dimension: 700 x 700</b>)</p><br>
								<input type="file" name="img[]" id="img-1" class="form-control" >
								<input type="file" name="img[]" id="img-2" class="form-control" >		<br><br>						   
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