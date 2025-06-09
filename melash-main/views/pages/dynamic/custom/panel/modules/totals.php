<?php 

if(!empty($order)){

	$subtotal = round($order->subtotal_order);
	$discount = round($order->discount_order);
	$tax = round($order->tax_order);
	$granTotal = round($order->total_order);

}else{

	$subtotal = 0;
	$discount = 0;
	$tax = 0;
	$granTotal = 0;
}



 ?>



<div class="card rounded">
	
	<ul class="list-group p-3">
		
		<li class="list-group-item bg-transparent border-bottom">
			
			<span class="float-start">Subtotal</span>
			<span class="float-end">$ <span id="subtotal" subtotal="<?php echo $subtotal ?>"><?php echo number_format($subtotal,2) ?></span></span>

		</li>

		<li class="list-group-item bg-transparent border-bottom">
			
			<span class="float-start">Descuento</span>
			<span class="float-end">$ <span id="discount" discount="<?php echo $discount ?>"><?php echo number_format($discount,2) ?></span></span>
			
		</li>

		<li class="list-group-item bg-transparent border-bottom">
			
			<span class="float-start">Impuesto</span>
			<span class="float-end">$ <span id="tax" tax="<?php echo $tax ?>"><?php echo number_format($tax,2) ?></span></span>
			
		</li>

	</ul>

</div>

<h6 class="text-center px-3 py-4 my-3 rounded border-0 w-100 font-weight-bold <?php if (empty($order)): ?> bg-light <?php else: ?> backColor <?php endif ?>" id="granTotal">Gran Total: $ <span granTotal="<?php echo $granTotal ?>"><?php echo number_format($granTotal,2) ?></span></h6>