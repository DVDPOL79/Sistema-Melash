<!-- The Modal -->
<div class="modal fade" id="myModule">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded">

      <form method="POST" class="needs-validation" novalidate>

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title text-capitalize">Módulos</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <div class="modal-body px-4">

          <!--=============================================
          Seleccionar tipo de módulo
          ===============================================-->

          <div class="form-group mb-3">

            <label for="type_module">Tipo<sup>*</sup></label>

            <select
            class="form-select form-select-sm rounded" 
            name="type_module" 
            id="type_module">
              
              <option value="breadcrumbs">Breadcrumb</option>
              <option value="metrics">Métrica</option>
              <option value="graphics">Gráfico</option>
              <option value="tables">Tabla</option>
              <option value="custom">Personalizable</option>

            </select>

            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Campo inválido.</div>

          </div>

          <!--=============================================
          Agregar título al módulo
          ===============================================-->

          <div class="form-group mb-3">

            <label for="title_module">Título<sup>*</sup></label>

            <input 
            type="text"
            class="form-control rounded form-control-sm"
            id="title_module"
            name="title_module"
            required
            >

            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Campo inválido.</div>

          </div>

          <!--=============================================
          Agregar sufijo al módulo de tabla
          ===============================================-->

          <div class="form-group mb-3" id="suffixModule" style="display:none">

            <label for="suffix_module">Sufijo<sup>*</sup></label>

            <input 
            type="text"
            class="form-control rounded form-control-sm"
            id="suffix_module"
            name="suffix_module"
            >
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Campo inválido.</div>

          </div>

          <!--=============================================
          Agregar ancho al módulo
          ===============================================-->

          <div class="form-group mb-3">
            
            <label for="width_module">Ancho</label>

            <select class="form-select form-select-sm rounded" name="width_module" id="width_module" required>
              <option value="25">25%</option>
              <option value="33">33%</option>
              <option value="50">50%</option>
              <option value="75">75%</option>
              <option value="100" selected>100%</option>
            </select>

            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Campo inválido.</div>

          </div>

           <!--=============================================
          Agregar opción editable a la info del módulo tabla
          ===============================================-->

          <div class="form-group mb-3" id="editableModule" style="display:none">
            
            <label for="editable_module">Editable</label>

            <select class="form-select form-select-sm rounded" name="editable_module" id="editable_module">
              <option value="1">ON</option>
              <option value="0">OFF</option>
            </select>

            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Campo inválido.</div>

          </div>

          <!--=============================================
          Agregar campos para métricas
          ===============================================-->

          <div id="metricsBlock" class="row row-cols-1 row-cols-md-3 row-cols-lg-6" style="display:none">

            <!--=============================================
            Elegir el tipo de métrica
            ===============================================-->
            
            <div class="col mb-3">
              
              <label>Tipo</label>

              <select class="form-select form-select-sm rounded changeMetric" id="metricType">
                <option value="total">Total</option>
                <option value="add">Suma</option>
                <option value="average">Promedio</option>
              </select>

              <div class="valid-feedback">Válido.</div>
              <div class="invalid-feedback">Campo inválido.</div>

            </div>

            <!--=============================================
            Elegir la tabla 
            ===============================================-->

            <div class="col mb-3">
              
              <label>Tabla</label>

              <input type="text" class="form-control rounded form-control-sm changeMetric" id="metricTable">

              <div class="valid-feedback">Válido.</div>
              <div class="invalid-feedback">Campo inválido.</div>

            </div>

            <!--=============================================
            Elegir la columna
            ===============================================-->

            <div class="col mb-3">
              
              <label>Columna</label>

              <input type="text" class="form-control rounded form-control-sm changeMetric" id="metricColumn">

              <div class="valid-feedback">Válido.</div>
              <div class="invalid-feedback">Campo inválido.</div>

            </div>

            <!--=============================================
            Elegir la configuración
            ===============================================-->

            <div class="col mb-3">
              
              <label>Config</label>

              <select class="form-select form-select-sm rounded changeMetric" id="metricConfig">
                <option value="unit">Unidad</option>
                <option value="price">Precio</option>
              </select>

              <div class="valid-feedback">Válido.</div>
              <div class="invalid-feedback">Campo inválido.</div>

            </div>

            <!--=============================================
            Elegir el ícono
            ===============================================-->

            <div class="col mb-3">
              
              <label for="">Icono</label>
              <input type="text" class="form-control rounded form-control-sm changeMetric  cleanIcon" 
              id="metricIcon">

              <div class="valid-feedback">Válido.</div>
              <div class="invalid-feedback">Campo inválido.</div>

            </div>

            <!--=============================================
            Elegir el color
            ===============================================-->

            <div class="col mb-3">
              
              <label for="">Color</label>
              <select class="form-select form-select-sm rounded changeMetric" id="metricColor">
                <option class="bg-primary" value="108, 95, 252">Primary</option>
                <option class="bg-secondary" value="5, 195, 251">Secondary</option>
                <option class="bg-warning" value="247, 183, 49">Warning</option>
                <option class="bg-info" value="247, 183, 49">Info</option>
                <option class="bg-success" value="9, 173, 149">Success</option>
                <option class="bg-danger" value="232, 38, 70">Danger</option>
                <option class="bg-light" value="246, 246, 251">Light</option>
                <option class="bg-dark" value="52, 58, 64">Dark</option>
                <option class="bg-blue" value="43, 62, 101">Blue</option>
                <option class="bg-indigo" value="77, 93, 219">Indigo</option>
                <option class="bg-purple" value="137, 39, 236">Purple</option>
                <option class="bg-pink" value="236, 130, 239">Pink</option>
                <option class="bg-red" value="208, 61, 70">Red</option>
                <option class="bg-maroon" value="128, 0, 0">Maroon</option>
                <option class="bg-orange" value="252, 115, 3">Orange</option>
                <option class="bg-yellow" value="255, 193, 2">Yellow</option>
                <option class="bg-green" value="29, 216, 113">Green</option>
                <option class="bg-teal" value="28, 175, 159">Teal</option>
                <option class="bg-cyan" value="0, 209, 209">Cyan</option>
                <option class="bg-gray" value="134, 153, 163">Gray</option>
              </select>

              <div class="valid-feedback">Válido.</div>
              <div class="invalid-feedback">Campo inválido.</div>

            </div>

          </div>

          <!--=============================================
          Agregar campos para gráficos
          ===============================================-->

          <div id="graphicsBlock" class="row row-cols-1 row-cols-md-3 row-cols-lg-5" style="display:none">

            <!--=============================================
            Elegir el tipo de gráfico
            ===============================================-->

            <div class="col mb-3">
              
              <label>Tipo</label>
              
              <select class="form-select form-select-sm rounded changeGraphic" id="graphicType">
                <option value="line">Línea</option>
                <option value="bar">Barra</option>
              </select>

              <div class="valid-feedback">Válido.</div>
              <div class="invalid-feedback">Campo inválido.</div>

            </div>

            <!--=============================================
            Elegir la tabla
            ===============================================-->

            <div class="col mb-3">
              
              <label>Tabla</label>
              <input 
              type="text" 
              class="form-control rounded form-control-sm changeGraphic" 
              id="graphicTable">

              <div class="valid-feedback">Válido.</div>
              <div class="invalid-feedback">Campo inválido.</div>

            </div>

            <!--=============================================
            Elegir la columna que va en el eje X
            ===============================================-->

            <div class="col mb-3">
              
              <label>Eje X</label>
              <input 
              type="text" 
              class="form-control rounded form-control-sm changeGraphic" 
              id="graphicX">

              <div class="valid-feedback">Válido.</div>
              <div class="invalid-feedback">Campo inválido.</div>

            </div>

            <!--=============================================
            Elegir la columna que va en el eje Y
            ===============================================-->

            <div class="col mb-3">
              
              <label>Eje Y</label>
              <input 
              type="text" 
              class="form-control rounded form-control-sm changeGraphic" 
              id="graphicY">

              <div class="valid-feedback">Válido.</div>
              <div class="invalid-feedback">Campo inválido.</div>

            </div>

            <!--=============================================
            Elegir el color
            ===============================================-->

            <div class="col mb-3">
              
              <label for="">Color</label>
              <select class="form-select form-select-sm rounded changeGraphic" id="graphicColor">
                <option class="bg-primary" value="108, 95, 252">Primary</option>
                <option class="bg-secondary" value="5, 195, 251">Secondary</option>
                <option class="bg-warning" value="247, 183, 49">Warning</option>
                <option class="bg-info" value="247, 183, 49">Info</option>
                <option class="bg-success" value="9, 173, 149">Success</option>
                <option class="bg-danger" value="232, 38, 70">Danger</option>
                <option class="bg-light" value="246, 246, 251">Light</option>
                <option class="bg-dark" value="52, 58, 64">Dark</option>
                <option class="bg-blue" value="43, 62, 101">Blue</option>
                <option class="bg-indigo" value="77, 93, 219">Indigo</option>
                <option class="bg-purple" value="137, 39, 236">Purple</option>
                <option class="bg-pink" value="236, 130, 239">Pink</option>
                <option class="bg-red" value="208, 61, 70">Red</option>
                <option class="bg-maroon" value="128, 0, 0">Maroon</option>
                <option class="bg-orange" value="252, 115, 3">Orange</option>
                <option class="bg-yellow" value="255, 193, 2">Yellow</option>
                <option class="bg-green" value="29, 216, 113">Green</option>
                <option class="bg-teal" value="28, 175, 159">Teal</option>
                <option class="bg-cyan" value="0, 209, 209">Cyan</option>
                <option class="bg-gray" value="134, 153, 163">Gray</option>
              </select>

              <div class="valid-feedback">Válido.</div>
              <div class="invalid-feedback">Campo inválido.</div>

            </div>

          </div>

          <!--=============================================
          Agregar campos para tablas y columnas
          ===============================================-->

          <div id="columnsBlock" style="display:none">
            
            <div class="mb-3">Columnas</div>
            
            <hr>

            <input type="hidden" id="indexColumns" name="indexColumns" value='[]'>
            <input type="hidden" id="deleteColumns" name="deleteColumns" value='[]'>

            <div class="row listColumns"></div>

            <button type="button" class="btn btn-sm btn-default border rounded my-3 addColumn">
              Agregar Columnas
            </button>

          </div>

          <input type="hidden" id="content_module" name="content_module">

        </div>

        <!-- Modal footer -->
        <div class="modal-footer d-flex justify-content-between">
          
          <div><button type="button" class="btn btn-dark rounded" data-bs-dismiss="modal">Cerrar</button></div>
          <div><button type="submit" class="btn btn-default backColor rounded">Guardar</button></div>
          
        </div>

    

    </div>
  </div>
</div>