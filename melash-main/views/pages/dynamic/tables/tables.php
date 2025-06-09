<?php

/*=============================================
Traemos columnas de la tabla
=============================================*/

$url = "columns?linkTo=id_module_column&equalTo=".$module->id_module;
$method = "GET";
$fields = array();

$columns = CurlController::request($url,$method,$fields);

if($columns->status == 200){

	$columns = $columns->results;

}else{

	$columns = array();
	
}

/*=============================================
Agregar las columnas a los datos del módulo
=============================================*/
$module->columns = $columns;
// echo '<pre>$module '; print_r($module); echo '</pre>';

/*=============================================
Traemos contenido de la tabla
=============================================*/
$limit = 10;
$totalPages = 0;
$totalData = 0;

if($_SESSION["admin"]->id_office_admin == 0 || !in_array("id_office_".$module->suffix_module, array_column($module->columns, "title_column"))){

	$url = $module->title_module."?orderBy=id_".$module->suffix_module."&orderMode=DESC&startAt=0&endAt=".$limit;

}else{

	$url = $module->title_module."?orderBy=id_".$module->suffix_module."&orderMode=DESC&startAt=0&endAt=".$limit."&linkTo=id_office_".$module->suffix_module."&equalTo=".$_SESSION["admin"]->id_office_admin;

}


$method = "GET";
$fields = array();

$table = CurlController::request($url,$method,$fields);

if($table->status == 200){

	$table = $table->results;

	/*=============================================
	Traemos contenido total de la tabla
	=============================================*/

	if($_SESSION["admin"]->id_office_admin == 0 || !in_array("id_office_".$module->suffix_module, array_column($module->columns, "title_column"))){

		$url = $module->title_module."?select=id_".$module->suffix_module;

	}else{

		$url = $module->title_module."?select=id_".$module->suffix_module."&linkTo=id_office_".$module->suffix_module."&equalTo=".$_SESSION["admin"]->id_office_admin;
	}
		
	$totalData = CurlController::request($url,$method,$fields)->total;
	$totalPages = ceil($totalData/$limit);

}else{ 

	$table = array();
}

$totalColumns = 3;

?>

<!--===========================================
Cargamos el gestor de datos
=============================================-->

<?php if (!empty($routesArray[1]) && $routesArray[1] == "manage"): ?>


	<?php 

	include "manage/manage.php";
	include "views/modules/modals/files.php";
	
	?>

<!--===========================================
Cargamos el módulo tabla
=============================================-->

<?php else: ?>

<div class="<?php if ($module->width_module == "100"): ?> col-lg-12 <?php endif ?><?php if ($module->width_module == "75"): ?> col-lg-9 <?php endif ?><?php if ($module->width_module == "50"): ?> col-lg-6 <?php endif ?><?php if ($module->width_module == "33"): ?> col-lg-4 <?php endif ?><?php if ($module->width_module == "25"): ?> col-lg-3 <?php endif ?> col-12 mb-3 position-relative">

	<?php if ($_SESSION["admin"]->rol_admin == "superadmin"): ?>

		<div class="position-absolute border rounded bg-white" style="top:0px; right:12px; z-index:100">
			
			<button type="button" class="btn btn-sm text-muted rounded m-0 px-1 py-0 border-0 myModule" item='<?php echo json_encode($module) ?>' idPage="<?php echo $page->results[0]->id_page ?>">
				<i class="bi bi-pencil-square"></i>
			</button>

			<button type="button" class="btn btn-sm text-muted rounded m-0 px-1 py-0 border-0 deleteModule" idModule=<?php echo base64_encode($module->id_module) ?> >
				<i class="bi bi-trash"></i>
			</button>


		</div>
		
	<?php endif ?>
	
	<div class="card rounded p-3 w-100" id="cardTable">

		<!--=========================================
        Cabecera de la tabla
        ===========================================-->
		
		<div class="card-header bg-white">
			
			<div class="d-lg-flex justify-content-between">

				<!--=========================================
		        Botón para crear un nuevo registro
		        ===========================================-->
				
				<div class="mb-3">

					<?php if ($_SESSION["admin"]->rol_admin == "superadmin" || $module->editable_module == 1): ?>

						<a href="/<?php echo $module->url_page ?>/manage" class="btn btn-default btn-sm rounded backColor px-3 py-2">Agregar registro
						</a>
						
					<?php endif ?>
					
					

				</div>

				<div class="mb-3">
					
					<ul class="nav justify-content-lg-end">

						<!--=========================================
				        Botón para rango de fechas
				        ===========================================-->
						
						<li class="nav-item p-0 me-2 position-relative" style="bottom:5px">
							
							<button type="button" class="btn small" id="daterange-btn">
								
								<i class="far fa-calendar-alt me-1"></i>

								<small>
									<span id="startDate"><?php echo date("Y-m-d", 0) ?></span>
									-
									<span id="endDate"><?php echo date("Y-m-d") ?></span>
									<i class="fas fa-caret-down ms-1"></i>
								</small>

							</button>

						</li>

						<?php if ($_SESSION["admin"]->rol_admin == "superadmin" || $module->editable_module == 1): ?>

						<li class="nav-item p-0">
							<!--=========================================
				        	Exportar
				        	===========================================-->
							<button type="button" class="btn btn-sm bg-green rounded border-0 download" data-bs-toggle="modal" data-bs-target="#exportModal">
    							<i class="bi bi-download"></i>
							</button>

							<!--=========================================
				        	Selección masiva
				        	===========================================-->

							<button type="button" class="btn btn-sm bg-blue rounded border-0 checkAllItems" mode="false">
								<i class="bi bi-check2-square"></i>
							</button>

							<!--=========================================
				        	Cambio Selección masiva
				        	===========================================-->

				        	<?php 

				        	if (!empty($columns) && in_array("select", array_column($columns,"type_column"))){

				        		foreach ($columns as $key => $value) {

				        			if($value->type_column == "select"){

				        				echo '<button type="button" class="btn btn-sm bg-indigo rounded border-0 mySelects" column="'.$value->title_column.'" matrix="'.$value->matrix_column.'"><i class="bi bi-arrow-down-up"></i></button>';

				        				break;
				        			}

				        		}

				        	}

				        	?>

							<!--=========================================
				        	Cambio Boleano masivo
				        	===========================================-->

				        	<?php 

				        	if (!empty($columns) && in_array("boolean", array_column($columns,"type_column"))){

				        		foreach ($columns as $key => $value) {

				        			if($value->type_column == "boolean"){

				        				echo '<button type="button" class="btn btn-sm bg-purple rounded border-0 myBooleans" column="'.$value->title_column.'"><i class="bi bi-arrow-left-right"></i></button>';

				        				break;
				        			}

				        		}

				        	}

				        	?>

							<!--=========================================
				        	Eliminación masiva
				        	===========================================-->

							<button type="button" class="btn btn-sm bg-maroon rounded border-0 deleteAllItems">
								<i class="bi bi-trash"></i>
							</button>

						</li>

						<?php endif ?>

					</ul>

				</div>

			</div>

		</div>

		<!--=========================================
        Cuerpo de la tabla
        ===========================================-->

		<div class="card-body">

			<!--========================================
			Filtros Iniciales
			=========================================-->

			<input type="hidden" id="contentModule" value='<?php echo json_encode($module) ?>'>
			<input type="hidden" id="orderByTable" value="id_<?php echo $module->suffix_module ?>">
			<input type="hidden" id="orderModeTable" value="DESC">
		    <input type="hidden" id="limitTable" value="<?php echo $limit ?>">
		    <input type="hidden" id="rolAdmin" value="<?php echo $_SESSION["admin"]->rol_admin ?>">
		    <input type="hidden" id="searchTable" value="">
		    <input type="hidden" id="between1" value="<?php echo date("Y-m-d", 0) ?>">
		    <input type="hidden" id="between2" value="<?php echo date("Y-m-d") ?>">
		    <input type="hidden" id="checkItems" value="" table="<?php echo $module->title_module ?>" suffix="<?php echo $module->suffix_module ?>">
		    <input type="hidden" id="idOffice" value="<?php echo $_SESSION["admin"]->id_office_admin ?>">

			<!--=========================================
	        Bloque de filtros
	        ===========================================-->		

			<div class="d-lg-flex justify-content-lg-between">

				<!--=========================================
		        Filtar cantidad de registros
		        ===========================================-->
				
				<div class="mb-3 row">
					
					<div class="col mt-1">
						<small>Mostrar</small>
					</div>

					<div class="col p-0">
						<select class="form-select form-select-sm rounded changeLimit" style="width:65px">
						  <option value="10" class="small">10</option>
						  <option value="25" class="small">25</option>
						  <option value="50" class="small">50</option>
						  <option value="100" class="small">100</option>
						</select>
					</div>

					<div class="col mt-1">
						<small>Registros</small>
					</div>

				</div>

				<!--=========================================
		        Filtar por búsqueda de registros
		        ===========================================-->

		        <div class="mb-3">
		        	
		        	<input type="text" id="searchItem" class="form-control rounded form-control-sm" placeholder="Buscar...">

		        </div>

			</div>

			<!--=========================================
	        Bloque de tabla
	        ===========================================-->	

	        <div class="table-responsive">
	        	
	        	<table class="table" width="100%">
	        		
	        		<thead>
	        			
	        			<tr>

	        				<th class="position-relative"># <i class="bi bi-arrow-down-short position-absolute orderFilter" orderBy="id_<?php echo $module->suffix_module ?>" orderMode="ASC" style="cursor: pointer;"></i></th>
					        
	        				<?php if ($_SESSION["admin"]->rol_admin == "superadmin" || $module->editable_module == 1): ?>
					        <th>Sel.</th>  
					        <?php endif ?>
					       
					        <?php if (!empty($columns)): ?>

					        	<?php foreach ($columns as $index => $item): ?>

					        		<?php if ($item->visible_column == 1): $totalColumns++ ?>
					        			
					        			<th class="text-capitalize position-relative">
					        				<?php echo $item->alias_column ?>

					        				<?php if ($item->type_column == "text" || 
					        						  $item->type_column == "textarea" || 
					        						  $item->type_column == "select" ||
					        						  $item->type_column == "int" || 
					        						  $item->type_column == "double" ||
					        						  $item->type_column == "money" ||
					        						  $item->type_column == "date" ||
					        						  $item->type_column == "time" || 
					        						  $item->type_column == "datetime" || 
					        						  $item->type_column == "link" ||
					        						  $item->type_column == "order" ||
					        						  $item->type_column == "stock"  ): ?>
					        					<i class="bi bi-arrow-down-short position-absolute orderFilter" orderBy="<?php echo $item->title_column ?>" orderMode="ASC" style="cursor: pointer;"></i>
					        				<?php endif ?>
					        					
					        			</th>	

					        		<?php endif ?>
					        		
					        	<?php endforeach ?>
					        <?php endif ?>

					        <?php if ($_SESSION["admin"]->rol_admin == "superadmin" || $module->editable_module == 1): ?>

					        	<th class="text-center">Acciones</th>

					    	<?php endif ?>
  
	        			</tr>
	        		</thead>

	        		<tbody class="small" id="loadTable">

	        			<?php if (!empty($table)): ?>

	        				<?php foreach (json_decode(json_encode($table),true) as $key => $value): ?>

        					<tr>

        						<td><?php echo ($key+1) ?></td>

        						<?php if ($_SESSION["admin"]->rol_admin == "superadmin" || $module->editable_module == 1): ?>
        						
        						<td>
		        					<div class="form-check formCheck">
		        						<input class="form-check-input checkItem" type="checkbox" idItem="<?php echo base64_encode($value["id_".$module->suffix_module]) ?>">
		        					</div>
		        				</td>

		        				<?php endif ?>

	        					<?php foreach ($columns as $index => $item): ?>

	        						<?php if ($item->visible_column == 1): ?>
	        								
		        						<td>

		        						<?php 

	        							/*=============================================
										Contenido tipo Imagen
										=============================================*/

										if($item->type_column == "image"){

											echo '<a href="'.urldecode($value[$item->title_column]).'" target="_blank">
												<img src="'.urldecode($value[$item->title_column]).'" class="rounded" style="width:60px; height:60px; object-fit: cover; object-position:center;">
											</a>';

										/*=============================================
										Contenido tipo Video
										=============================================*/

										}else if($item->type_column == "video"){

											echo '<a href="'.urldecode($value[$item->title_column]).'" target="_blank">
												<img src="/views/assets/img/video.png" class="rounded" style="width:60px; height:60px; object-fit: cover; object-position:center;">
											</a>';

										/*=============================================
										Contenido tipo otros Archivos
										=============================================*/

										}else if($item->type_column == "file"){

											echo '<a href="'.urldecode($value[$item->title_column]).'" target="_blank">
												<img src="/views/assets/img/file.png" class="rounded" style="width:60px; height:60px; object-fit: cover; object-position:center;">
											</a>';


										/*=============================================
										Contenido tipo Boleano
										=============================================*/

										}else if($item->type_column == "boolean"){


											if($value[$item->title_column] == 1){	

												$checked = 'checked';
												$label = "ON";
											
											}else{

												$checked = '';
												$label = "OFF";
											}

											if ($_SESSION["admin"]->rol_admin == "superadmin" || $module->editable_module == 1){

												echo '<div class="form-check form-switch">
												<input class="form-check-input px-3 changeBoolean" type="checkbox" id="mySwtich" '.$checked.' idItem="'.base64_encode($value["id_".$module->suffix_module]).'" table="'.$module->title_module.'" suffix="'.$module->suffix_module.'" column="'.$item->title_column.'">
												<label class="form-check-label ps-1 align-middle" for="mySwitch">'.$label.'</label>
												</div>';

											}else{

												echo '<label class="form-check-label ps-1 align-middle" for="mySwitch">'.$label.'</label>';
											}

										/*=============================================
										Contenido tipo Array
										=============================================*/
									    }else if($item->type_column == "array"){

									    	$typeArray = explode(",",urldecode($value[$item->title_column]));

									    	foreach ($typeArray as $num => $elem){
										
												echo '<span class="badge badge-sm badge-default rounded bg-dark py-1 px-2 mx-1 mt-1 border small">'.TemplateController::reduceText($elem,25).'</span>';

											}

										/*=============================================
										Contenido tipo Objetos
										=============================================*/

										}else if($item->type_column == "object"){

									    	$typeJSON = json_decode(urldecode($value[$item->title_column]));

									    	foreach ($typeJSON as $num => $elem){

									    		echo '<span class="badge badge-sm badge-default rounded py-1 px-2 mx-1 mt-1 border text-dark text-uppercase small">'.$num.': '.$elem.'</span>';

									    	}

									    /*=============================================
										Contenido tipo Enlace
										=============================================*/

										}else if($item->type_column == "link"){

									    	echo '<a href="'.$value[$item->title_column].'" target="_blank" class="badge badge-default border rounded bg-indigo">'.TemplateController::reduceText(urldecode($value[$item->title_column]), 20).'</a>';

										/*=============================================
										Contenido tipo Color
										=============================================*/

										}else if($item->type_column == "color"){

									    	echo '<div class="rounded" style="width:25px; height:25px; background:'.urldecode($value[$item->title_column]).'"></div>';

									    /*=============================================
										Contenido tipo Double
										=============================================*/

										}else if($item->type_column == "money"){

									    	echo '$'.number_format(urldecode($value[$item->title_column]),2);

									    /*=============================================
										Contenido tipo Relaciones
										=============================================*/

										}else if($item->type_column == "relations"){

											if($item->matrix_column != null && $value[$item->title_column] > 0){

												$url = "relations?rel=modules,pages&type=module,page&linkTo=type_module,title_module&equalTo=tables,".$item->matrix_column."&select=url_page,suffix_module";
												$method = "GET";
												$array = array();

												$urlPage = CurlController::request($url,$method,$fields)->results[0]->url_page;
												$suffixModule = CurlController::request($url,$method,$fields)->results[0]->suffix_module;

												$url = $item->matrix_column.'?linkTo=id_'.$suffixModule."&equalTo=".$value[$item->title_column];
												$relation = CurlController::request($url,$method,$fields);
												$arrayRelation  = (array)$relation->results[0];
						
												echo '<a href="'.$urlPage.'/manage/'.base64_encode($value[$item->title_column]).'" target="_blank" class="badge badge-default border rounded bg-indigo">'.urldecode($arrayRelation[array_keys($arrayRelation)[1]]).'</a>';

											}else{

												echo $value[$item->title_column]; 

											}

										/*=============================================
										Contenido tipo Órden
										=============================================*/

										}else if($item->type_column == "order"){


											echo '<input type="number" class="form-control form-control-sm rounded changeOrder" value="'.$value[$item->title_column].'" style="width:55px" idItem="'.base64_encode($value["id_".$module->suffix_module]).'" table="'.$module->title_module.'" suffix="'.$module->suffix_module.'" column="'.$item->title_column.'">';


										}else if($item->type_column == "pos"){

											echo '<a href="/pos?order='.urldecode($value[$item->title_column]).'" style="color:inherit">'.urldecode($value[$item->title_column]).'</a>';

										}else if($item->type_column == "stock"){

											if($value[$item->title_column] < 50){

												$colorStock = "bg-maroon";
											}

												if($value[$item->title_column] >= 50 && $value[$item->title_column] < 100){

												$colorStock = "bg-indigo";
											}

											if($value[$item->title_column] >= 100){

												$colorStock = "bg-teal";
											}

											echo '<span class="badge badge-sm badge-default '.$colorStock.' rounded py-1 px-3 mx-1 mt-1 text-uppercase small">'.$value[$item->title_column].'</span>';

										}else{

											if($value[$item->title_column] != null){

				        						echo TemplateController::reduceText(urldecode($value[$item->title_column]),25); 

				        					}else{

				        						echo "";
				        					}			        				

			        					}


		        						?> 

		        						</td>

		        					<?php endif ?>
						
	        					<?php endforeach ?>

	        				 <?php if ($_SESSION["admin"]->rol_admin == "superadmin" || $module->editable_module == 1): ?>

	        					<td class="text-center">
		        					<a href="/<?php echo $module->url_page ?>/manage/<?php echo base64_encode($value["id_".$module->suffix_module]) ?>/copy" class="btn btn-sm text-dark rounded m-0 p-0 border-0">
		        						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-copy" viewBox="0 0 16 16">
										  <path fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z"/>
										</svg>
		        					</a>
		        					<a href="/<?php echo $module->url_page ?>/manage/<?php echo base64_encode($value["id_".$module->suffix_module]) ?>" class="btn btn-sm text-primary rounded m-0 p-0 border-0">
		        						<i class="bi bi-pencil-square"></i>
		        					</a>
		        					<button type="button" class="btn btn-sm text-maroon rounded m-0 p-0 border-0 deleteItem" idItem="<?php echo base64_encode($value["id_".$module->suffix_module]) ?>" table="<?php echo $module->title_module ?>" suffix="<?php echo $module->suffix_module ?>">
		        						<i class="bi bi-trash"></i>
		        					</button>
		        				</td>

		        				<?php endif ?>

	        				</tr>
	        					
	        				<?php endforeach ?>	

	        			<?php else: ?>

	        				<tr>
	        					<td colspan="<?php echo $totalColumns ?>" class="text-center py-3">No hay registros disponibles</td>
	        				</tr>
	        				
	        			<?php endif ?>
	        			
	        		</tbody>

	        	</table>
	        </div>	

	        <?php if (!empty($table)): ?>

	        <!--=========================================
	        Bloque final
	        ===========================================-->	

	        <div class="d-lg-flex justify-content-lg-between mt-2 mb-0">

	        	<!--=========================================
	        	Visualización de registros
	        	===========================================-->	

	        	<div class="mb-3 blockFooter" id="cont-filters">

	        		<small>Mostrando
	        			<span id="startItems">1</span> a 
	        			<span id="endItems"><?php echo $limit ?></span> de
	        			<span id="totalItems"><?php echo $totalData ?></span>
	        		</small>
	        		
	        	</div>

	        	<!--=========================================
	        	Paginación
	        	===========================================-->	

	        	<div class="mb-3 blockFooter" id="cont-pagination">

		        	<ul id="pagination" class="pagination pagination-sm rounded" totalPages="<?php echo $totalPages ?>">
		        	</ul>

		        </div>
	        	
	        </div>

	        <?php endif ?>

		</div>

	</div>

</div>

<?php 

  include "views/modules/modals/booleans.php"; 
  include "views/modules/modals/selects.php"; 

?>

<?php endif ?>
<!-- Modal de selección de formato -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exportModalLabel">Seleccionar formato de descarga</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Seleccione el formato en el que desea exportar los datos:</p>
        <button id="exportCSV" class="btn btn-primary w-100 mb-2">Exportar a CSV</button>
        <button id="exportPDF" class="btn btn-danger w-100">Exportar a PDF</button>
      </div>
    </div>
  </div>
</div>

<script>

document.addEventListener("DOMContentLoaded", function () {
    let selectedTable = null;
    let tableTitle = "Exportación"; // Nombre por defecto

    // Captura la tabla y su título al hacer clic en el botón de descarga
    document.querySelectorAll(".download").forEach(button => {
        button.addEventListener("click", function (event) {
            let card = event.target.closest(".card");
            selectedTable = card.querySelector("table");
            let titleElement = card.querySelector(".card-title");
            tableTitle = titleElement ? titleElement.innerText.trim().replace(/\s+/g, "_") : "Exportación";
        });
    });

    // Exportar a CSV
    document.getElementById("exportCSV").addEventListener("click", function () {
        if (!selectedTable) return;

        let csvContent = "\uFEFF"; // BOM para compatibilidad con Excel

        let headers = [];
        selectedTable.querySelectorAll("thead th").forEach((th, index) => {
            if (index !== 1) headers.push(th.innerText.trim()); // Omitir la segunda columna
        });
        csvContent += headers.join(";") + "\n";

        selectedTable.querySelectorAll("tbody tr").forEach(row => {
            let rowData = [];
            row.querySelectorAll("td").forEach((td, index) => {
                if (index !== 1) rowData.push(td.innerText.trim()); // Omitir la segunda columna
            });
            csvContent += rowData.join(";") + "\n";
        });

        let blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
        let link = document.createElement("a");
        link.href = URL.createObjectURL(blob);
        link.download = tableTitle + ".csv"; // Nombre basado en la tabla
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        closeModal();
    });

    // Exportar a PDF
    document.getElementById("exportPDF").addEventListener("click", function () {
        if (!selectedTable) return;

        let { jsPDF } = window.jspdf;
        let doc = new jsPDF();

        doc.setFont("helvetica", "bold");
        doc.text(tableTitle.replace(/_/g, " "), 20, 20); // Agregar el título de la tabla

        let data = [];
        let headers = [];

        selectedTable.querySelectorAll("thead th").forEach((th, index) => {
            if (index !== 1) headers.push(th.innerText.trim()); // Omitir la segunda columna
        });

        selectedTable.querySelectorAll("tbody tr").forEach(row => {
            let rowData = [];
            row.querySelectorAll("td").forEach((td, index) => {
                if (index !== 1) rowData.push(td.innerText.trim()); // Omitir la segunda columna
            });
            data.push(rowData);
        });

        doc.autoTable({
            head: [headers],
            body: data,
            startY: 30
        });

        doc.save(tableTitle + ".pdf"); // Nombre basado en la tabla

        closeModal();
    });

    // Función para cerrar el modal
    function closeModal() {
        let modal = bootstrap.Modal.getInstance(document.getElementById("exportModal"));
        if (modal) modal.hide();
    }
});

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>
