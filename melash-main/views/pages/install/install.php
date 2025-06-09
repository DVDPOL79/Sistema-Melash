<div class="container-fluid">
	
	<div class="d-flex flex-wrap justify-content-center align-content-start vh-100">
		
		<div class="card border-0 rounded shadow p-5">
			
			<form method="POST" class="needs-validation" novalidate>
				
				<h3 class="pt-3 text-center">Instalación Dashboard</h3>

				<hr>

				<div class="form-group mb-3">
					
					<label for="email_admin">Correo Administrador <sup>*</sup></label>

					<input 
					type="email"
					class="form-control rounded"
					id="email_admin"
					name="email_admin"
					required
					>

					<div class="valid-feedback">Válido.</div>
    				<div class="invalid-feedback">Campo inválido.</div>

				</div>

				<div class="form-group mb-3">
					
					<label for="password_admin">Contraseña Administrador <sup>*</sup></label>

					<input 
					type="password"
					class="form-control rounded"
					id="password_admin"
					name="password_admin"
					required
					>

					<div class="valid-feedback">Válido.</div>
    				<div class="invalid-feedback">Campo inválido.</div>

				</div>

				<div class="form-group mb-3">
					
					<label for="title_admin">Nombre del Dashboard <sup>*</sup></label>

					<input 
					type="text"
					class="form-control rounded"
					id="title_admin"
					name="title_admin"
					required
					>

					<div class="valid-feedback">Válido.</div>
    				<div class="invalid-feedback">Campo inválido.</div>

				</div>

				<div class="form-group mb-3">
					
					<label for="symbol_admin">Símbolo del Dashboard <sup>*</sup></label>

					<input 
					type="text"
					class="form-control rounded"
					id="symbol_admin"
					name="symbol_admin"
					required
					>

					<div class="valid-feedback">Válido.</div>
    				<div class="invalid-feedback">Campo inválido.</div>

				</div>

				<div class="form-group mb-3">
					
					<label for="font_admin">Tipografía del Dashboard</label>

					<textarea 
					class="form-control rounded"
					id="font_admin"
					name="font_admin"
					></textarea>

				</div>

				<div class="form-group mb-3">
					
					<label for="color_admin">Color del Dashboard</label>

					<input 
					type="color"
					class="form-control form-control-color rounded"
					id="color_admin"
					name="color_admin"
					value="#000000"
					title="Escoge Color"
					>

				</div>

				<div class="form-group mb-3">
					
					<label for="back_admin">Imagen para el Login</label>

					<input 
					type="text"
					class="form-control rounded"
					id="back_admin"
					name="back_admin"
					>

				</div>

				<small><sup>*</sup>Campos Obligatorios</small>

				<button type="submit" class="btn btn-dark btn-block w-100 rounded mt-5">Instalar</button>


				<?php 
				
				require_once "controllers/install.controller.php";
				$install = new InstallController();
				$install -> install();

				?>

			</form>

		</div>

	</div>


</div>