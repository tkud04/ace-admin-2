@extends('layout')

@section('title',"Ads")

@section('content')
			<div class="col-md-12">
				{!! csrf_field() !!}
                <div class="block">
                    <div class="header">
                        <h2>List of ads</h2>
                    </div>
                    <div class="content">
                       <div id="DataTables_Table_2_wrapper" class="dataTables_wrapper" role="grid">
					     
                        <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped sortable">
                            <thead>
                                <tr>
                                    <th width="20%">ID</th>
                                    <th width="20%">Ad</th>
                                    <th width="20%">Type</th>
                                    <th width="20%">Status</th>                                                                       
                                    <th width="20%">Actions</th>                                                                       
                                </tr>
                            </thead>
                            <tbody>
							   @foreach($ads as $a)
							   <?php
							   $status = $a['status'];
							   $imgg = $a['img'];
							   $ss = ($status == "enabled") ? "success" : "danger";
							   ?>
                                <tr>
                                    <td>{{$a['id']}}</td>
                                    <td><a href="{{$imgg}}" target="_blank">{{$imgg}}</a></td>
                                    <td>{{$a['type']}}</td>
                                    <td><span class="driver-status label label-{{$ss}}">{{$status}}</span></td>                                                                     
                                    <td>
									  <?php
									   $uu = url('edit-ad')."?id=".$a['id'];
									   
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