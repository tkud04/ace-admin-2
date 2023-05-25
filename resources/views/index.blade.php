@extends('layout')

@section('title',"Dashboard")

@section('content')
   <?php
								 $statuses = ['none' => "Select tracking status",
								              'pickup' => "Scheduled for Pickup",
								              'transit' => "In Transit",
								              'delivered' => "Package delivered",
								              'return' => "Package Returned",
								              'receiver_not_present' => "Receiver Not Present at Delivery Address",
											 ];
								?>
            <div class="col-md-2">
                
                <div class="block block-drop-shadow">
                    <div class="user bg-default bg-light-rtl">
                        <div class="info">                                                                                
                            <a href="#" class="informer informer-three">
                                <span>{{$user->fname}}</span>
									{{$user->lname}}
                            </a>                            
                            <a href="#" class="informer informer-four">
                                <span>{{strtoupper($user->role)}}</span>
                                Role
                            </a>                                                        
                            <img src="img/icon.png" class="img-circle img-thumbnail"/>
                        </div>
                    </div>
                    <div class="content list-group list-group-icons">
                        <a href="{{url('logout')}}" class="list-group-item"><span class="icon-off"></span>Logout<i class="icon-angle-right pull-right"></i></a>
                    </div>
                </div> 
                
               
                <div class="block block-drop-shadow">                    
                    <div class="head bg-dot20">
                        <h2>Total profit (&#8358;)</h2>
                        <div class="side pull-right">               
                            <ul class="buttons">                                
                                <li><a href="#"><span class="icon-cogs"></span></a></li>
                            </ul>
                        </div>
                        <div class="head-subtitle">Total amount generated from sales </div>                        
                        <div class="head-panel tac" style="line-height: 0px;">
                                                    
                        </div>
                        <div class="head-panel nm">
                            <div class="hp-info hp-simple pull-left hp-inline">
                                <span class="hp-main">Total profit</span>
                                <span class="hp-sm">Amount: &#8358;{{number_format($profits['total'],2)}} </span>
                            </div>   
							<div class="hp-info hp-simple pull-left hp-inline">
                                <span class="hp-main">Total profit today</span>
                                <span class="hp-sm">Amount: &#8358;{{number_format($profits['today'],2)}} </span>
                            </div>                 
                            <div class="hp-info hp-simple pull-left hp-inline">
                                <span class="hp-main">Total profit this month</span>
                                 <span class="hp-sm">Amount: &#8358;{{number_format($profits['month'],2)}} </span>
                            </div>                 
                        </div>                        
                    </div>                    
                    
                </div>                
                
            </div>
            
            <div class="col-md-5">
               <div class="block block-drop-shadow">
			      <div class="head bg-dot20">
                        <h2>Most viewed pages</h2>
						<input type="hidden" id="tk-analytics-1" value="{{csrf_token()}}">
						<div style="margin-bottom: 5px;">
						  <select id="analytics-1-period">
						   <option value="none">Select period</option>
						   <option value="days" selected="selected">Days</option>
						   <option value="months">Months</option>
						  </select>
						  <span class="label label-danger" id="analytics-1-period-error">Select a period</span>
						</div>
						<div style="margin-bottom: 5px;">
						  <input type="number" id="analytics-1-num" style="margin-bottom: 5px;" placeholder="Number of days/months" value="7">
						  <span class="label label-danger" id="analytics-1-num-error">A value of at least 1 is required</span>
						</div>
						<div style="margin-bottom: 5px;" id="analytics-1-submit">
						  <a href="javascript:void(0)" id="analytics-1-btn" class="btn btn-default btn-block btn-clean" style="margin-bottom: 10px;">Submit</a>
				        </div>
						<div style="margin-bottom: 5px;" id="analytics-1-loading">
						  <h4>Fetching latest data.. <img src="img/loading.gif" class="img img-fluid" alt="Loading" width="50" height="50"></h4>
				        </div>
						 
				<div id="DataTables_Table_2_wrapper" class="dataTables_wrapper table-responsive" role="grid">
					     
                        <table cellpadding="0" cellspacing="0" width="100%" data-idl="2" id="analytics-1-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>                                  
                                    <th>URL</th>
                                    <th>Page views</th>
                                </tr>
                            </thead>
                            <tbody>
							  <?php
							  
					  if(count($mostVisitedPages) > 0)
					  {
						  $mvpLength = count($mostVisitedPages) >=7 ? 7 : count($mostVisitedPages); 
						 for($i = 0; $i < $mvpLength; $i++)
						 {
							 $mvp = $mostVisitedPages[$i];
							 $u = $mvp['url'];
							$c = $mvp['pageViews'];
				    ?>
                      <tr>
					   
					   <td><em>{{ $u }}</em></td>
					  <td><b>{{ $c }}</b></td>
					  
					 </tr>
					<?php
						 }  
					  }
					  else
					  {
					?>
					 <tr>
                      <td colspan="5">NO DATA AVAILABLE</td>
					  <td></td>
					 </td>
                    <?php					
					  }
                    ?>				               
                            </tbody>
                        </table>                                        

                    </div>				  
				  </div>
				
			   </div>                    
               <div class="block block-drop-shadow">                    
                    <div class="head bg-dot20">
                        <h2>Total orders</h2>
                        <div class="side pull-right">               
                            <ul class="buttons">                                
                                <li><a href="#"><span class="icon-cogs"></span></a></li>
                            </ul>
                        </div>
                        <div class="head-subtitle">Total orders on Ace Luxury Stores</div>                        
                        <div class="head-panel nm tac" style="line-height: 0px;">
                            <div class="knob">
                                <input type="text" data-fgColor="#3F97FE" data-min="0" data-max="100000000" data-width="100" data-height="100" value="{{$stats['o_total']}}" data-readOnly="true" style="font: bold 20px Arial !important;"/>
                            </div>                              
                        </div>
                        <div class="head-panel nm">
                            <div class="hp-info hp-simple pull-left">
                                <span class="hp-main">Today's orders</span>
                                <span class="hp-sm">{{$stats['o_today']}}</span>                                
                            </div>
                            <div class="hp-info hp-simple pull-right">
                                <span class="hp-main">Total orders this month</span>
                                <span class="hp-sm">{{$stats['o_month']}}</span>                                
                            </div>                            
                        </div>
						<div class="head-panel nm" style="padding-top: 5px">
                            <div class="hp-info hp-simple pull-left">
                                <span class="hp-main">Total paid orders</span>
                                <span class="hp-sm">{{$stats['o_paid']}}</span>                                
                            </div>
                            <div class="hp-info hp-simple pull-right">
                                <span class="hp-main">Total unpaid orders</span>
                                <span class="hp-sm">{{$stats['o_unpaid']}}</span>                                
                            </div>                            
                        </div>                        
                    </div>                    
                    
                </div>    				

                <div class="block block-drop-shadow">                    
                        <div class="head bg-dot20">
                        <h2>User carts</h2>
                        
                        <div class="head-subtitle">View user carts that are currently filled with products</div>                        
                        
                        <div class="head-panel nm">
						<br>
						  <?php
						   $cartsCount = count($ccarts);
						   
						  if($cartsCount < 1)
						   {
						  ?>	  
						  <h4>No filled carts yet today.</h4>
					      <?php
						   }
						  else
						  {
						    $ct = "cart";
						    $prepo = "is";
						   
						   if($cartsCount > 1)
						   {
							   $ct = "carts";
							   $prepo = "are";
						   }
						  ?>
							<h4>{{$cartsCount}} {{$ct}} {{$prepo}} currently filled with items.</h4>
                            <a href="{{url('carts')}}" class="btn btn-default btn-block btn-clean" style="margin-top: 5px;">View {{$ct}}</a> 
						  <?php						
						  }
                          ?>               
                        </div>                        
                    </div>                    
                                       
                    
                </div> 
				
				<div class="block block-drop-shadow">                    
                        <div class="head bg-dot20">
                        <h2>Confirm payments</h2>
                        
                        <div class="head-subtitle">Confirm bank payment for multiple orders</div>                        
                        
                        <div class="head-panel nm">
						<br>
						  <?php
						  $uocount = $ordersStats['unpaid'];
						   
						  if($uocount < 1)
						   {
						  ?>	  
						  <h4>No unpaid orders to confirm today.</h4>
					      <?php
						   }
						  else
						  {
						   $ot = "order"; $ct = "payment";
						   
						   if($uocount > 1)
						   {
							   $ot = "orders";
							   $ct = "payments";
						   }
						  ?>
							<h4>{{$uocount}} unpaid {{$ot}} on your website.</h4>
                            <a href="{{url('bcp')}}" class="btn btn-default btn-block btn-clean" style="margin-top: 5px;">Confirm {{$ct}}</a> 
						  <?php						
						  }
                          ?>               
                        </div>                        
                    </div>                    
                                       
                    
                </div> 
				
				<div class="block block-drop-shadow">                    
                   <div class="head bg-dot20">
                      <h2>Upload Products</h2>  
                      <div class="head-subtitle text-warning">Pro tips:</div>                        
                        
                      <div class="head-panel nm">
						  <p>
						  Upload at least 2 images for each product.<br>
						  A good product description should be between 30 to 100 characters long.
						  </p>
					                   
                          <a href="{{url('buup')}}" class="btn btn-default btn-block btn-clean" style="margin-top: 5px;">Upload products</a>						  
                        </div>    
					
                    </div>                    
                                       
                    
                </div>

            </div> 
			<div class="col-md-5">
			   <div class="block block-drop-shadow">
			      <div class="head bg-dot20">
                        <h2>Couriers</h2>
				  <div class="head-panel nm">
						<br>
						  <?php
						   $cr_count = count($couriers);
						   
						  if($cr_count < 1)
						   {
						  ?>	  
						  <h4>No couriers.</h4>
						  <a href="{{url('add-courier')}}" class="btn btn-default btn-block btn-clean" style="margin-top: 5px;">Add a courier</a> 
					      <?php
						   }
						  else
						  {
						    $cct = "courier";
						    $prepo = "is";
						   
						   if($cr_count > 1)
						   {
							   $cct = "couriers";
							   $prepo = "are";
						   }
						  ?>
							<h4>{{$cr_count}} {{$cct}} listed.</h4>
                            <a href="{{url('couriers')}}" class="btn btn-default btn-block btn-clean" style="margin-top: 5px;">View {{$cct}}</a> 
						  <?php						
						  }
                          ?>               
                        </div>
                  </div>
			   </div>  
			   <div class="block block-drop-shadow">
			      <div class="head bg-dot20">
                        <h2>Facebook Catalog</h2>
				  <div class="head-panel nm">
						<br>
						  <?php
						   $catalog = count($catalogs);
						   
						  if($catalog < 1)
						   {
						  ?>	  
						  <h4>No items in your catalog.</h4>
						  <a href="{{url('facebook-catalog')}}" class="btn btn-default btn-block btn-clean" style="margin-top: 5px;">Add products to catalog</a> 
					      <?php
						   }
						  else
						  {
						    $cct = "item";
						    $prepo = "is";
						   
						   if($catalog > 1)
						   {
							   $cct = "items";
							   $prepo = "are";
						   }
						  ?>
							<h4>{{$catalog}} {{$cct}} in your catalog.</h4>
                            <a href="{{url('facebook-catalog')}}" class="btn btn-default btn-block btn-clean" style="margin-top: 5px;">View {{$cct}}</a> 
						  <?php						
						  }
                          ?>               
                        </div>
                  </div>
			   </div>  
               <div class="block block-drop-shadow">                    
                        <div class="head bg-dot20">
                        <h2>Total products</h2>
                        <div class="side pull-right">               
                            <ul class="buttons">                                
                                <li><a href="#"><span class="icon-cogs"></span></a></li>
                            </ul>
                        </div>
                        <div class="head-subtitle">Total products in store</div>                        
                        <div class="head-panel nm tac" style="line-height: 0px;">
                            <div class="knob">
                                <input type="text" data-fgColor="#3F97FE" data-min="0" data-max="100000000" data-width="100" data-height="100" value="{{$stats['total']}}" data-readOnly="true" style="font: bold 20px Arial !important;"/>
                            </div>                              
                        </div>
                        <div class="head-panel nm">
                            <div class="hp-info hp-simple pull-left">
                                <span class="hp-main">Enabled products</span>
                                <span class="hp-sm">{{$stats['enabled']}}</span>                                
                            </div>
                            <div class="hp-info hp-simple pull-right">
                                <span class="hp-main">Disabled products</span>
                                <span class="hp-sm">{{$stats['disabled']}}</span>                                
                            </div>                            
                        </div>                        
                    </div>                    
                                       
                    
                </div>
				
				
				<div class="block block-drop-shadow">                    
                    <div class="head bg-dot20">
                        <h2>Track orders</h2>
                        
                        <div class="head-subtitle">Update tracking info for multiple orders</div>                        
                        
                        <div class="head-panel nm">
						<br>
						  <?php
						  $pocount = $ordersStats['paid'];
						  $uto = $ordersStats['untracked'];
						   
						  if($pocount < 1)
						   {
						  ?>	  
						  <h4>No paid orders to track today.</h4>
					      <?php
						   }
						  else
						  {
						   $ot = "order"; 
						   
						   if($pocount > 1)
						   {
							   $ot = "orders";
						   }
						  ?>
							<h4>{{$pocount}} paid {{$ot}} on your website.</h4>
							<?php
							// $untrackedOrders = $paidOrders->where('current_tracking',null);
						  
						  if($uto > 0)
						  {
						  ?>
						  <h5 style="color:red;">{{$uto}} order(s) have not been tracked yet.</h5>
					      <?php
						  }
						  ?>             
                            <a href="{{url('but')}}" class="btn btn-default btn-block btn-clean" style="margin-top: 5px;">Track {{$ot}}</a> 
						  <?php						
						  }
                          ?>               
                        </div>                      
                    </div>                    
                                       
                    
                </div>
				
				<div class="block block-drop-shadow">                    
                   <div class="head bg-dot20">
                      <h2>Update Products</h2>  
                      <div class="head-subtitle">Update info for multiple products</div>                        
                        
                      <div class="head-panel nm">
						<br>
						  <?php
						  $pcount = count($products);
						  
						   $pt = "product";
						   
						   if($pcount > 1)
						   {
							   $pt = "products";
						   }
						  ?>	  
						  <h4>{{$pcount." ".$pt}} currently on your website.</h4>
						  <?php
						  $lsp = count($lowStockProducts);
						  
						  if($lsp > 0)
						  {
						  ?>
						  <h5 style="color:red;">{{$lsp}} product(s) have below 10 pieces left.</h5>
					      <?php
						  }
						  ?>             
                          <a href="{{url('bup')}}" class="btn btn-default btn-block btn-clean" style="margin-top: 5px;">Update {{$pt}}</a>						  
                        </div>    
					
                    </div>                    
                                       
                    
                </div>
				 
		</div>
@stop