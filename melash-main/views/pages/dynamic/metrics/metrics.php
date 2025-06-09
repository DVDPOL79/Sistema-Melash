<?php 

$metric = 0;

$content = json_decode($module->content_module);


$suffix = explode("_",$content->column);
$suffix = end($suffix);

/*=============================================
Traer info de la métrica
=============================================*/

if($_SESSION["admin"]->id_office_admin > 0){

	if($module->title_module == "ventas" && $module->id_page_module == 13){

		$url = $content->table."?linkTo=status_order,id_office_order&equalTo=Completada,".$_SESSION["admin"]->id_office_admin."&select=".$content->column;

	}else{ 
	
		if($module->title_module == "ventas diarias" && $module->id_page_module == 13){

			$url = $content->table."?linkTo=status_order,id_office_order,date_created_order&equalTo=Completada,".$_SESSION["admin"]->id_office_admin.",".date("Y-m-d")."&select=".$content->column;
				
		}else{

		$url = $content->table."?linkTo=id_office_".$suffix."&equalTo=".$_SESSION["admin"]->id_office_admin."&select=".$content->column;
		}
	}

}else{

	if($module->title_module == "ventas" && $module->id_page_module == 13){

		$url = $content->table."?linkTo=status_order&equalTo=Completada&select=".$content->column;

	}else{
		if($module->title_module == "ventas diarias" && $module->id_page_module == 13){

			$url = $content->table."?linkTo=status_order,date_created_order&equalTo=Completada,".date("Y-m-d")."&select=".$content->column;
				
		}else{

			$url = $content->table."?select=".$content->column;
		}
		
	}

}

$method = "GET";
$fields = array();

$response = CurlController::request($url,$method,$fields);

if($response->status == 200){

	/*=============================================
	Total de valores
	=============================================*/

	if($content->type == "total"){

		$metric = $response->total;

	}

	/*=============================================
	Sumar valores
	=============================================*/

	if($content->type == "add"){

		foreach (json_decode(json_encode($response->results),true) as $key => $value) {
				
			$metric += $value[$content->column];
	
		}

	}

	/*=============================================
	Promedio de valores
	=============================================*/

	if($content->type == "average"){

		$total = $response->total;

		foreach (json_decode(json_encode($response->results),true) as $key => $value) {
				
			$metric += $value[$content->column];
	
		}

		$metric = $metric/$total;

	}

}

?>


<div class="<?php if ($module->width_module == "100"): ?> col-lg-12 <?php endif ?><?php if ($module->width_module == "75"): ?> col-lg-9 <?php endif ?><?php if ($module->width_module == "50"): ?> col-lg-6 <?php endif ?><?php if ($module->width_module == "33"): ?> col-lg-4 <?php endif ?><?php if ($module->width_module == "25"): ?> col-lg-3 <?php endif ?> col-12 mb-3 position-relative">

	<?php if ($_SESSION["admin"]->rol_admin == "superadmin"): ?>

		<div class="position-absolute border rounded bg-white" style="top:0px; right:10px">
			
			<button type="button" class="btn btn-sm text-muted rounded m-0 px-1 py-0 border-0 myModule" item='<?php echo json_encode($module) ?>' idPage="<?php echo $page->results[0]->id_page ?>">
				<i class="bi bi-pencil-square"></i>
			</button>

			<button type="button" class="btn btn-sm text-muted rounded m-0 px-1 py-0 border-0 deleteModule" idModule=<?php echo base64_encode($module->id_module) ?> >
				<i class="bi bi-trash"></i>
			</button>

		</div>
		
	<?php endif ?>
	
	<div class="rounded text-white" style="background:rgba(<?php echo $content->color ?>, .55) !important">
		
		<div class="d-flex justify-content-between p-3">
			
			<div class="inner">
				<h5 class="font-weight-bold text-capitalize"><?php echo $module->title_module ?></h5>
				<?php if ($content->config == "unit"): ?>
					<h2 class="pt-2"><?php echo $metric ?></h1>	
				<?php endif ?>
				<?php if ($content->config == "price"): ?>
					<h2 class="pt-2">$<?php echo number_format($metric,2) ?></h1>	
				<?php endif ?>
				
			</div>

			<div class="display-2 text-center pt-2 pe-2" style="color:rgb(<?php echo $content->color ?>) !important">
				<i class="<?php echo $content->icon ?>"></i>
			</div>

		</div>

		<div class="text-center p-2 rounded-bottom" style="background:rgb(<?php echo $content->color ?>) !important"></div>

	</div>

</div>