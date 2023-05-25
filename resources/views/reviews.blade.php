@extends('layout')

@section('title',"Product Reviews")

@section('content')
			<div class="col-md-12">
				{!! csrf_field() !!}
                <div class="block">
                    <div class="header">
                        <h2>List of product reviews</h2>
                    </div>
                    <div class="content">
                       <div id="DataTables_Table_2_wrapper" class="dataTables_wrapper" role="grid">
					     
                        <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped sortable">
                            <thead>
                                <tr>
                                    <th width="20%">ID</th>
                                    <th width="20%">Product</th>
                                    <th width="20%">Review</th>                                                                       
                                    <th width="20%">Status</th>                                                                       
                                    <th width="20%">Actions</th>                                                                       
                                </tr>
                            </thead>
                            <tbody>
							   @foreach($reviews as $r)
							   <?php
                           	   $name = $r['name'];
                           	   $sku = $r['sku'];
	                            $review = $r['review'];
	                            $status = $r['status'];
	                            $rating = $r['rating'];
	                            $status = $r['status'];
	                            $pu = url('edit-product?id=').$sku;
								$ss = ($status == "enabled") ? "success" : "danger";
							   ?>
                                <tr>
                                    <td>{{$r['id']}}</td>
                                    <td><a href="{{$pu}}" target="_blank">{{$sku}}</a></td>
                                    <td><b>{{$name}}</b>: {{$review}}</td>
                                     <td><span class="driver-status label label-{{$ss}}">{{$status}}</span></td>                                                                      
                                    <td>
									  <?php
									   $uu = url('edit-review')."?id=".$r['id'];
									   
									  ?>
									  <a href="{{$uu}}" class="btn btn-primary">View</button>									  
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