@extends('layout')

@section('title',"Confirm Payments")

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
                        <h2>Confirm bank payment for multiple orders</h2>
                    </div>
                   <div class="content">
						  <div class="table-responsive" role="grid">
					     
                        <table cellpadding="0" cellspacing="0" width="100%" data-idl="3" class="table table-bordered ace-table">
                            <thead>
                                <tr>
                                    <th>Actions</th>
                                    <th width="50%">Order</th>
                                    <th width="20%">Type</th>
                                    <th width="20%">Status</th>
                                    <th width="10%">
									<div class="btn-group" role="group">
									 <button id="cp-select-all" onclick="cpSelectAllOrders()" class="btn btn-success">Select all</button>
									 <button id="cp-unselect-all" onclick="cpUnselectAllOrders()" class="btn btn-warning">Unselect all</button>
									 </div>
									</th>                                                                                                      
                                </tr>
                            </thead>
                            <tbody>
							   <?php
							   $uss = [];
							   
							   foreach($orders as $o)
							   {
								 if($o['status'] == "unpaid" || $o['status'] == "pod")
								 {
								   $items = $o['items'];
                                                                   $type = $o['type'];

								    $statusClass = $type == "pod" ? "warning": "danger";
                                                                    $sts = $type == "pod" ? "paid 50%": $o['status'];
									
									
									if($type == "card" || $type == "bank")
							        {
								      $ttype = "Prepaid (".$type.")";
                                      $ttClass = "primary";								
							        } 
							        else if($type == "pod")
							        {
								      $ttype = "Pay on Delivery";
								      $ttClass = "success";
							        } 
									
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
                                                          $du = url('delete-order')."?o=".$o['reference'];
									
							   ?>
                                <tr>
                                   <td>
					    			         <a class="btn btn-danger" href="{{$du}}">Delete</span>
								        </td>
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
									<td><span class="label label-{{$ttClass}} sink">{{strtoupper($ttype)}}</span></td>
                                    <td>
									  <span class="label label-{{$statusClass}} sink">{{strtoupper($sts)}}</span>
									  <br>Contact customer:<br>
							          <em>{{$u['name']}}</em><br>
							          Phone: <a href="tel:{{$u['phone']}}"><em>{{$u['phone']}}</em></a><br>
							          Email: <a href="mailto:{{$u['email']}}"><em>{{$u['email']}}</em></a><br>
									</td>
									<td>
									 <div class="btn-group" role="group">
									 <button onclick="cpSelectOrder({reference: '{{$o['reference']}}'})" id="cp-{{$o['reference']}}" class="btn btn-info cp"><span class="icon-check"></span></button>
									 <button onclick="cpUnselectOrder({reference: '{{$o['reference']}}'})" id="cp-unselect_{{$o['reference']}}" class="btn btn-warning cp-unselect"><span class="icon-check-empty"></span></button>
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
							<form action="{{url('bcp')}}" id="bcp-form" method="post" enctype="multipart/form-data">
							  {!! csrf_field() !!}
							  <input type="hidden" id="cp-dt" name="dt">
							  <input type="hidden" id="cp-action" name="action">
							</form>
                                <span class="hp-main">Select action:</span>
                                <div class="hp-sm">
								 <select id="cp-btn">
								  <option value="none">Select action</option>
								  <option value="confirm">Confirm payment</option>
								 </select><br>
								 <h3 id="cp-select-order-error" class="label label-danger text-uppercase">Please select an order</h3>
								 <h3 id="cp-select-status-error" class="label label-danger text-uppercase">Please select action</h3>
								 <br>
								 <button onclick="updateBankPayments()" class="btn btn-default btn-block btn-clean" style="margin-top: 5px;">Submit</button>
								</div>                                
                            </div>
                   </div>  
               </div>				
           </div>
@stop
