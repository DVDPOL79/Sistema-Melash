<!-- The Modal -->
<div class="modal fade" id="myFiles">

	<div class="modal-dialog modal-dialog-centered modal-fullscreen">
		
		<div class="modal-content rounded me-4">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Archivos</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>

			<!-- Modal body -->
			<div class="modal-body scrollMyFiles">

				<?php include "views/pages/custom/archivos/content/content.php" ?>
				
			</div>

			<!-- Modal footer -->
			<div class="modal-footer d-flex justify-content-between">
				<div>
					<button type="button" class="btn btn-dark rounded" data-bs-dismiss="modal">Cerrar</button>
				</div>
			</div>

		</div>

	</div>

</div>		