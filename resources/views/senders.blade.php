@extends('layout')

@section('title',"Senders")

@section('content')
			<div class="col-md-12">
				{!! csrf_field() !!}
                <div class="block">
                    <div class="header">
                        <h2>List of SMTP senders used by the system</h2>
                        <a class="pull-right btn btn-clean" href="{{url('add-sender')}}">Add</a>
                    </div>
                    <div class="content">
                       <div id="DataTables_Table_2_wrapper" class="dataTables_wrapper" role="grid">
					     
                        <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped sortable">
                            <thead>
                                <tr>                                  
                                    <th>Host</th>
                                    <th>Login</th>
                                    <th>Current sender</th>
									
                                    
                                </tr>
                            </thead>
                            <tbody>
							  <?php
							  
					  if(count($senders) > 0)
					  {
						 foreach($senders as $s)
						 {
							 $ss = $s['ss'];
							$su = $s['su'];
							$vu = url('sender')."?s=".$s['id'];
							$ru = url('remove-sender')."?s=".$s['id'];
							$mu = url('mark-sender')."?s=".$s['id'];
							 
							
				    ?>
                      <tr>
					   
					   <td>{!! $ss !!}</td>
					  <td>{!! $su !!}</td>
					  <td>
					   @if($s['current'] == "yes")
					    <h3 class="label label-info">CURRENT</h3>
					   @else
						 <a class="btn btn-default btn-block btn-clean" href="{{$mu}}">Set as current</a>
				       @endif
					  </td>
					   <td>
						<a class="btn btn-default btn-block btn-clean" href="{{$vu}}">View</a>
						<a class="btn btn-default btn-block btn-clean" href="{{$ru}}">Remove</a>
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