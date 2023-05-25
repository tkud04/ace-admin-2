@extends('layout')

@section('title',"Trackings")

@section('content')
			<div class="col-md-12">
				{!! csrf_field() !!}
				<?php
				$tu = url('new-tracking')."?r=".$r;
				?>
                <div class="block">
                    <div class="header">
                        <h2>Trackings for order #{{$r}}</h2><br>
						<a class="btn btn-primary" href="{{$tu}}">Add tracking</a>
                    </div>
                    <div class="content">
                       <div id="DataTables_Table_2_wrapper" class="dataTables_wrapper" role="grid">
					     
                        <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped sortable">
                            <thead>
                                <tr>
                                    <th width="20%">ID</th>
                                    <th width="20%">Reference #</th>
                                    <th width="20%">Date</th>
                                    <th width="20%">Status</th>                                                                       
                                    <th width="20%">Description</th>                                                                                                                                             
                                </tr>
                            </thead>
                            <tbody>
					<?php
					  if(count($trackings) > 0)
					  {
						 foreach($trackings as $t)
						 {
				    ?>
					 <tr>
					   <td>{{$t['id']}}</td>
					   <td>{{$t['reference']}}</td>
					   <td>{{$t['date']}}</td>
					   <td>{{$t['status']}}</td>
					   <td>{{$t['description']}}</td>
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