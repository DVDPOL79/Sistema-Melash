<!-- The Modal -->
<div class="modal fade" id="myPage">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded">

      <form method="POST" class="needs-validation" novalidate>

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title text-capitalize">Páginas</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <div class="modal-body px-4">

          <div class="form-group mb-3">

            <label for="title_page">Título<sup>*</sup></label>

            <input 
            type="text"
            class="form-control rounded form-control-sm"
            id="title_page"
            name="title_page"
            required
            >

            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Campo inválido.</div>

          </div>

          <div class="form-group mb-3">

            <label for="url_page">URL<sup>*</sup></label>

            <input 
            type="text"
            class="form-control rounded form-control-sm"
            id="url_page"
            name="url_page"
            required
            >
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Campo inválido.</div>

          </div>

          <div class="form-group mb-3">

            <label for="icon_page">Icono<sup>*</sup></label>

            <input 
            type="text"
            class="form-control rounded form-control-sm cleanIcon"
            id="icon_page"
            name="icon_page"
            required
            >
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Campo inválido.</div>

          </div>

          <div class="form-group mb-3">

            <label for="type_page">Tipo<sup>*</sup></label>

            <select
            class="form-select form-select-sm rounded" 
            name="type_page" 
            id="type_page">
              
              <option value="modules">Modular</option>
              <option value="custom">Personalizable</option>
              <option value="external_link">Enlace Externo</option>
              <option value="internal_link">Enlace Interno</option>

            </select>

            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Campo inválido.</div>

          </div>

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