<!-- =======================================
Modal para agregar cliente
==========================================-->

<div class="modal fade" id="modalClient">

	<div class="modal-dialog modal-dialog-centered">
		
		<div class="modal-content rounded">
			
			<div class="modal-header">
				<h4 class="modal-title">Agregar Cliente</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>	
			</div>

			<div class="modal-body">
				
				<div class="row row-cols-1 row-cols-sm-2  my-3">
				  
				  <div class="col">

				  	<div class="form-floating">
				  		
				  		<input type="text" class="form-control changeFormClient rounded" id="name_client" placeholder="Ingresar Nombre">
				  		<label for="name_client">Nombre</label>

				  	</div>

				  </div>

				  <div class="col">

				  	<div class="form-floating">
				  		
				  		<input type="text" class="form-control changeFormClient rounded" id="surname_client" placeholder="Ingresar Apellido">
				  		<label for="surname_client">Apellido</label>
				  		
				  	</div>

				  </div>

				</div>

				<div class="row row-cols-1 row-cols-sm-2  my-3">
				  
				  <div class="col">

				  	<div class="form-floating">
				  		
				  		<input type="text" class="form-control changeFormClient rounded" id="dni_client" placeholder="Ingresar Documento">
				  		<label for="dni_client">Documento</label>

				  	</div>

				  </div>

				  <div class="col">

				  	<div class="form-floating">
				  		
				  		<input type="email" class="form-control changeFormClient rounded" id="email_client" placeholder="Ingresar Correo">
				  		<label for="email_client">Correo Electrónico</label>
				  		
				  	</div>

				  </div>

				</div>

				<div class="row row-cols-1 row-cols-sm-2  my-3">
				  
				  <div class="col">

				  	<div class="form-floating">
				  		
				  		<input type="text" class="form-control changeFormClient rounded" id="phone_client" placeholder="Ingresar Teléfono">
				  		<label for="phone_client">Teléfono</label>

				  	</div>

				  </div>

				  <div class="col">

				  	<div class="form-floating">
				  		
				  		<input type="text" class="form-control changeFormClient rounded" id="address_client" placeholder="Ingresar Dirección">
				  		<label for="address_client">Dirección</label>
				  		
				  	</div>

				  </div>

				</div>

			</div>

			<div class="modal-footer d-flex justify-content-between">
				
				<div>
					<button type="button" class="btn btn-default border rounded" data-bs-dismiss="modal">Cerrar</button>
				</div>
				<div>
					<button type="button" class="btn btn-default backColor rounded" id="btnAddClient">Guardar</button>
				</div>
			</div>

		</div>

	</div>
	
</div>

<!-- =======================================
Modal para métodos de pago
==========================================-->

<div class="modal fade" id="modalPayMethod">

	<div class="modal-dialog modal-dialog-centered">
		
		<div class="modal-content rounded">

			<form method="POST" action="/pos">
			
				<div class="modal-header">
					<h4 class="modal-title">Pago <span id="typePay"></span></h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>	
				</div>

				<div class="modal-body">

					<input type="hidden" id="idOrderPay" name="idOrderPay">
					<input type="hidden" id="methodPay" name="methodPay">
					<input type="hidden" id="transferPay" name="transferPay">

					<!--====================================================
          			Método de pago en efectivo
          			=====================================================-->
					
					<div class="allMethods" id="methodCash" style="display:none">
						
						<div class="row row-cols-1 row-cols-sm-2">
						 	
						 	<div class="col">
						 		
						 		<div class="form-floating mb-3 mt-3">
						 			
						 			<input type="number" class="form-control rounded form-control-lg" id="totalPayCash" readonly>
						 			<label ifor="totalPayCash">$ Total a Pagar</label>

						 		</div>

						 	</div>

						 	<div class="col">
						 	 	
						 		<div class="form-floating mb-3 mt-3">

				                  <input type="text" class="form-control rounded form-control-lg" id="cashPay" placeholder="Ingresa el monto">
				                  <label for="cashPay">$ Efectivo</label>

				                </div>

						 	</div>

						</div>

						<div class="row row-cols-1">
							
							<div class="col">
								
								<div class="form-floating mb-3 mt-3">
				                  <input type="text" class="form-control rounded form-control-lg" id="returnPay" readonly>
				                  <label for="returnPay">$ Cambio</label>

				                </div>

							</div>	

						</div>

					</div>

					<!--====================================================
          			Método de pago en transferencia
          			=====================================================-->
					
					<div class="allMethods" id="methodTransfer" style="display:none">
						
						<div class="row row-cols-1 row-cols-sm-2">
						 	
						 	<div class="col">
						 		
						 		<div class="form-floating mb-3 mt-3">
					                <input type="number" class="form-control rounded form-control-lg" id="totalPayTransfer" readonly>
					                <label for="totalPayTransfer">$ Total a Pagar</label>
					             </div>

						 	</div>

						 	<div class="col">

				                <div class="form-floating mb-3 mt-3">
				                  <input type="text" class="form-control rounded form-control-lg" id="idTransferPay" placeholder="Ingresa el id de la transferencia">
				                  <label for="idTransferPay">ID Transfer</label>
				                </div>

			              </div>

						</div>

					</div>

					<!--====================================================
          			Método de pago con tarjeta
          			=====================================================-->
					
					<div class="allMethods" id="methodCard" style="display:none">
						
						<div class="row">
						 	
							<div class="col">
								
								<div class="form-floating mb-3 mt-3">
				                  <input type="number" class="form-control rounded form-control-lg" id="totalPayCard" readonly>
				                  <label for="totalPayCard">$ Total a Pagar</label>
				                </div>

							</div>

						</div>

						<div class="d-flex justify-content-center flex-wrap align-content-center" style="height:100px">
							
							<div class="w-100 text-center">
				                <span class="spinner-border spinner-border-lg"></span>
			              	</div>

			               <div>En proceso de validación...</div>

						</div>

					</div>

					<!--====================================================
          			Cliente Facturador
          			=====================================================-->
					<div class="form-check my-2">
					  <input class="form-check-input" type="checkbox" id="emitirInvoice" name="emitirInvoice" value="yes">
					  <label class="form-check-label ps-1 mt-1">Emitir Factura</label>
					</div>
					<div class="form-check my-2" id="clientInvoiceContainer" style="display: none;">
  						<input class="form-check-input" type="checkbox" id="clientInvoice" name="clientInvoice" value="yes">
 						 <label class="form-check-label ps-1 mt-1">Cliente Facturador Electrónico</label>
					</div>		
					

					


				</div>

				<div class="modal-footer d-flex justify-content-between">
					
					<div>
						<button type="button" class="btn btn-default border rounded" data-bs-dismiss="modal">Cerrar</button>
					</div>
					<div>
						<button type="submit" class="btn btn-default backColor rounded">Guardar</button>
					</div>
				</div>

			</form>

		</div>

	</div>
	
</div>

<!-- =======================================
Modal para buscar órdenes
==========================================-->

<div class="modal fade" id="modalSearchOrder">
	
	<div class="modal-dialog modal-xl modal-dialog-centered">
		
		<div class="modal-content rounded">
			
			<div class="modal-header">
				<h4 class="modal-title">Buscar Orden</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>

			<div class="modal-body">
				
				<?php 

				$url = "relations?rel=modules,pages&type=module,page&linkTo=id_module&equalTo=14";
				$method = "GET";
				$fields = array();

				$module = CurlController::request($url,$method,$fields);

				if($module->status == 200){

					$module = $module->results[0];
					include "views/pages/dynamic/tables/tables.php";

				}else{

					$module = array();
				}

				?>

			</div>

			<div class="modal-footer">
		        <button type="button" class="btn btn-default border rounded" data-bs-dismiss="modal">Cerrar</button>
	      	</div>

		</div>

	</div>

</div>

