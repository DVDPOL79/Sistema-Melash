<!-- The Modal -->
<div class="modal fade" id="myBooleans">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content rounded">

			<form method="POST" class="needs-validation" novalidate>

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Cambiar estado</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">

					<div class="form-group mb-3">
						
						<select  
						class="form-select rounded" 
						id="valueBoolean"
						name="valueBoolean"
						>

						<option value="0">False</option>
						<option value="1">True</option>

						</select>

						<div class="valid-feedback">Válido.</div>
						<div class="invalid-feedback">Campo inválido.</div>

					</div>	

				</div>

				<!-- Modal footer -->
				<div class="modal-footer d-flex justify-content-between">
					<div><button type="button" class="btn btn-dark rounded" data-bs-dismiss="modal">Cerrar</button></div>
					<div><button type="button" class="btn btn-default backColor rounded changeBooleans">Guardar</button></div> 
				</div>

			</form>

		</div>
	</div>
</div>