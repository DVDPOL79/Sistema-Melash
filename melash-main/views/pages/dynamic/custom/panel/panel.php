<!--==============================
Custom
 ================================-->

<div class="<?php if ($module->width_module == "100"): ?> col-lg-12 <?php endif ?><?php if ($module->width_module == "75"): ?> col-lg-9 <?php endif ?><?php if ($module->width_module == "50"): ?> col-lg-6 <?php endif ?><?php if ($module->width_module == "33"): ?> col-lg-4 <?php endif ?><?php if ($module->width_module == "25"): ?> col-lg-3 <?php endif ?> col-12 mb-3 position-relative">

	<?php if ($_SESSION["admin"]->rol_admin == "superadmin"): ?>

		<div class="position-absolute border rounded bg-white" style="top:0px; right:12px; z-index:100">
			
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

  	<?php if (!empty($order)): ?>

	<div class="card-header backColor rounded-top" id="orderHeader" mode="on" idOrder="<?php echo $order->id_order ?>">
  		<h6 class="card-title mt-2 float-start">Orden # <?php echo $order->transaction_order ?></h6>
  	</div>

  	<?php else: ?>

	<div class="card-header bg-light rounded-top" id="orderHeader" mode="off" idOrder>
  		<h6 class="card-title mt-2 float-start">Orden # 0000000000</h6>
  	</div>
  		
  	<?php endif ?>
  	
  	

  	<div class="card-body">
  		

  		<?php 

  		include "modules/client.php";
  		include "modules/list.php";
  		include "modules/totals.php";
  		include "modules/methods.php";

  		require_once "controllers/orders.controller.php";
  		$order = new OrdersController();
  		$order -> manageOrder();

  		include "modules/modals.php";
  		
  		?>

  	</div>

  </div>


</div>