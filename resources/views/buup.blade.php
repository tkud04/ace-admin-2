@extends('layout')

@section('title',"Upload Products")

@section('styles')
  <!-- DataTables CSS -->
  <link href="lib/datatables/css/buttons.bootstrap.min.css" rel="stylesheet" /> 
  <link href="lib/datatables/css/buttons.dataTables.min.css" rel="stylesheet" /> 
  <link href="lib/datatables/css/dataTables.bootstrap.min.css" rel="stylesheet" /> 
@stop


@section('scripts')
<script>
 $(document).ready(() =>{
 $('.buup-hide').hide();
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
let categories = [], buupCounter = 0;
 
 @foreach($c as $cc)
 	@if($cc['status'] == "enabled")
	  categories.push("{{$cc['category']}}");
	@endif
 @endforeach
</script>
			<div class="col-md-12">
				<input type="hidden" id="tk" value="{{csrf_token()}}">
                <div class="block">
                    <div class="header">
                        <h2>Upload multiple products</h2><br>
                        <h4 style="margin:20px; padding: 10px; border: 1px dashed #fff; with: 50%;"><span class="label label-success text-uppercase">Tip:</span> Click the radio button beside an image to set it as the cover image</h4>
                    </div>
                   <div class="content">
				    <form action="{{url('buup')}}" id="buup-form" method="post" enctype="multipart/form-data">
					  {!! csrf_field() !!}
					 <div class="table-responsive" role="grid">
					     
                        <table id="buup-table" cellpadding="0" cellspacing="0" width="100%" data-idl="3" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>SKU</th>
                                    <th>Product name</th>
                                    <th width="30%">Description</th>
                                    <th>Price(&#8358;)</th>
                                    <th>Current stock</th>
                                    <th>Category</th>
									<th>Status</th>
                                    <th width="20%">Images</th>
                                    <th>Actions</th>                                                                                                      
                                </tr>
                            </thead>
                            <tbody>
							   							   
                            </tbody>
                        </table>                                        

                    </div><br>
					
					 <div class="hp-info hp-simple pull-left">
					      
							
							  <input type="hidden" id="buup-dt" name="dt">
							 
                                <div class="hp-sm" id="button-box">
								 <button onclick="BUUPAddRow(); return false;" class="btn btn-default btn-block btn-clean" style="margin-top: 5px;">Add new product</button>
							
								 <h3 id="buup-select-product-error" class="label label-danger text-uppercase buup-hide mr-5 mb-5">Please add a new product</h3>
								 <h3 id="buup-select-validation-error" class="label label-danger text-uppercase buup-hide">All fields are required</h3>
								 <br>
								 <button onclick="BUUP(); return false;" class="btn btn-default btn-block btn-clean" style="margin-top: 5px;">Submit</button>
								</div>
								<div class="hp-sm" id="result-box">
								 <h4 id="buup-loading">Uploading products <img src="img/loading.gif" class="img img-fluid" alt="Loading" width="50" height="50"></h4><br>
								 <h5>Products uploaded: <span class="label label-success" id="result-ctr">0</span></h5>
								</div>
                                <div class="hp-sm" id="finish-box">
								 <h4>Upload complete!</h4>
								</div>                                
                       </div>
					  </form>
                   </div>  
               </div>				
           </div>
@stop