@extends('layout')

@section('title',"Carts")

@section('content')
			<div class="col-md-12">
				{!! csrf_field() !!}
                <div class="block">
                    <div class="header">
                        <h2>List of current non empty carts in the system</h2>
                    </div>
                    <div class="content">
                       <div id="DataTables_Table_2_wrapper" class="dataTables_wrapper" role="grid">
					     
                        <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped sortable">
                            <thead>
                                <tr>                                  
                                    <th width="20%">User</th>
                                    <th width="20%">Items</th>
                                </tr>
                            </thead>
                            <tbody>
							  <?php
							  
					  if(count($ccarts) > 0)
					  {
						 foreach($ccarts as $cc)
						 {
							 $uuser = $cc['user'];
							 $cart = $cc['data'];
							 
							$u = "Guest";
							
							if(count($uuser) > 0)
                            {
                            	$u = $uuser['fname']." ".$uuser['lname'];
                                $u .= "<br> Contact details: ".$uuser['phone']." | ".$uuser['email'];
                           }
				    ?>
                      <tr>
					   
					   <td>{!! $u !!}</td>
					    <td>
						<?php
						 foreach($cart as $c)
						 {
							 $product = $c['product'];
							 $sku = $product['sku'];
							 $name = $product['name'];
							  $img = $product['imggs'][0];
							 $qty = $c['qty'];
							 $pu = url('edit-product')."?id=".$product['sku'];
						 ?>
						 <span>
						 <a href="{{$pu}}" target="_blank">
						   <img class="img img-fluid" src="{{$img}}" alt="{{$sku}}" height="80" width="80" style="margin-bottom: 5px;" />
							   {{$sku." - ".$name}}
						 </a> (x{{$qty}})
						 </span><br>
						 <?php
						 }
						?>
						<b>Added on {{$c['date']}}</b>
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