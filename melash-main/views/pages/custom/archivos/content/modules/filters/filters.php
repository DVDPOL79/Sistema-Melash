<?php

/*=============================================
Organizar los tipos de archivos
=============================================*/

$url = "files?select=type_file";
$method = "GET";
$fields = array();

$types = CurlController::request($url,$method,$fields);

$typeFiles = array();

if($types->status == 200){

	foreach ($types->results as $key => $value) {
		
		array_push($typeFiles, $value->type_file);	

	}

}

$typeFiles = array_unique($typeFiles);

?>

<!--=====================================
FILTERS
======================================-->

<div class="col-12 col-lg-5 mt-3">
  
		<div class="d-flex flex-row-reverse">

			<div class="btn-group rounded">
				<button type="button" class="btn btn-default border rounded-start text-dark changeView" module="grid">
					<i class="bi bi-grid-3x3-gap-fill"></i>
				</button>
				<button type="button" class="btn btn-default border rounded-end bg-dark changeView text-white" module="list">
					<i class="bi bi-list"></i>
				</button>
			</div>

		<select class="form-select rounded mx-2 changeFilters" id="sortBy">
		  <option value="id_file-DESC">Sort by</option>
		  <option value="id_file-DESC">Newest first</option>
		  <option value="id_file-ASC">Oldest first</option>
		  <option value="size_file-DESC">Largest first</option>
		  <option value="size_file-ASC">Smallest first</option>
		  <option value="name_file-ASC">A-Z</option>
		  <option value="name_file-DESC">Z-A</option>
		</select>

		<select class="form-select rounded changeFilters" id="filterBy">
		  <option value="ALL">Filter by</option>
		  <option value="ALL">ALL</option>

		  <?php if (!empty($typeFiles)): ?>
		 

		  	<?php foreach ($typeFiles as $key => $value): ?>

		  		<option value="<?php echo $value ?>"><?php echo $value ?></option>

		  	<?php endforeach ?>

		  <?php endif ?>

		</select>
			
		</div>

</div>