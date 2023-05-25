@extends('layout')

@section('title',"Orders")

@section('content')
			<div class="col-md-12">
				{!! csrf_field() !!}
                <div class="block">
                    <div class="header">
                        <h2>List of orders in the system</h2>
                    </div>
                    <div class="content">
                       <div id="DataTables_Table_2_wrapper" class="dataTables_wrapper" role="grid">
					     
                        <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped sortable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Reference #</th>
                                    <th>Items</th>
                                     <th>Type</th>
                                    <th>Courier</th>									
                                    <th>Status</th>                                                                       
                                    <th>Actions</th>                                                                       
                                </tr>
                            </thead>
                            <tbody>
							  <?php
					  if(count($orders) > 0)
					  {
						 foreach($orders as $o)
						 {
							 $items = $o['items'];
							 $totals = $o['totals'];
							 $statusClass = $o['status'] == "paid" ? "success" : "danger";
							 $uu = "#";
							 
							 $u = [];
							 
							 if($o['user_id'] == "anon")
							 {
								 $u = $o['anon'];
							 }
							 else
							 {
								 $u = $o['user'];
								 $u['name'] = $u['fname']." ".$u['lname'];
							 }
							 
							  $type = $o['type']; $cr = $o['courier'];
							 $ttype = "";
							 
							 if($type == "card" || $type == "bank")
							 {
								$ttype = "Prepaid (".$type.")";
                                $ttClass = "primary";								
							 } 
							 else if($type == "admin")
							 {
								 $ttype = "Admin";
								 $ttClass = "success";
								 $cr = ['name' => "admin",'price' => "0"];
							 }
							 else if($type == "pod")
							 {
								 $ttype = "Pay on Delivery";
								 $ttClass = "success";
							 } 
				    ?>
                      <tr>
					   <td>{{$o['date']}}</td>
					   <td>{{$o['reference']}}</td>
					    <td>
						<?php
						 foreach($items as $i)
						 {
							 $product = $i['product'];
							 $sku = $product['sku'];
							 $name = $product['name'];
							  $img = $product['imggs'][0];
							 $qty = $i['qty'];
							 $pu = url('edit-product')."?id=".$product['sku'];
							 $tu = url('edit-order')."?r=".$o['reference'];
							 $aru = url('ask-for-review')."?r=".$o['reference'];
							 $ttu = url('track')."?o=".$o['reference'];
							$du = url('delete-order')."?o=".$o['reference'];
						 ?>
						 <span>
						 <a href="{{$pu}}" target="_blank">
						   <img class="img img-fluid" src="{{$img}}" alt="{{$sku}}" height="80" width="80" style="margin-bottom: 5px;" />
							   {{$name}}
						 </a> (x{{$qty}})
						 </span><br>
						 <?php
						 }
						?>
						<b>Total: &#8358;{{number_format($o['amount'],2)}}</b>
					   </td>
                       <td><span class="label label-{{$ttClass}}">{{strtoupper($ttype)}}</span></td>		  
					   <td><b>{{$cr['name']}}</b> (&#8358;{{number_format($cr['price'],2)}})</td>					   
					   <td>
					      <span class="label label-{{$statusClass}}">{{strtoupper($o['status'])}}</span>
						  
						  @if($o['status'] == "unpaid" && count($u) > 0)
							  <br>Contact customer:<br>
							  <em>{{$u['name']}}</em><br>
							  Phone: <a href="tel:{{$u['phone']}}"><em>{{$u['phone']}}</em></a><br>
							  Email: <a href="mailto:{{$u['email']}}"><em>{{$u['email']}}</em></a><br>
						  @endif
					   </td>
					   <td>
					   <div style="margin-bottom: 2px; !important;">
					     <a class="btn btn-primary" href="{{$tu}}">View</a>&nbsp;&nbsp;
					     <a class="btn btn-warning" href="{{$aru}}">Ask for review</a>&nbsp;&nbsp;
						</div>
						<div>
						<a class="btn btn-info" href="{{$ttu}}">Track</a>&nbsp;&nbsp;
					     <a class="btn btn-danger" href="{{$du}}">Delete</a>
						 </div>
					   </td>
					 </tr>
					<?php
						 }  
					  }
                    ?>				               
                            </tbody>
                        </table>                                        

                    </div>
                </div>  
            </div>				
           </div>
@stop