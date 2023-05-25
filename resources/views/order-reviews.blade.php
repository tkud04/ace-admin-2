@extends('layout')

@section('title',"Order Reviews")

@section('content')
			<div class="col-md-12">
				{!! csrf_field() !!}
                <div class="block">
                    <div class="header">
                        <h2>List of order reviews</h2>
                    </div>
                    <div class="content">
                       <div id="DataTables_Table_2_wrapper" class="dataTables_wrapper" role="grid">
					     
                        <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped sortable">
                            <thead>
                                <tr>
                                    <th width="20%">ID</th>
                                    <th width="20%">Order</th>
                                    <th width="20%">Review</th>                                                                       
                                    <th width="20%">Status</th>                                                                       
                                    <th width="20%">Actions</th>                                                                       
                                </tr>
                            </thead>
                            <tbody>
							   @foreach($reviews as $r)
							   <?php
                           	   $ref = $r['reference'];
                           	  
								if($r['status'] == "pending" || $r['status'] == "disabled")
								{
									$ss =  "Enable";
									$sss = "enabled";
									$ssc = "warning";
								}
								else{
									$ss =  "Disable";
									$sss = "disabled";
									$ssc = "success";
								}
	                            $pu = url('update-order-review')."?xf=".$ref."&status=".$sss;
								
							   ?>
                                <tr>
                                    <td>{{$r['id']}}</td>
                                    <td>{{$ref}}</td>
                                    <td>
									  <b>Came as advertised</b>: {{$r['caa']}}<br>
									  <b>Delivered on time</b>: {{$r['daa']}}<br>
									  <b>Comment</b>: {{$r['comment']}}<br>
									</td>
                                     <td><span class="driver-status label label-{{$ssc}}">{{$r['status']}}</span></td>                                                                      
                                    <td>
									  <a href="{{$pu}}" class="btn btn-primary">{{$ss}}</button>									  
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