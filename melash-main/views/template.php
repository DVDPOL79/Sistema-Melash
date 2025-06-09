<?php 

/*=============================================
Iniciar variables de sesión
=============================================*/

ob_start();
session_start();

date_default_timezone_set("America/Bogota");

/*=============================================
Capturar parámetros de la url
=============================================*/

$routesArray = explode("/", $_SERVER["REQUEST_URI"]);

array_shift($routesArray);

foreach ($routesArray as $key => $value) {
	
	$routesArray[$key] = explode("?",$value)[0];
}

/*=============================================
Validar si existe la base de datos con la tabla admins
=============================================*/

$url = "admins";
$method = "GET";
$fields = array();

$adminTable = CurlController::request($url,$method,$fields);

if($adminTable->status == 404){

	$admin = null;

}else{

	$admin = $adminTable->results[0];
	// echo '<pre>'; print_r($admin); echo '</pre>';
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="http://cms.pos.net/views/assets/files/67e594b8ebf194.png">
	

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

	<!--=============================================
	Validamos si admin existe
	===============================================-->

	<?php if (!empty($admin)): ?>

		<!--=============================================
		Título del Dashboard
		===============================================-->

		<title><?php echo $admin->title_admin ?></title>

		<!--=============================================
		Típografía del dashboard
		===============================================-->

		<?php if ($admin->font_admin != null): ?>

			<?php echo $admin->font_admin ?>

		<?php endif ?>

		<!--=============================================
		Estilos propios del dashboard
		===============================================-->

		<style>
			
			/*=============================================
			Típografía del dashboard
			=============================================*/

			<?php if ($admin->font_admin != null):?>

				body{
					font-family: <?php echo str_replace("+"," ",explode("=",explode(":",explode("?",$admin->font_admin)[1])[0])[1]) ?>, sans-serif !important;	
				}

			<?php endif ?>

			/*=============================================
			Color del dashboard
			=============================================*/

			.backColor{
				background: <?php echo $admin->color_admin ?> !important;
				color: #FFF !important;
				border: 0 !important;
			}

			.form-check-input:checked{
				background-color: <?php echo $admin->color_admin ?> !important;
			    border-color: <?php echo $admin->color_admin ?> !important;
			}

			.textColor{
				color: <?php echo $admin->color_admin ?> !important;
			}

			.page-item.active .page-link {
				z-index: 3;
				color: #fff !important;
				background-color: <?php echo $admin->color_admin ?> !important;
				border-color: <?php echo $admin->color_admin ?> !important;
			}

			.page-link {
				color: <?php echo $admin->color_admin ?> !important;		
			}

		</style>

	<?php else: ?>

		<title>CMS Builder</title>

	<?php endif ?>

	<!--=============================================
	CUSTOM JS SERVER
	===============================================-->

	<script src="/views/assets/js/alerts/alerts.js"></script>

	<!--=============================================
	PLUGINS CSS
	===============================================-->

	<!-- https://www.w3schools.com/bootstrap5/ -->
	<link rel="stylesheet" href="/views/assets/plugins/bootstrap5/bootstrap.min.css" >
	<!-- https://fontawesome.com/v5/search -->
	<link rel="stylesheet" href="/views/assets/plugins/fontawesome-free/css/all.min.css">
	<!-- https://icons.getbootstrap.com/ -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
	<!-- https://www.jqueryscript.net/demo/Google-Inbox-Style-Linear-Preloader-Plugin-with-jQuery-CSS3/#google_vignette -->
	<link rel="stylesheet" href="/views/assets/plugins/material-preloader/material-preloader.css">
	<!-- https://codeseven.github.io/toastr/demo.html -->
	<link rel="stylesheet" href="/views/assets/plugins/toastr/toastr.min.css">
	<!--  https://www.daterangepicker.com/ -->
	<link rel="stylesheet" href="/views/assets/plugins/daterangepicker/daterangepicker.css">
	<!-- https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/examples/ -->
	<link rel="stylesheet" href="/views/assets/plugins/tags-input/tags-input.css">
	<!-- https://select2.org/ -->
	<link rel="stylesheet" href="/views/assets/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="/views/assets/plugins/select2/select2-bootstrap4.min.css">
    <!-- https://xdsoft.net/jqplugins/datetimepicker/ -->
    <link rel="stylesheet" href="/views/assets/plugins/datetimepicker/datetimepicker.min.css">
    <!-- https://summernote.org -->	
    <link rel="stylesheet" href="/views/assets/plugins/summernote/summernote-bs4.min.css"> 
    <link rel="stylesheet" href="/views/assets/plugins/summernote/summernote.min.css">
    <link rel="stylesheet" href="/views/assets/plugins/summernote/emoji.css">
    <!-- https://codemirror.net/ -->
    <link rel="stylesheet" href="/views/assets/plugins/codemirror/codemirror.css">
	<link rel="stylesheet" href="/views/assets/plugins/codemirror/monokai.css">
	<!-- https://www.jqueryscript.net/slider/Carousel-Slideshow-jdSlider.html -->
    <link rel="stylesheet" href="/views/assets/plugins/jdSlider/jdSlider.css">

	<!--=============================================
	PLUGINS JS
	===============================================-->

	<!-- https://jquery.com/ -->
	<script src="/views/assets/plugins/jquery/jquery.min.js"></script>
	<!-- https://jqueryui.com/ -->
	<script src="/views/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
	<!-- https://www.w3schools.com/bootstrap5/ -->
	<script src="/views/assets/plugins/bootstrap5/bootstrap.bundle.min.js"></script>
	<!-- https://sweetalert2.github.io/ -->
	<script src="/views/assets/plugins/sweetalert/sweetalert.min.js"></script> 
	<!-- https://www.jqueryscript.net/demo/Google-Inbox-Style-Linear-Preloader-Plugin-with-jQuery-CSS3/ -->
	<script src="/views/assets/plugins/material-preloader/material-preloader.js"></script> 
	<!-- https://codeseven.github.io/toastr/demo.html -->
	<script src="/views/assets/plugins/toastr/toastr.min.js"></script>
	<!-- http://josecebe.github.io/twbs-pagination/ -->
	<script src="/views/assets/plugins/twbs-pagination/twbs-pagination.min.js"></script> 
	<!-- https://momentjs.com/ -->
	<script src="/views/assets/plugins/moment/moment.min.js"></script>
	<script src="/views/assets/plugins/moment/moment-with-locales.min.js"></script>
	<!--  https://www.daterangepicker.com/ -->
	<script src="/views/assets/plugins/daterangepicker/daterangepicker.js"></script>	
	<!-- https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/examples/ -->
	<script src="/views/assets/plugins/tags-input/tags-input.js"></script> 
	<!-- https://select2.org/ -->
	<script src="/views/assets/plugins/select2/select2.full.min.js"></script>
	<!-- https://xdsoft.net/jqplugins/datetimepicker/ -->
	<script src="/views/assets/plugins/datetimepicker/datetimepicker.full.min.js"></script>
	<!-- https://summernote.org -->	
	<script src="/views/assets/plugins/summernote/summernote.min.js"></script>
	<script src="/views/assets/plugins/summernote/summernote-bs4.js"></script>
    <script src="/views/assets/plugins/summernote/summernote-code-beautify-plugin.js"></script>
	<script src="/views/assets/plugins/summernote/emoji.config.js"></script>
	<script src="/views/assets/plugins/summernote/tam-emoji.min.js"></script>
	<!-- https://codemirror.net/ -->
	<script src="/views/assets/plugins/codemirror/codemirror.js"></script>
	<script src="/views/assets/plugins/codemirror/xml.js"></script>
	<script src="/views/assets/plugins/codemirror/formatting.js"></script>
	<!-- https://www.chartjs.org/ -->
	<script src="/views/assets/plugins/chartjs/chartjs.min.js"></script>
	<!-- https://www.jqueryscript.net/slider/Carousel-Slideshow-jdSlider.html -->
	<script src="/views/assets/plugins/jdSlider/jdSlider.js"></script>
	<script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>
	<!--=============================================
	CUSTOM CSS
	===============================================-->
	<link rel="stylesheet" href="/views/assets/css/custom/custom.css">
	<link rel="stylesheet" href="/views/assets/css/dashboard/dashboard.css">
	<link rel="stylesheet" href="/views/assets/css/colors/colors.css">
	<link rel="stylesheet" href="/views/assets/css/fms/fms.css">
	<link href="https://unpkg.com/intro.js/minified/introjs.min.css" rel="stylesheet">

</head>
<body>

	<?php 

	if(!isset($_SESSION["admin"])){

		if($admin == null){

			include "pages/install/install.php";

		}else{

			include "pages/login/login.php";
		}

	}

	?>

	<?php if (isset($_SESSION["admin"])): ?>

		<!--=============================================
		PLANTILLA DASHBOARD
		===============================================-->

		<div class="d-flex backDashboard" id="wrapper">
			
			<!--=============================================
			SIDEBAR
			===============================================-->

			<?php include "modules/sidebar.php" ?>

			<div id="page-content-wrapper">
				
				<!--=============================================
				NAV
				===============================================-->

				<?php include "modules/nav.php" ?>

				<!--=============================================
				MAIN PAGE
				===============================================-->

				<?php if (!empty($routesArray[0])): ?>

					<?php if ($routesArray[0] == "logout"): ?>

						<?php include "pages/".$routesArray[0]."/".$routesArray[0].".php"; ?>

					<?php else: ?>

						<!--=========================================
						Validar permisos
						===========================================-->

						<?php if ($_SESSION["admin"]->rol_admin == "superadmin" || $_SESSION["admin"]->rol_admin == "admin" || $_SESSION["admin"]->rol_admin == "editor" && isset(json_decode(urldecode($_SESSION["admin"]->permissions_admin), true)[$routesArray[0]]) && json_decode(urldecode($_SESSION["admin"]->permissions_admin), true)[$routesArray[0]] == "on"): ?>

							<!--=========================================
							Agregamos páginas dinámicas y personalizadas
							===========================================-->

							<?php 

								$url = "pages?linkTo=url_page&equalTo=".$routesArray[0];
								$method = "GET";
								$fields = array();

								$page = CurlController::request($url,$method,$fields);
								
								if($page->status == 200 && $page->results[0]->type_page == "modules"){

									include "pages/dynamic/dynamic.php";
								
								}else if($page->status == 200 && $page->results[0]->type_page == "custom"){

									include "pages/custom/".$routesArray[0]."/".$routesArray[0].".php";
								
								}else{

									include "pages/404/404.php";
								
								}

							?>

						<?php else: ?>

							<?php include "pages/404/404.php"; ?>

						<?php endif ?>
						
					<?php endif ?>

				<?php else: ?>


					<!--=========================================
				 	Validar permisos para super y admins
					===========================================-->

					<?php if ($_SESSION["admin"]->rol_admin == "superadmin" || $_SESSION["admin"]->rol_admin == "admin"): ?>

						<!--=========================================
						Agregamos la página inicial
						===========================================-->

						<?php 

							$url = "pages?linkTo=order_page&equalTo=1";
							$method = "GET";
							$fields = array();

							$page = CurlController::request($url,$method,$fields);

							if($page->status == 200 && $page->results[0]->type_page == "modules"){

								include "pages/dynamic/dynamic.php";
							
							}else if($page->status == 200 && $page->results[0]->type_page == "custom"){

								include "pages/custom/".$page->results[0]->url_page."/".$page->results[0]->url_page.".php";
							
							}else{

								include "pages/404/404.php";
							
							}
						
						?>

					<?php else: ?>

					<!--=========================================
				 	Validar permisos para editores
					===========================================-->

						<?php if ($_SESSION["admin"]->rol_admin == "editor"): ?>

							<?php

								$url = "pages?linkTo=url_page&equalTo=".array_keys(json_decode(urldecode($_SESSION["admin"]->permissions_admin),true))[0];
								$method = "GET";
								$fields = array();

								$page = CurlController::request($url,$method,$fields);

								$routesArray[0] = array_keys(json_decode(urldecode($_SESSION["admin"]->permissions_admin),true))[0];

								if($page->status == 200 && $page->results[0]->type_page == "modules"){

									include "pages/dynamic/dynamic.php";
								
								}else if($page->status == 200 && $page->results[0]->type_page == "custom"){

									include "pages/custom/".$page->results[0]->url_page."/".$page->results[0]->url_page.".php";
								
								}else{

									include "pages/404/404.php";
								
								}

							?>

						<?php endif ?>

					<?php endif ?>

				<?php endif ?>

			</div>

		</div>

		<?php 

		/*=============================================
    	Incluimos modal de perfiles
    	=============================================*/

    	include "modules/modals/profile.php"; 
		require_once "controllers/admins.controller.php";
		$update = new AdminsController();
	    $update->updateAdmin();

	    if($_SESSION["admin"]->rol_admin == "superadmin"){

	    	/*=============================================
	    	Incluimos modal de páginas
	    	=============================================*/

		    include "views/modules/modals/pages.php";

		    require_once "controllers/pages.controller.php";
			$managePage = new PagesController();
		    $managePage->managePage();

		    /*=============================================
	    	Incluimos modal de módulos
	    	=============================================*/

		    include "views/modules/modals/modules.php";

		    require_once "controllers/modules.controller.php";
			$manageModule = new ModulesController();
			$manageModule->manageModule();
   
		}

		?>

	<!--=============================================
	CUSTOM JS
	===============================================-->

	<script src="/views/assets/js/dashboard/dashboard.js"></script>
	<script src="/views/assets/js/pages/pages.js"></script>
	<script src="/views/assets/js/modules/modules.js"></script>
	<script src="/views/assets/js/dynamic-forms/dynamic-forms.js"></script>
	<script src="/views/assets/js/dynamic-tables/dynamic-tables.js"></script>
	<script src="/views/assets/js/fms/fms.js"></script>
	<script src="/views/assets/js/purchase/purchase.js"></script>
		
	<?php endif ?>

	<script src="/views/assets/js/forms/forms.js"></script>
	
	
</body>
</html>