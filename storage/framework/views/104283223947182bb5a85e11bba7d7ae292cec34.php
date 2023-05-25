<?php $__env->startSection('title',"Products"); ?>

<?php $__env->startSection('styles'); ?>
  <!-- DataTables CSS -->
  <link href="lib/datatables/css/buttons.bootstrap.min.css" rel="stylesheet" /> 
  <link href="lib/datatables/css/buttons.dataTables.min.css" rel="stylesheet" /> 
  <link href="lib/datatables/css/dataTables.bootstrap.min.css" rel="stylesheet" /> 
<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
    <!-- DataTables js -->
       <script src="lib/datatables/js/datatables.min.js"></script>
    <script src="lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="lib/datatables/js/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="lib/datatables/js/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="lib/datatables/js/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="lib/datatables/js/datatables-init.js?ver=<?php echo e(rand(99,9999)); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
			<div class="col-md-12">
				<?php echo csrf_field(); ?>

                <div class="block">
                    <div class="header">
                        <h2>List of products in the system</h2>
                    </div>
                    <div class="content">
                       <div class="table-responsive" role="grid">
					     
                        <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered ace-table">
                            <thead>
                                <tr>
                                    <th width="30%">Product</th>
                                    <th width="10%">Current qty</th>
                                    <th width="20%">Amount(&#8358;)</th>
                                    <th width="20%">Status</th>                                                                       
                                    <th width="20%">Actions</th>                                                                       
                                </tr>
                            </thead>
                            <tbody>
							   <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							   <?php
							   $sku = $p['sku'];
							   $name = $p['name'];
							    $uu = url('edit-product')."?id=".$sku;
							    $du = url('disable-product')."?id=".$sku;
							    $ddu = url('delete-product')."?id=".$sku;
							   $pd = $p['pd'];
							    $img = $p['imggs'][0];
							   $status = $p['status'];
							   $ss = ($status == "enabled") ? "success" : "danger";
							   ?>
                                <tr>
                                    <td>
									<a href="<?php echo e($uu); ?>" target="_blank">
						             <img class="img img-fluid" src="<?php echo e($img); ?>" alt="<?php echo e($sku); ?>" height="50" width="50" style="margin-bottom: 5px;" />
							         <span><?php echo e($name); ?><br><?php echo e($pd['description']); ?></span>
						            </a><br>
									</td>
                                    <td><?php echo e($p['qty']); ?></td>
                                    <td><?php echo e(number_format($pd['amount'],2)); ?></td>
                                    <td><span class="driver-status label label-<?php echo e($ss); ?>"><?php echo e($status); ?></span></td>                                                                     
                                    <td>
									  <a href="<?php echo e($uu); ?>" class="btn btn-primary">View</button>									  
									  <a href="<?php echo e($du); ?>" class="btn btn-waarning">Disable</button>									  
									  <a href="<?php echo e($ddu); ?>" class="btn btn-danger">Delete</button>									  
									</td>                                                                     
                                </tr>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                       
                            </tbody>
                        </table>                                        

                    </div>
                </div>  
            </div>				
           </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/mac/repos/ace-admin-2/resources/views/products.blade.php ENDPATH**/ ?>