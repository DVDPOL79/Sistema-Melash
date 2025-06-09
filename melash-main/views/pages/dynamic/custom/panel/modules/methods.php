<div class="container mt-4 px-0" id="payMethods" <?php if (empty($order)): ?> style="display:none"  <?php endif ?>>
	
	<h6>Método de Pago</h6>

	<div class="row row-cols-1 row-cols-3">
		
		<div class="col">
			
			<div class="card rounded btn bg-pink payMethod" method="efectivo">
				<div class="card-body text-center">
					<i class="bi bi-cash-coin"></i>
					<br>
					Efectivo
				</div>
			</div>

		</div>

		<div class="col">
			
			<div class="card rounded btn bg-info payMethod" method="transferencia">
				<div class="card-body text-center">
					<i class="bi bi-qr-code-scan"></i>
					<br>
					Transferencia
				</div>
			</div>

		</div>

		<div class="col">
			
			<div class="card rounded btn bg-success payMethod" method="tarjeta">
				<div class="card-body text-center">
					<i class="bi bi-credit-card-fill"></i>
					<br>
					 Tarjeta
				</div>
			</div>

		</div>


	</div>


</div>