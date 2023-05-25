@extends('layout')

@section('title',"Products")

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
    <script src="lib/datatables/js/datatables-init.js?ver={{rand(99,9999)}}"></script>
@stop

@section('content')
			<div class="col-md-12">
				{!! csrf_field() !!}
                <div class="block">
                    <div class="header">
                        <h2>List of products in the system</h2>
                    </div>
                    <div class="content">
                       <div class="table-responsive" role="grid">
					     
                        <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered ace-table">
                            <thead>
                                <tr>
                                    <th width="30%">Product</th>
                                    <th width="10%">Current qty</th>
                                    <th width="20%">Amount(&#8358;)</th>
                                    <th width="20%">Status</th>                                                                       
                                    <th width="20%">Actions</th>                                                                       
                                </tr>
                            </thead>
                            <tbody>
							   @foreach($products as $p)
							   <?php
							   $sku = $p['sku'];
							   $name = $p['name'];
							    $uu = url('edit-product')."?id=".$sku;
							    $du = url('disable-product')."?id=".$sku;
							    $ddu = url('delete-product')."?id=".$sku;
							   $pd = $p['pd'];
							    $img = $p['imggs'][0];
							   $status = $p['status'];
							   $ss = ($status == "enabled") ? "success" : "danger";
							   ?>
                                <tr>
                                    <td>
									<a href="{{$uu}}" target="_blank">
						             <img class="img img-fluid" src="{{$img}}" alt="{{$sku}}" height="50" width="50" style="margin-bottom: 5px;" />
							         <span>{{$name}}<br>{{$pd['description']}}</span>
						            </a><br>
									</td>
                                    <td>{{$p['qty']}}</td>
                                    <td>{{number_format($pd['amount'],2)}}</td>
                                    <td><span class="driver-status label label-{{$ss}}">{{$status}}</span></td>                                                                     
                                    <td>
									  <a href="{{$uu}}" class="btn btn-primary">View</button>									  
									  <a href="{{$du}}" class="btn btn-waarning">Disable</button>									  
									  <a href="{{$ddu}}" class="btn btn-danger">Delete</button>									  
									</td>                                                                     
                                </tr>
                               @endforeach                       
                            </tbody>
                        </table>                                        

                    </div>
                </div>  
            </div>				
           </div>
@stop
