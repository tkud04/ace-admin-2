@extends('layout')

@section('title',"Couriers")

@section('content')
			<div class="col-md-12">
				{!! csrf_field() !!}
                <div class="block">
                    <div class="header">
                        <h2>List of courier services used by the system</h2>
                        <a class="pull-right btn btn-clean" href="{{url('add-courier')}}">Add</a>
                    </div>
                    <div class="content">
                       <div id="DataTables_Table_2_wrapper" class="dataTables_wrapper" role="grid">
					     
                        <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped sortable">
                            <thead>
                                <tr>                                  
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Coverage</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
							  <?php
							  
					  if(count($couriers) > 0)
					  {
						 foreach($couriers as $c)
						 {
							 $name = $c['name'];
							 $type = ""; $coverage = "";
							 
							 if($c['type'] == "prepaid") $type = "Prepaid";
							 else if($c['type'] == "pod") $type = "Pay on Delivery";
							 
							 if($c['coverage'] == "lagos") $coverage = "Lagos state";
							 else if($c['coverage'] == "sw") $coverage = "Southwest states";
							 else if($c['coverage'] == "others") $coverage = "Other states";
							 else if($c['coverage'] == "fct") $coverage = strtoupper($c['coverage']);
							 else $coverage = ucwords($c['coverage'])." state";
							 
							 $price = $c['price'];
							 $vu = url('courier')."?xf=".$c['id'];
							$ru = url('remove-courier')."?xf=".$c['id'];
							
							$ss = $c['status'] == "enabled" ? "label-info" : "label-warning";
							 
							
				    ?>
                      <tr>
					   
					   <td>{{ $name }}</td>
					   <td>{{ $type }}</td>
					   <td>{{ $coverage }}</td>
					  <td>&#8358;{{number_format($price)}}</code></td>
					  <td>				   
					    <h3 class="label {{$ss}}">{{strtoupper($c['status'])}}</h3>
					  </td>
					   <td>
						<a class="btn btn-default btn-clean" href="{{$vu}}">View</a>
						<a class="btn btn-default btn-clean" href="{{$ru}}">Remove</a>
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