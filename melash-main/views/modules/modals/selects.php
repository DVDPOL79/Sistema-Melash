<!-- The Modal -->
<div class="modal fade" id="mySelects">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content rounded">

			<form method="POST" class="needs-validation" novalidate>

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Cambiar selección</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">

					<div class="form-group mb-3">
						
						<select  
						class="form-select rounded" 
						id="valueSelect"
						name="valueSelect"
						>

						

						</select>

						<div class="valid-feedback">Válido.</div>
						<div class="invalid-feedback">Campo inválido.</div>

					</div>	

				</div>

				<!-- Modal footer -->
				<div class="modal-footer d-flex justify-content-between">
					<div><button type="button" class="btn btn-dark rounded" data-bs-dismiss="modal">Cerrar</button></div>
					<div><button type="button" class="btn btn-default backColor rounded changeSelects">Guardar</button></div> 
				</div>

			</form>

		</div>
	</div>
</div>