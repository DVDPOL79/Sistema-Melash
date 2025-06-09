<?php 

$productSale = array();
$topProducts = array();

if($_SESSION["admin"]->id_office_admin > 0){

	$url = "sales?linkTo=id_office_sale&equalTo=".$_SESSION["admin"]->id_office_admin."&select=id_product_sale,qty_sale";

}else{

	$url = "sales?select=id_product_sale,qty_sale";

}


$method = "GET";
$fields = array();

$bestProduct = CurlController::request($url,$method,$fields);

if($bestProduct->status == 200){

	/*=============================================
	Creamos los índices del array
	=============================================*/

	foreach ($bestProduct->results as $key => $value) {
		
		$productSale[$value->id_product_sale] = 0;
		
	
	}

	/*=============================================
	Agregamos los valores del array
	=============================================*/

	foreach ($bestProduct->results as $key => $value) {

		$productSale[$value->id_product_sale] += $value->qty_sale;
	
	}

	arsort($productSale);

	$topProducts = array_slice($productSale, 0, 5, true);

}

?>

<!--==============================
Custom
 ================================-->

<div class="<?php if ($module->width_module == "100"): ?> col-lg-12 <?php endif ?><?php if ($module->width_module == "75"): ?> col-lg-9 <?php endif ?><?php if ($module->width_module == "50"): ?> col-lg-6 <?php endif ?><?php if ($module->width_module == "33"): ?> col-lg-4 <?php endif ?><?php if ($module->width_module == "25"): ?> col-lg-3 <?php endif ?> col-12 mb-3 position-relative">

	<?php if ($_SESSION["admin"]->rol_admin == "superadmin"): ?>

		<div class="position-absolute border rounded" style="top:0px; right:12px; z-index:100">
			
			<button type="button" class="btn btn-sm text-muted rounded m-0 px-1 py-0 border-0 myModule" item='<?php echo json_encode($module) ?>' idPage="<?php echo $page->results[0]->id_page ?>">
				<i class="bi bi-pencil-square"></i>
			</button>

			<button type="button" class="btn btn-sm text-muted rounded m-0 px-1 py-0 border-0 deleteModule" idModule=<?php echo base64_encode($module->id_module) ?> >
				<i class="bi bi-trash"></i>
			</button>


		</div>
		
	<?php endif ?>

	<!--==============================
   Start Custom
  ================================-->

  <div class="card rounded">
  	
  	 <div class="card-header">
        <h3 class="card-title">Productos más vendidos</h3>
      </div>

      <div class="card-body">

      	<?php if (!empty($topProducts)): ?>

      		<ul class="list-group">
      			
      			<?php foreach ($topProducts as $key => $value): ?>

      				<?php 

      				$url = "relations?rel=products,categories&type=product,category&linkTo=id_product&equalTo=".$key."&select=sku_product,img_product,title_product,title_category";
      				$listProducts = CurlController::request($url,$method,$fields)->results[0];	
  
      				?>

      				<li class="list-group-item">
      					
      					<div class="d-flex border-bottom">
      						
      						<div class="flex-fill w-100 text-center">
      							
      							<img src="<?php echo urldecode($listProducts->img_product) ?>" class="img-fluid" style="width:50px">

      						</div>

      						<div class="flex-fill w-100 text-center">
      							
      							<span class="badge badge-default backColor rounded small mt-2"><?php echo urldecode($listProducts->sku_product) ?></span>

      						</div>

      						<div class="flex-fill w-100 text-center">
      							
      							<p class="mt-2"><?php echo urldecode($listProducts->title_product) ?></p>
      							
      						</div>

      						<div class="flex-fill w-100 text-center">
      							
      							<p class="mt-2"><?php echo urldecode($listProducts->title_category) ?></p>
      							
      						</div>

      						<div class="flex-fill w-100 text-center">
      							
      							<span class="badge badge-default bg-orange rounded small mt-2"><?php echo $value ?></span>

      						</div>

      					</div>

      				</li>
	
      			<?php endforeach ?>

      		</ul>
      		
      	<?php endif ?>

      

      </div>


  </div>


</div>