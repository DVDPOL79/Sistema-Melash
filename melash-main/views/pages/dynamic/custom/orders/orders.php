<?php 

if(isset($_GET["order"])){

	$url = "orders?linkTo=transaction_order&equalTo=".$_GET["order"];
	$method = "GET";
	$fields = array();

	$getOrder = CurlController::request($url,$method,$fields);

	if($getOrder->status == 200){

		if($getOrder->results[0]->status_order == "Completada"){

			$order = null;

			echo '<script>

				fncSweetAlert("error","Esta orden ya ha sido completada y no se puede editar", "/");

			</script>';

			return;
		}

		$order = $getOrder->results[0];
		
	}else{

		$order = null;

	}

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

  <button type="button" class="btn btn-default rounded backColor newOrder"><i class="bi bi-cart4"></i> Crear Orden</button>
  <button type="button" class="btn btn-default rounded bg-orange mx-1 removeOrder" <?php if (!empty($order)): ?>idOrder="<?php echo $order->id_order ?>"<?php else: ?> idOrder <?php endif ?>><i class="fas fa-broom"></i> Remover Orden</button>
  <button type="button" class="btn btn-default rounded bg-teal" data-bs-toggle="modal" data-bs-target="#modalSearchOrder"><i class="bi bi-search"></i> Buscar Orden</button>


</div>