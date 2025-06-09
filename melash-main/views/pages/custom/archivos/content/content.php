<?php 

$url = "relations?rel=files,folders&type=file,folder&orderBy=id_file&orderMode=DESC&startAt=0&endAt=15";
$method = "GET";
$fields = array();

$files = CurlController::request($url,$method,$fields);

if($files->status == 200){

	$files = $files->results;

	/*=============================================
	Traer el total de archivos existentes en BD
	=============================================*/

	$url = "files?select=id_file";
	$totalFiles = ceil(CurlController::request($url,$method,$fields)->total/15);

}else{

	$files = array();
	$totalFiles = 0;
}

?>

<!--====================================================
CONTENT
======================================================-->

<div class="container-fluid p-4 min-vh-100" id="content">
	
	<div class="container-fluid bg-white border rounded">
		
		<!--=====================================
		SEARCH & BUTTONS
		======================================-->

		<div class="row py-4 px-0 pb-1">
			
			<?php 


			include "modules/search/search.php";
			include "modules/buttons/buttons.php";

			?>		

		</div>

		<!--=====================================
		FOLDERS & FILTERS
		======================================-->

		<div class="row pb-4 px-1 py-1">
			
			<?php 

			include "modules/folders/folders.php";
			include "modules/filters/filters.php";
			
			?>	

		</div>

		<?php 

		include "modules/drag_drop/drag_drop.php";
		include "modules/list/list.php";
		include "modules/grid/grid.php";

		?>

		<?php if ($totalFiles > 1): ?>

			<div id="btnControl" class="d-flex justify-content-center mb-5">
				<div><button class="btn btn-sm rounded backColor px-3 py-2">Cargar más archivos</button></div>
			</div>
			
		<?php endif ?>
		

		<div id="scrollControl" class="py-1"></div>

		<input type="hidden" id="totalPages" value="<?php echo $totalFiles ?>">
		<input type="hidden" id="currentPage" value="1">

	</div>
</div>