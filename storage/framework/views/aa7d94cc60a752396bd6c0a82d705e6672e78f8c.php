  <?php
  $signal = $signals['okays'];
   $class = "alert-warning";   
           
   if($val == "error"){
   	$signal = $signals['errors'];
   	$class = "alert-danger";         
       $pop .= "-error";
   } 
  ?>                
  <div class="alert <?php echo e($class); ?>" role="alert">
     <p><?php if($val == "error"): ?><strong>Whoops!</strong> <?php endif; ?> <?php echo e($signal[$pop]); ?></p>
     <button class="close" data-dismiss="alert">x</button>
     <div class="clearfix"></div>
     <br><br>                      
  </div><?php /**PATH /Users/mac/repos/ace-admin-2/resources/views/session-status.blade.php ENDPATH**/ ?>