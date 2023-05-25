@extends('layout')

@section('title',"Banners")

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
                                    <th width="30%">Image</th>
                                    <th width="10%">Role</th>                                                                       
                                    <th width="20%">Status</th>                                                                       
                                    <th width="20%">Actions</th>                                                                       
                                </tr>
                            </thead>
                            <tbody>
							   @foreach($banners as $b)
							   <?php
                           	    $imgg = $b['img'];
	                            $subtitle = $b['subtitle'];
	                            $title = $b['title'];
	                            $status = $b['status'];
							   ?>
                                <tr>
                                    <td>{{$b['id']}}</td>
                                    <td><img src="{{$imgg}}" width="750" height="250">{{$imgg}}</a></td>
                                    <td>Random</td>                                                                     
                                    <td>{{$status}}</td>                                                                     
                                    <td>
									  <?php
									   $uu = url('edit-banner')."?id=".$b['id'];
									   $du = url('delete-img')."?xf=".$b['id'];
									   
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