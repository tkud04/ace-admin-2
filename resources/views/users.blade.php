@extends('layout')

@section('title',"Users")

@section('content')
			<div class="col-md-12">
				{!! csrf_field() !!}
                <div class="block">
                    <div class="header">
                        <h2>List of users in the system</h2>
                    </div>
                    <div class="content">
                       <div id="DataTables_Table_2_wrapper" class="dataTables_wrapper" role="grid">
					     
                        <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped sortable">
                            <thead>
                                <tr>
                                    <th width="30%">Name</th>
                                    <th width="10%">Email</th>
                                    <th width="20%">Phone number</th>
                                    <th width="20%">Status</th>                                                                       
                                    <th width="20%">Actions</th>                                                                       
                                </tr>
                            </thead>
                            <tbody>
							   @foreach($users as $u)
							   <?php
							   $name = $u['fname']." ".$u['lname'];
							   $email = $u['email'];
							   $phone = $u['phone'];
							    $uu = url('user')."?id=".$u['id'];
							    $action = ($u['status'] == "enabled") ? "disable" : "enable";
							    $statusColor = ($u['status'] == "enabled") ? "warning" : "success";
								$du = url('edu')."?id=".$u['id']."&action=".$action;
							   $status = $u['status'];
							   $ss = ($status == "enabled") ? "success" : "danger";
							   ?>
                                <tr>
                                    <td>
									{{$name}}
									</td>
                                    <td>{{$email}}</td>
                                    <td>{{$phone}}</td>
                                    <td><span class="driver-status label label-{{$ss}}">{{$status}}</span></td>                                                                     
                                    <td>
									  <a href="{{$uu}}" class="btn btn-primary">View</button>									  
									  <a href="{{$du}}" class="btn btn-{{$statusColor}}">{{ucwords($action)}}</button>									  
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