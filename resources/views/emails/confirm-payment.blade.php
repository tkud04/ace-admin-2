<?php
 $totals = $order['totals'];
 $items = $order['items'];
 $itemCount = $totals['items'];
 $uu = "http://www.aceluxurystore.com/anon-order?ref=".$order['reference'];
 $tu = "http://www.aceluxurystore.com/track?o=".$order['reference'];
   $cr = $order['courier'];
?>
<center><img src="http://www.aceluxurystore.com/images/logo.png" width="150" height="150"/></center>
<h3 style="background: #ff9bbc; color: #fff; padding: 10px 15px;">{{$subject}}</h3>
Hello {{$name}},<br> please be informed that your payment for the above mentioned order has been confirmed. See the details below:<br><br>
Reference #: <b>{{$order['reference']}}</b><br>
Type: <b>{{$order['type']}}</b><br>
Customer: <b>{{$name}}</b><br>
Customer contact: <b>{{$phone}} | {{$user}}</b><br>
Notes: <b>{{$order['notes']}}</b><br><br>
<?php
foreach($items as $i)
{
	$product = $i['product'];
	$sku = $product['sku'];
	$name = $product['name'];
	$qty = $i['qty'];
	$pu = url('product')."?sku=".$product['sku'];
	$img = $product['imggs'][0];
	
?>

<a href="{{$pu}}" target="_blank">
  <img style="vertical-align: middle;border:0;line-height: 20px;" src="{{$img}}" alt="{{$sku}}" height="80" width="80" style="margin-bottom: 5px;"/>
	  {{$name}}
</a> (x{{$qty}})<br>
<?php
}
?>
Total: <b>&#8358;{{number_format($order['amount'],2)}}</b><br><br>
@if($order['type'] == "pod")
Part payment made: <b>&#8358;{{number_format($order['amount'] /2,2)}}</b><br><br>
Outstanding balance: <b>&#8358;{{number_format($order['amount'] /2,2)}}</b><br><br>
@endif


<h6>Shipping Details</h6>
@if(isset($cr['name']))<p><b>{{$cr['name']}}</b> (&#8358;{{number_format($cr['price'],2)}})</p>@endif
<p>Address: {{$shipping['address']}}</p>
<p>City: {{$shipping['city']}}</p>
<p>State: {{$shipping['state']}}</p><br><br>
<h5 style="background: #ff9bbc; color: #fff; padding: 10px 15px;">Next steps</h5>

<p>Click the <b>View Order</b> button below to view the order or <b>Track Order</b> button to update delivery information. Alternatively you can log in to the Admin Dashboard to view or update tracking info for this order (go to Orders and click either the View or Track buttons beside the order).</p><br>
<p style="color:red;"><b>NOTE:</b> The tracking status for this order is currently marked as <b>PENDING</b>, kindly update delivery information for this order.</p><br><br>

<a href="{{$uu}}" target="_blank" style="background: #ff9bbc; color: #fff; padding: 10px 15px; margin-right: 10px;">View order</a>
<a href="{{$tu}}" target="_blank" style="background: #ff9bbc; color: #fff; padding: 10px 15px; margin-right: 10px;">Track order</a>
<br><br>
