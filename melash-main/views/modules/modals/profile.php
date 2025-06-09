<!-- The Modal -->
<div class="modal" id="myProfile">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded">

      <form method="POST" class="needs-validation" novalidate>

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title text-capitalize">Perfil <?php echo $_SESSION["admin"]->rol_admin ?></h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <div class="modal-body px-4">

          <input type="hidden" name="id_admin" value="<?php echo base64_encode($_SESSION["admin"]->id_admin) ?>">
         
          <div class="form-group mb-3">

            <label for="email_admin">Correo<sup>*</sup></label>

            <input 
            type="email"
            class="form-control rounded"
            id="email_admin"
            name="email_admin"
            value="<?php echo $_SESSION["admin"]->email_admin ?>"
            required
            >

            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Campo inválido.</div>

          </div>

          <div class="form-group mb-3">

            <label for="password_admin">Contraseña</label>

            <input 
            type="password"
            class="form-control rounded"
            id="password_admin"
            name="password_admin"
            placeholder="*********"
            >

            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Campo inválido.</div>

          </div>

          <?php if ($_SESSION["admin"]->rol_admin == "superadmin"): ?>

            <div class="form-group mb-3">

              <label for="title_admin">Nombre del Dashboard <sup>*</sup></label>

              <input 
              type="text"
              class="form-control rounded"
              id="title_admin"
              name="title_admin"
              value="<?php echo $admin->title_admin ?>"
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
              value="<?php echo htmlspecialchars($admin->symbol_admin) ?>" 
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
              value="<?php echo htmlspecialchars($admin->font_admin) ?>"
              ><?php echo htmlspecialchars($admin->font_admin) ?></textarea>

            </div>

            <div class="form-group mb-3">

              <label for="color_admin">Color del Dashboard</label>

              <input 
              type="color"
              class="form-control form-control-color rounded"
              id="color_admin"
              name="color_admin"
              value="<?php echo $admin->color_admin ?>"
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
              value="<?php echo $admin->back_admin ?>"
              >

            </div>

          <?php endif ?>

        </div>

        <!-- Modal footer -->
        <div class="modal-footer d-flex justify-content-between">
          
          <div><button type="button" class="btn btn-dark rounded" data-bs-dismiss="modal">Cerrar</button></div>
          <div><button type="submit" class="btn btn-default backColor rounded">Guardar</button></div>
          
        </div>

      </form>

    </div>
  </div>
</div>