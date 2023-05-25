
<!DOCTYPE html>
<html lang="en">
<head>        
    <title><?php echo $__env->yieldContent('title'); ?> | Admin Dashboard - Ace Luxury Stores NG</title>
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <link rel="icon" type="image/png" href="img/favicon.png" sizes="16x16">  
    <link href="css/stylesheets.css" rel="stylesheet" type="text/css">
	
	<?php echo $__env->yieldContent('styles'); ?>
    
    <script type='text/javascript' src='js/plugins/jquery/jquery.min.js'></script>
    <script type='text/javascript' src='js/plugins/jquery/jquery-ui.min.js'></script>
	    <script type='text/javascript' src='js/plugins/bootstrap/bootstrap.min.js'></script>
    <script type='text/javascript' src='js/plugins/jquery/jquery-migrate.min.js'></script>
    <script type='text/javascript' src='js/plugins/jquery/globalize.js'></script>    
    <script type='text/javascript' src='lib/ddSlick/jquery.ddslick.min.js'></script>    
    <!--SweetAlert--> 
    <link href="lib/sweet-alert/sweetalert2.css" rel="stylesheet">
    <script src="lib/sweet-alert/sweetalert2.js"></script>

    <script type='text/javascript' src='js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js'></script>
    <script type='text/javascript' src='js/plugins/uniform/jquery.uniform.min.js'></script>
        <script type='text/javascript' src='js/plugins/fancybox/jquery.fancybox.pack.js'></script>
		
    <script type='text/javascript' src='js/plugins/knob/jquery.knob.js'></script>
    <script type='text/javascript' src='js/plugins/sparkline/jquery.sparkline.min.js'></script>
    <script type='text/javascript' src='js/plugins/flot/jquery.flot.js'></script>     
    <script type='text/javascript' src='js/plugins/flot/jquery.flot.resize.js'></script>
    
    <script type='text/javascript' src='js/plugins.js'></script>    
    <script type='text/javascript' src='js/actions.js'></script>    
    <script type='text/javascript' src='js/charts.js'></script>
    <script type='text/javascript' src='js/settings.js'></script>
    <script type='text/javascript' src="js/helper.js?ver=<?php echo e(rand(99,9999)); ?>"></script>
    <script type='text/javascript' src='js/custom.js?ver=<?php echo e(rand(99,9999)); ?>'></script>
	
	<?php echo $__env->yieldContent('scripts'); ?>
    
</head>
<body class="bg-img-num1" data-settings="open"> 
    
	
        	<?php
			  // Session notifications
               $pop = ""; $val = "";
               
               if(isset($signals))
               {
                  foreach($signals['okays'] as $key => $value)
                  {
                    if(session()->has($key))
                    {
                  	$pop = $key; $val = session()->get($key);
                    }
                 }
              }
              
             ?> 

                 <?php if($pop != "" && $val != ""): ?>
                   <?php echo $__env->make('session-status',['pop' => $pop, 'val' => $val], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                 <?php endif; ?>
				 
        	<?php // Input errors ?>
                    <?php if(count($errors) > 0): ?>
                          <?php echo $__env->make('input-errors', ['errors'=>$errors], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                     <?php endif; ?> 
  
	
    <div class="container">        
        <div class="row">                   
            <div class="col-md-12">
                
                 <nav class="navbar brb" role="navigation">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-reorder"></span>                            
                        </button>                                                
                        <a class="navbar-brand" href="<?php echo e(url('/')); ?>"><img src="img/icon.png" width="32" height="28"/></a>                                                                                     
                    </div>
                    <div class="collapse navbar-collapse navbar-ex1-collapse">                                     
                        <ul class="nav navbar-nav">
                            <li class="active">
                                <a href="<?php echo e(url('/')); ?>">
                                    <span class="icon-home"></span> dashboard
                                </a>
                            </li>                            
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-pencil"></span> users</a>
                                <ul class="dropdown-menu">                                    
                                    <li><a href="<?php echo e(url('users')); ?>"> View users</a></li>
                                </ul>                                
                            </li>
							<li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-pencil"></span> products</a>
                                <ul class="dropdown-menu">                                    
                                    <li><a href="<?php echo e(url('products')); ?>"> View products</a></li>
                                    <li><a href="<?php echo e(url('buup')); ?>"> Add new product</a></li>
                                </ul>                                
                            </li>
							<li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-pencil"></span> discounts</a>
                                <ul class="dropdown-menu">                                    
                                    <li><a href="<?php echo e(url('discounts')); ?>"> View discounts</a></li>
                                    <li><a href="<?php echo e(url('new-discount')); ?>"> Add new discount</a></li>
                                </ul>                                
                            </li>
							<li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-pencil"></span> orders</a>
                                <ul class="dropdown-menu">                                    
                                    <li><a href="<?php echo e(url('orders')); ?>"> View orders</a></li>
                                    <li><a href="<?php echo e(url('reports')); ?>"> View reports</a></li>
                                    <li><a href="<?php echo e(url('new-order')); ?>"> Add new order</a></li>
                                </ul>                                
                            </li>
							<li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-pencil"></span> categories</a>
                                <ul class="dropdown-menu">                                    
                                    <li><a href="<?php echo e(url('categories')); ?>"> View categories</a></li>
                                    <li><a href="<?php echo e(url('add-category')); ?>"> Add new category</a></li>
                                </ul>                                
                            </li>
							<li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-pencil"></span> banners</a>
                                <ul class="dropdown-menu">                                    
                                    <li><a href="<?php echo e(url('banners')); ?>"> View banners</a></li>
                                    <li><a href="<?php echo e(url('new-banner')); ?>"> Add new banner</a></li>
                                </ul>                                
                            </li>
							<li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-pencil"></span> ads</a>
                                <ul class="dropdown-menu">                                    
                                    <li><a href="<?php echo e(url('ads')); ?>"> View ads</a></li>
                                    <li><a href="<?php echo e(url('new-ad')); ?>"> Add new ad</a></li>
                                </ul>                                
                            </li>
							<li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-pencil"></span> reviews</a>
                                <ul class="dropdown-menu">                                    
                                    <li><a href="<?php echo e(url('reviews')); ?>"> View product reviews</a></li>
                                    <li><a href="<?php echo e(url('order-reviews')); ?>"> View order reviews</a></li>
                                </ul>                                
                            </li>
							<li>
                                <a href="<?php echo e(url('settings')); ?>"><span class="icon-pencil"></span> settings</a>
                            </li>
                                                       
                        </ul>
                        <form class="navbar-form navbar-right" role="search" action="<?php echo e(url('search')); ?>" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="search..."/>
                            </div>                            
                        </form>                                            
                    </div>
                </nav>                

            </div>            
        </div>
        <div class="row">
         <?php echo $__env->yieldContent('content'); ?>  
            
        </div>
        <div class="row">
            <div class="page-footer">
                <div class="page-footer-wrap">
                    <div class="side pull-left">
                        copyright &copy;<?php echo e(date("Y")); ?> Ace Luxury Store, all rights reserved.
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html><?php /**PATH /Users/mac/repos/ace-admin-2/resources/views/layout.blade.php ENDPATH**/ ?>