@extends('layout')

@section('title',"Discounts")

@section('content')
			<div class="col-md-12">
				{!! csrf_field() !!}
                <div class="block">
                    <div class="header">
                        <h2>List of discounts</h2>
                    </div>
                    <div class="content">
                       <div id="DataTables_Table_2_wrapper" class="dataTables_wrapper" role="grid">
					     
                        <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped sortable">
                            <thead>
                                <tr>
                                    <th width="20%">Code</th>
                                    <th width="20%">Type</th>
                                    <th width="20%">Discount</th>
                                    <th width="20%">Status</th>                                                                       
                                    <th width="20%">Actions</th>                                                                       
                                </tr>
                            </thead>
                            <tbody>
							   @foreach($discounts as $d)
							   <?php
							   $status = $d['status'];
							   $ss = ($status == "enabled") ? "success" : "danger";
							   $disc = "";
							   $dtype = "";
							   
							   if($d['discount_type'] == "flat")
							   {
								   $disc = "&#8358;".$d['discount'];
							   }
							   elseif($d['discount_type'] == "percentage")
							   {
								   $disc = $d['discount']."%";
							   }
							   
							   if($d['type'] == "single")
							   {
								   $dtype = strtoupper($d['type'])." - ".$d['uid'];
							   }
							   elseif($d['type'] == "category")
							   {
								   $c = $d['category'];
								   $dtype = strtoupper($d['type'])." - ".$c['name'];
							   }
							   elseif($d['type'] == "general")
							   {
								   $dtype = strtoupper($d['type']);
							   }
							   ?>
                                <tr>
                                    <td>{{$d['code']}}</td>
                                    <td>{{$dtype}}</td>
                                    <td>{!!$disc!!}</td>
                                    <td><span class="driver-status label label-{{$ss}}">{{$status}}</span></td>                                                                     
                                    <td>
									  <?php
									   $uu = url('edit-discount')."?d=".$d['id'];
									   $du = url('delete-discount')."?xf=".$d['id'];
									   
									  ?>
									  <a href="{{$uu}}" class="btn btn-primary">View</button>									  
									  <a href="{{$du}}" class="btn btn-danger">Delete</button>									  
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