<?php 

$url = "clients";
$method = "GET";
$fields = array();

$clients = CurlController::request($url,$method,$fields);

if($clients->status == 200){

	$clients = $clients->results;

}else{

	$clients = array();
}

 ?>


<div class="row mb-4">
	
	<div class="col-7">
		
		<div class="form-group">
			
			<label class="mb-1" for="clientList">Cliente</label>
			<span class="btn badge badge-default border-0 float-end rounded bg-purple <?php if (empty($order)): ?>
 d-none <?php endif ?>" id="addClient">Agregar</span>

			<select class="form-control rounded-start custom-select select2" id="clientList">
				
				<option value="">Buscar</option>

				<?php if (!empty($clients)): ?>

					<?php foreach ($clients as $key => $value): ?>

						<?php if (!empty($order)): ?>

							<option value="<?php echo $value->id_client ?>" <?php if ($order->id_client_order == $value->id_client): ?> selected <?php endif ?>><?php echo urldecode($value->name_client)." ".urldecode($value->surname_client)." ".urldecode($value->dni_client) ?></option>

						<?php else: ?>

							<option value="<?php echo $value->id_client ?>"><?php echo urldecode($value->name_client)." ".urldecode($value->surname_client)." ".urldecode($value->dni_client) ?></option>

						<?php endif ?>			
						
					<?php endforeach ?>
					
				<?php endif ?>

			</select>

		</div>

	</div>

	<div class="col-5">
		
		<div class="form-group">
			
			<label class="mb-1" for="seller">Vendedor</label>

			<div class="input-group">
				
				<input type="text" readonly class="form-control rounded-start bg-light" id="seller" idAdmin="<?php echo $_SESSION["admin"]->id_admin ?>" value="<?php echo urldecode($_SESSION["admin"]->name_admin) ?>">
				<span class="input-group-text rounded-end bg-light"><i class="fas fa-user-tie"></i></span>
			</div>

		</div>

	</div>	



</div>