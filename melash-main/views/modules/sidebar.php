<?php 

$url = "pages?orderBy=order_page&orderMode=ASC";
$method = "GET";
$fields = array();

$pages  = CurlController::request($url,$method,$fields);

if($pages->status == 200){

	$pages = $pages->results;

}else{

	$pages = array();
	
}

?>

<div class="bg-white shadow" id="sidebar-wrapper">

	<div class="sidebar-heading bg-white text-dark my-2">
		<?php echo $admin->symbol_admin ?>
		<span class="menu-text"><?php echo $admin->title_admin ?></span>
	</div>

	<hr class="mt-0 borderDashboard">

	<ul class="list-group list-group-flush" id="sortable">

		<?php if (!empty($pages)): ?>

			<?php foreach ($pages as $key => $value): ?>


				<?php if ($_SESSION["admin"]->rol_admin == "superadmin" || $_SESSION["admin"]->rol_admin == "admin" || $_SESSION["admin"]->rol_admin == "editor" && isset(json_decode(urldecode($_SESSION["admin"]->permissions_admin), true)[$value->url_page]) && json_decode(urldecode($_SESSION["admin"]->permissions_admin), true)[$value->url_page] == "on" ): ?>

				<li class="list-group-item list-group-item-action position-relative" idPage="<?php echo base64_encode($value->id_page) ?>">

					<?php if ($value->type_page == "external_link" || $value->type_page == "internal_link"): ?>

						<a class="bg-transparent text-dark" href="<?php echo urldecode($value->url_page) ?>" <?php if ($value->type_page == "external_link"): ?>  target="_blank" <?php endif ?>>

					<?php else: ?>

						<a class="bg-transparent text-dark" href="/<?php echo $value->url_page ?>">
						
					<?php endif ?>
	
				 		<i class="<?php echo $value->icon_page ?> textColor"></i> 
				 		<span class="menu-text"><?php echo $value->title_page ?></span>

				 	</a>

				 	<?php if ($_SESSION["admin"]->rol_admin == "superadmin"): ?>

				 		<span class="position-absolute border rounded bg-white btnPages" style="right:5px; top:15px">
				 			
				 			<span class="btn btn-sm text-muted rounded m-0 p-0 border-0 handle" style="cursor:move">
				 				<i class="bi bi-arrows-move m-1"></i>	
				 			</span>

				 			<button type="button" class="btn btn-sm text-muted rounded m-0 p-0 border-0 myPage" page='<?php echo json_encode($value) ?>'>
				 				<i class="bi bi-pencil-square m-1"></i>
				 			</button>

				 			<button type="button" class="btn btn-sm text-muted rounded m-0 p-0 border-0 deletePage" idPage=<?php echo base64_encode($value->id_page) ?>>
				 				<i class="bi bi-trash m-1"></i>
				 			</button>


				 		</span>


				 	<?php endif ?>

				</li>

				<?php endif ?>
				
			<?php endforeach ?>
			
		<?php endif ?>

	</ul>

	<?php if ($_SESSION["admin"]->rol_admin == "superadmin"): ?>

		<hr class="borderDashboard">

		<button class="btn btn-default border rounded btn-sm ms-3 menu-text mt-2 myPage">Agregar Página</button>
		
	<?php endif ?>

	

</div>