<?php 

if(!empty($order)){

	$totalProducts = 0;

	$url = "relations?rel=sales,products&type=sale,product&linkTo=id_order_sale&equalTo=".$order->id_order;
  	$method = "GET";
  	$fields = array();

  	$getSales = CurlController::request($url,$method,$fields);

  	if($getSales->status == 200){

  		$sales = $getSales->results;

  		foreach ($sales as $key => $value) {
  			$totalProducts += $value->qty_sale;
  		}
  	
  	}else{

  		$sales = array();
  	}

}else{

  	$sales = array();
}

?>

<div class="container mt-3 px-0">
	
	<h6 class="float-start">Productos Añadidos 
		<span class="badge badge-default	<?php if (empty($order)): ?> bg-light <?php else: ?> backColor <?php endif ?>  rounded" id="countProduct">
			<?php if (!empty($order)): ?>
				<?php echo $totalProducts ?>
			<?php else: ?>
				0
			<?php endif ?>
		</span>
	</h6>

	<span class="float-end text-orange <?php if (empty($order)): ?> d-none <?php endif ?>  btn" id="cleanListProduct" <?php if (!empty($order)): ?>idOrder="<?php echo $order->id_order ?>"<?php else: ?> idOrder <?php endif ?>><i class="fas fa-broom"></i> limpiar</span>

	<div class="clearfix"></div>

	<table class="table table-striped table-borderless">
		
		<thead>
			
			<tr class="text-center">
				<th>Producto</th>
				<th>Cantidad</th>
				<th>Subtotal</th>
				<th>Acciones</th>
			</tr>
		</thead>

		<tbody id="addProduct">

			<?php if (!empty($sales) && !empty($order)): ?>

				<?php foreach ($sales as $key => $value): 

					$url = "purchases?linkTo=id_product_purchase&equalTo=".$value->id_product."&select=price_purchase";

					 $original_price = CurlController::request($url,$method,$fields)->results[0]->price_purchase;
				?>

					<tr>
				
						<td>
							<div>
								<img src="<?php echo urldecode($value->img_product) ?>" class="me-auto rounded mt-2 float-start"style="width:60px !important; height:60px !important">

								<div class="ms-2 float-start">
									
									<span class="badge badge-default backColor rounded" style="font-size:10px"><?php echo urldecode($value->sku_product) ?></span>

									<?php if ($value->discount_product > 0):

										$price_purchase = $original_price-($original_price*($value->discount_product/100));

									?>

										<span class="badge badge-default bg-red rounded ms-1" style="font-size:10px"><?php echo $value->discount_product ?>%</span>

										<h6 class="font-weight-bold  mb-0 text-muted"><strong><?php echo urldecode($value->title_product) ?></strong></h6>
										<small>$ <?php echo number_format($price_purchase,2) ?> <span class="ms-1 text-red" style="font-size:12px"><s>$ <?php echo  number_format($original_price,2) ?></s></span></small>

									<?php else: 

										$price_purchase = $original_price;
									?>

										<h6 class="font-weight-bold  mb-0 text-muted"><strong><?php echo urldecode($value->title_product) ?></strong></h6>
										<small>$ <?php echo  number_format($price_purchase,2) ?></small>
										
									<?php endif ?>

									
								</div>
							</div>
						</td>

						<td class="text-center">

							<div class="d-flex justify-content-center">
								
								<div class="input-group mb-3 mt-2" style="width:160px">
									
									<span class="input-group-text rounded-start bg-light btnQty" type="btnMin" style="cursor:pointer" key="<?php echo $value->id_product ?>">
										<i class="bi bi-dash-lg"></i>
									</span>

									<input type="number" class="form-control text-center showQuantity showQuantity_<?php echo $value->id_product ?>" key="<?php echo $value->id_product ?>" value="<?php echo $value->qty_sale ?>" style="font-size:12px">

									<span class="input-group-text rounded-end bg-light btnQty" type="btnMax" style="cursor:pointer" key="<?php echo $value->id_product ?>">
										<i class="bi bi-plus-lg"></i>
									</span>

								</div>
							</div>
							
						</td>

						<td>
							<h6 class="text-center my-3 pricePurchase pricePurchase_<?php echo $value->id_product ?>" pricePurchase="<?php echo $value->subtotal_sale ?>" originalPricePurchase="<?php echo $original_price ?>">$ <?php echo number_format($value->subtotal_sale,2) ?></h6>
						</td>

						<td class="text-center">
							<button type="button" class="btn btn-sm rounded ms-1 mt-2 py-2 px-3 bg-red deleteSale deleteSale_<?php echo $value->id_product ?>" idSale="<?php echo$value->id_sale ?>" taxSale="<?php echo explode("_",$value->tax_product)[1] ?>" discountSale="<?php echo $value->discount_product ?>">
								<i class="bi bi-trash"></i>
							</button>
						</td>
					</tr>
					
				<?php endforeach ?>
				
			<?php endif ?>
			
		

		</tbody>

	</table>

</div>