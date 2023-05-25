@extends('layout')

@section('title',"Add Orders")

@section('styles')
  <!-- DataTables CSS -->
  <link href="lib/datatables/css/buttons.bootstrap.min.css" rel="stylesheet" /> 
  <link href="lib/datatables/css/buttons.dataTables.min.css" rel="stylesheet" /> 
  <link href="lib/datatables/css/dataTables.bootstrap.min.css" rel="stylesheet" /> 
@stop


@section('scripts')
<script>
 $(document).ready(() =>{
 $('.bao-hide').hide();
 localStorage.clear();
 
 });
 </script>

    <!-- DataTables js -->
       <script src="lib/datatables/js/datatables.min.js"></script>
    <script src="lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="lib/datatables/js/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="lib/datatables/js/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="lib/datatables/js/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="lib/datatables/js/datatables-init.js"></script>
@stop

@section('content')
<script>
let categories = [], products = [], orders = [], states = [],
   customerTypes = [], users = [], baoCounter = 0, orderCount = 0;
 
 @foreach($c as $cc)
 	@if($cc['status'] == "enabled")
	  categories.push("{{$cc['category']}}");
	@endif
 @endforeach

 @foreach($products as $p)
 	@if($cc['status'] == "enabled")
	  products.push({
		  sku: "{{$p['sku']}}", 
		  img: "{{$p['imggs'][0]}}", 
		  qty: "{{$p['qty']}}", 
		  amount: "{{$p['pd']['amount']}}", 
		  category: "{{$p['pd']['category']}}", 
		  });
	@endif
 @endforeach

 @foreach($users as $u)
 <?php
  $state = (count($u['sd']) < 1) ? "lagos" : $u['sd']['state'];
 ?>
 	@if($u['status'] == "enabled")
	  users.push({
		  id: "{{$u['id']}}", 
		  name: "{{$u['fname']}} {{$u['lname']}}", 
		  email: "{{$u['email']}}" ,
		  state: "{{ucwords($state)}}" 
		  });
	@endif
 @endforeach
 
 @foreach($states as $key => $value)
	  states.push({
		  key: "{{$key}}", 
		  name: "{{$value}}" 
		  });
 @endforeach
 
 customerTypes = [
  {key:"user",value:"Registered user"},
  {key:"anon",value:"Guest"}
 ];
 
 let ddData = [];
	
	 products.map(p => {
		ddData.push({
		   text: p.sku,
           value: p.sku,
		   qty: p.qty,
           selected: false,
           description: p.sku + " (N" + p.amount + ") | " + p.qty + " pcs left",
           imageSrc: p.img
		});
	 });
</script>
			<div class="col-md-12">
				<input type="hidden" id="tk" value="{{csrf_token()}}">
                <div class="block">
                    <div class="header">
                        <h2>Add new orders</h2><br>
                        <h4 style="margin:20px; padding: 10px; border: 1px dashed #fff; with: 50%;"><span class="label label-success text-uppercase">Tip:</span> Use the <em>Products</em> widget to add products to your order. It can be used mutliple times.</h4>
                    </div>
                   <div class="content">
				    <form action="{{url('new-order')}}" id="bao-form" method="post" enctype="multipart/form-data">
					  {!! csrf_field() !!}
					 <div class="table-responsive" role="grid">
					     
                        <table id="bao-table" cellpadding="0" cellspacing="0" width="100%" data-idl="3" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Reference</th>
                                    <th width="30%">Customer</th>
                                    <th>Products</th>
                                    <th>Notes</th>
                                    <th>Total(&#8358;)</th>
                                    <th>Actions</th>                                                                                                      
                                </tr>
                            </thead>
                            <tbody>
							   							   
                            </tbody>
                        </table>                                        

                    </div><br>
					
					 <div class="hp-info hp-simple pull-left">
					      
							
							  <input type="hidden" id="bao-dt" name="dt">
							 
                                <div class="hp-sm" id="button-box">
								 <button onclick="BAOAddRow(); return false;" class="btn btn-default btn-block btn-clean" style="margin-top: 5px;">Add new order</button>
							
								 <h3 id="bao-select-order-error" class="label label-danger text-uppercase bao-hide mr-5 mb-5">Please add a new order</h3>
								 <h3 id="bao-select-validation-error" class="label label-danger text-uppercase bao-hide">All fields are required</h3>
								 <br>
								 <button onclick="BAO(); return false;" class="btn btn-default btn-block btn-clean" style="margin-top: 5px;">Submit</button>
								</div>
								<div class="hp-sm" id="result-box">
								 <h4 id="bao-loading">Adding orders.. <img src="img/loading.gif" class="img img-fluid" alt="Loading" width="50" height="50"></h4><br>
								 <h5>Orders added: <span class="label label-success" id="result-ctr">0</span></h5>
								</div>
                                <div class="hp-sm" id="finish-box">
								 <h4>Processing complete!</h4>
								</div>                                
                       </div>
					  </form>
                   </div>  
               </div>				
           </div>
@stop