@extends('layout')

@section('title',"Track Orders")

@section('styles')
  <!-- DataTables CSS -->
  <link href="lib/datatables/css/buttons.bootstrap.min.css" rel="stylesheet" /> 
  <link href="lib/datatables/css/buttons.dataTables.min.css" rel="stylesheet" /> 
  <link href="lib/datatables/css/dataTables.bootstrap.min.css" rel="stylesheet" /> 
@stop


@section('scripts')
    <!-- DataTables js -->
       <script src="lib/datatables/js/datatables.min.js"></script>
    <script src="lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="lib/datatables/js/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="lib/datatables/js/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="lib/datatables/js/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="lib/datatables/js/datatables-init.js"></script>
@stop


@section('content')
			<div class="col-md-12">
				{!! csrf_field() !!}
                <div class="block">
                    <div class="header">
                        <h2>Update tracking info for multiple orders</h2>
                    </div>
                   <div class="content">
					 <div class="table-responsive" role="grid">
					     
                        <table cellpadding="0" cellspacing="0" width="100%" data-idl="3" class="table table-bordered ace-table">
                            <thead>
                                <tr>
                                    <th width="70%">Order</th>
                                    <th width="20%">Status</th>
                                    <th width="10%">
									 <button id="tracking-select-all" onclick="trackingSelectAllOrders()" class="btn btn-success">Select all</button>
									 <button id="tracking-unselect-all" onclick="trackingUnselectAllOrders()" class="btn btn-success">Unselect all</button>
									</th>                                                                                                      
                                </tr>
                            </thead>
                            <tbody>
							   <?php
							   $uss = [];
								 $statuses = ['none' => "Select tracking status",
								              'pickup' => "Scheduled for Pickup",
								              'transit' => "In Transit",
								              'delivered' => "Package delivered",
								              'return' => "Package Returned",
								              'receiver_not_present' => "Receiver Not Present at Delivery Address",
											 ];
							   
							   foreach($orders as $o)
							   {
								 if($o['status'] == "paid")
								 {
								   $items = $o['items'];
								    $statusClass = $o['status'] == "paid" ? "success" : "danger";
								$cs = ($o['current_tracking'] != null) ? $o['current_tracking']['status'] : "none";
								$scs = ($cs == "none") ? "none" : $statuses[$cs];
									
							   ?>
                                <tr>
                                    <td>
									<h6>ACE_{{$o['reference']}}</h6>
									  <?php
						 foreach($items as $i)
						 {
							 $product = $i['product'];
							 $sku = $product['sku'];
							  $img = $product['imggs'][0];
							 $qty = $i['qty'];
							 $pu = url('edit-product')."?id=".$product['sku'];
							 $tu = url('edit-order')."?r=".$o['reference'];
							 $ttu = url('track')."?o=".$o['reference'];
							$du = url('delete-order')."?o=".$o['reference'];
						 ?>
						 
						 <span>
						 <a href="{{$pu}}" target="_blank">
						   <img class="img img-fluid" src="{{$img}}" alt="{{$sku}}" height="40" width="40" style="margin-bottom: 5px;" />
							   {{$sku}}
						 </a> (x{{$qty}})
						 </span><br>
						 <?php
						 }
						?>
									</td>
                                    <td><span class="label label-info sink">{{strtoupper($scs)}}</span></td>
									<td>
									 <div class="btn-group" role="group">
									 <button onclick="trackingSelectOrder({reference: '{{$o['reference']}}'})" id="{{$o['reference']}}" class="btn btn-info r"><span class="icon-check"></span></button>
									 <button onclick="trackingUnselectOrder({reference: '{{$o['reference']}}'})" id="tracking-unselect_{{$o['reference']}}" class="btn btn-warning tracking-unselect"><span class="icon-check-empty"></span></button>
									 </div>
									</td>                                                                     
                                </tr>
                               <?php
							   }
							 }
                               ?>							   
                            </tbody>
                        </table>                                        

                    </div><br>
						   
						   
                            <div class="hp-info hp-simple pull-left">
							<form action="{{url('but')}}" id="but-form" method="post" enctype="multipart/form-data">
							  {!! csrf_field() !!}
							  <input type="hidden" id="dt" name="dt">
							  <input type="hidden" id="action" name="action">
							</form>
                                <span class="hp-main">Update tracking:</span>
                                <div class="hp-sm">
								 <select id="update-tracking-btn">
								
								@foreach($statuses as $key=> $value)
								 <option value="{{$key}}">{{$value}}</option>
								@endforeach
								 </select><br>
								 <h3 id="tracking-select-order-error" class="label label-danger text-uppercase">Please select an order</h3>
								 <h3 id="tracking-select-status-error" class="label label-danger text-uppercase">Please select tracking status</h3>
								 <br>
								 <button onclick="updateTracking()" class="btn btn-default btn-block btn-clean" style="margin-top: 5px;">Submit</button>
								</div>                                
                            </div>
                   </div>  
               </div>				
           </div>
@stop