<?php 

/*=============================================
Traer categorías desde la BD
=============================================*/

$url = "categories?linkTo=status_category&equalTo=1";
$method = "GET";
$fields = array();

$categories = CurlController::request($url,$method,$fields);

if($categories->status == 200){

	$categories = $categories->results;

}else{

	$categories = array();
}

?>

<!--===================================
JD SLIDER	
=====================================-->

<div class="jd-slider mb-0 pb-0">
	
	<div class="slide-inner">
		
		<ul class="slide-area">

			<?php if (!empty($categories)): ?>

				<li>

					<div class="border-0 rounded text-center bg-white mx-1 p-3 pb-0 loadCategory" idCategory="all">
							
						<img src="https://pos.tutorialesatualcance.com/views/assets/files/67659e224786f6.png" class="img-fluid mx-auto" style="width:50px; cursor:pointer">
						<p class="pt-2 mb-0 lead" style="cursor:move"><strong>Todo</strong></p>

						<?php 

						if ($_SESSION["admin"]->id_office_admin > 0) {
							
							$url = "products?linkTo=status_product,id_office_product&equalTo=1,".$_SESSION["admin"]->id_office_admin."&select=id_product";

							$totalProducts = CurlController::request($url,$method,$fields);

							if($totalProducts->status == 200){

								$totalProducts = $totalProducts->total;
							
							}else{

								$totalProducts = 0;
							}
						
						}else{

							$totalProducts = 0;
						}
	
						?>

						<p class="small pb-3" style="cursor:move"><?php echo $totalProducts ?> items</p>

					</div>
					
					
				</li>

				<?php foreach ($categories as $key => $value): ?>

					<li>
						
						<div class="border-0 rounded text-center bg-white mx-1 p-3 pb-0 loadCategory" idCategory="<?php echo $value->id_category ?>">
							
							<img src="<?php echo urldecode($value->img_category) ?>" class="img-fluid mx-auto" style="width:50px; cursor:pointer">
							<p class="pt-2 mb-0 lead" style="cursor:move"><strong><?php echo urldecode($value->title_category) ?></strong></p>

							<?php 

								if ($_SESSION["admin"]->id_office_admin > 0) {

									$url = "products?linkTo=id_category_product,status_product,id_office_product&equalTo=".$value->id_category.",1,".$_SESSION["admin"]->id_office_admin."&select=id_product";
									
									$totalProducts = CurlController::request($url,$method,$fields);

									if($totalProducts->status == 200){

										$totalProducts = $totalProducts->total;
									
									}else{
										
										$totalProducts = 0;
									}

								}else{

									$totalProducts = 0;
								}
							 ?>

							<p class="small pb-3" style="cursor:move"><?php echo $totalProducts ?> items</p>

						</div>
					</li>
					
				<?php endforeach ?>
				
			<?php endif ?>
			

		</ul>

		<a href="#" class="prev ps-1">	
			<i class="bi bi-chevron-left"></i>
		</a>

		<a href="#" class="next ps-1">	
			<i class="bi bi-chevron-right"></i>
		</a>

	</div>

	<div class="controller d-none">
		<div class="indicate-area"></div>	
	</div>

</div>