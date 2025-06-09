<?php

$urlOffices = "offices?select=id_office,title_office";
$method = "GET";
$fields = array(); 

$offices = CurlController::request($urlOffices,$method,$fields);

if($offices->status == 200){

	$offices = $offices->results;

}else{

	$offices = array();
}

?>

<!-- The Modal -->
<div class="modal fade" id="myOffices">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content rounded">

			<form method="GET">

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Elegir Sucursal</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					
					<div class="form-group mb-3">
							
							<select 
							class="form-select rounded"
							name="offices" 
							id="offices">
								
								<option value="">Elige Sucursal</option>

								<?php if (!empty($offices)): ?>

									<?php foreach ($offices as $key => $value): ?>

										<option value="<?php echo $value->id_office ?>_<?php echo urldecode($value->title_office) ?>"><?php echo urldecode($value->title_office) ?></option>
										
									<?php endforeach ?>
									
								<?php endif ?>

								<?php if ($_SESSION["admin"]->id_office_admin > 0): ?>

									<option value="0_Multi-Sucursal">Multi-Sucursal</option>
									
								<?php endif ?>

							</select>

					</div>

				</div>

				<!-- Modal footer -->
				<div class="modal-footer d-flex justify-content-betwween">
					<div><button type="button" class="btn btn-dark rounded" data-bs-dismiss="modal">Cerrar</button></div>
					<div><button type="submit" class="btn btn-default backColor rounded" >Guardar</button></div>
				</div>

			</form>

		</div>
	</div>
</div>