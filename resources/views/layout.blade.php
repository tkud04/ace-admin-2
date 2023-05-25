
<!DOCTYPE html>
<html lang="en">
<head>        
    <title>@yield('title') | Admin Dashboard - Ace Luxury Stores NG</title>
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <link rel="icon" type="image/png" href="img/favicon.png" sizes="16x16">  
    <link href="css/stylesheets.css" rel="stylesheet" type="text/css">
	
	@yield('styles')
    
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
    <script type='text/javascript' src="js/helper.js?ver={{rand(99,9999)}}"></script>
    <script type='text/javascript' src='js/custom.js?ver={{rand(99,9999)}}'></script>
	
	@yield('scripts')
    
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

                 @if($pop != "" && $val != "")
                   @include('session-status',['pop' => $pop, 'val' => $val])
                 @endif
				 
        	<?php // Input errors ?>
                    @if (count($errors) > 0)
                          @include('input-errors', ['errors'=>$errors])
                     @endif 
  
	
    <div class="container">        
        <div class="row">                   
            <div class="col-md-12">
                
                 <nav class="navbar brb" role="navigation">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-reorder"></span>                            
                        </button>                                                
                        <a class="navbar-brand" href="{{url('/')}}"><img src="img/icon.png" width="32" height="28"/></a>                                                                                     
                    </div>
                    <div class="collapse navbar-collapse navbar-ex1-collapse">                                     
                        <ul class="nav navbar-nav">
                            <li class="active">
                                <a href="{{url('/')}}">
                                    <span class="icon-home"></span> dashboard
                                </a>
                            </li>                            
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-pencil"></span> users</a>
                                <ul class="dropdown-menu">                                    
                                    <li><a href="{{url('users')}}"> View users</a></li>
                                </ul>                                
                            </li>
							<li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-pencil"></span> products</a>
                                <ul class="dropdown-menu">                                    
                                    <li><a href="{{url('products')}}"> View products</a></li>
                                    <li><a href="{{url('buup')}}"> Add new product</a></li>
                                </ul>                                
                            </li>
							<li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-pencil"></span> discounts</a>
                                <ul class="dropdown-menu">                                    
                                    <li><a href="{{url('discounts')}}"> View discounts</a></li>
                                    <li><a href="{{url('new-discount')}}"> Add new discount</a></li>
                                </ul>                                
                            </li>
							<li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-pencil"></span> orders</a>
                                <ul class="dropdown-menu">                                    
                                    <li><a href="{{url('orders')}}"> View orders</a></li>
                                    <li><a href="{{url('reports')}}"> View reports</a></li>
                                    <li><a href="{{url('new-order')}}"> Add new order</a></li>
                                </ul>                                
                            </li>
							<li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-pencil"></span> categories</a>
                                <ul class="dropdown-menu">                                    
                                    <li><a href="{{url('categories')}}"> View categories</a></li>
                                    <li><a href="{{url('add-category')}}"> Add new category</a></li>
                                </ul>                                
                            </li>
							<li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-pencil"></span> banners</a>
                                <ul class="dropdown-menu">                                    
                                    <li><a href="{{url('banners')}}"> View banners</a></li>
                                    <li><a href="{{url('new-banner')}}"> Add new banner</a></li>
                                </ul>                                
                            </li>
							<li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-pencil"></span> ads</a>
                                <ul class="dropdown-menu">                                    
                                    <li><a href="{{url('ads')}}"> View ads</a></li>
                                    <li><a href="{{url('new-ad')}}"> Add new ad</a></li>
                                </ul>                                
                            </li>
							<li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-pencil"></span> reviews</a>
                                <ul class="dropdown-menu">                                    
                                    <li><a href="{{url('reviews')}}"> View product reviews</a></li>
                                    <li><a href="{{url('order-reviews')}}"> View order reviews</a></li>
                                </ul>                                
                            </li>
							<li>
                                <a href="{{url('settings')}}"><span class="icon-pencil"></span> settings</a>
                            </li>
                                                       
                        </ul>
                        <form class="navbar-form navbar-right" role="search" action="{{url('search')}}" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="search..."/>
                            </div>                            
                        </form>                                            
                    </div>
                </nav>                

            </div>            
        </div>
        <div class="row">
         @yield('content')  
            
        </div>
        <div class="row">
            <div class="page-footer">
                <div class="page-footer-wrap">
                    <div class="side pull-left">
                        copyright &copy;{{date("Y")}} Ace Luxury Store, all rights reserved.
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>