<?php 

class PagesController{

	public function managePage(){

		if(isset($_POST["title_page"])){

			/*=============================================
			Editar Página
			=============================================*/

			if(isset($_POST["id_page"])){

				$url = "pages?id=".base64_decode($_POST["id_page"])."&nameId=id_page&token=".$_SESSION["admin"]->token_admin."&table=admins&suffix=admin";
				$method = "PUT";
				$fields = "title_page=".trim($_POST["title_page"])."&url_page=".urlencode(strtolower(trim($_POST["url_page"])))."&icon_page=".trim($_POST["icon_page"])."&type_page=".$_POST["type_page"];
			
				$update = CurlController::request($url,$method,$fields);

				if($update->status == 200){

					echo '

					<script>

						fncMatPreloader("off");
						fncFormatInputs();
					    fncSweetAlert("success","La página ha sido actualizada con éxito",setTimeout(()=>location.reload(),1250));	

					</script>

					';

				}


			}else{

				/*=============================================
				Validar que la Página no exista
				=============================================*/

				$url = "pages?linkTo=title_page,url_page&equalTo=".trim($_POST["title_page"]).",".trim($_POST["url_page"]);
				$method = "GET";
				$fields = array();

				$getPage = CurlController::request($url,$method,$fields);
				
				if($getPage->status == 200){

					echo '

					<script>

						fncMatPreloader("off");
						fncFormatInputs();
					    fncToastr("error","ERROR: Esta página ya existe");	

					</script>

					';

					return;

				}

				/*=============================================
				Crear Página
				=============================================*/

				$url = "pages?token=".$_SESSION["admin"]->token_admin."&table=admins&suffix=admin";
				$method = "POST";
				$fields = array(
					"title_page" => trim($_POST["title_page"]),
					"url_page" => urlencode(strtolower(trim($_POST["url_page"]))),
					"icon_page" => trim($_POST["icon_page"]),
					"type_page" =>$_POST["type_page"],
					"order_page" => 1000,
					"date_created_page" => date("Y-m-d")
				);

				$create = CurlController::request($url,$method,$fields);

				if($create->status == 200){

					/*=============================================
					Crear Página personalizable
					=============================================*/

					if($fields["type_page"] == "custom"){

						/*=============================================
						Creamos carpeta de página personalizable
						=============================================*/

						$directory = DIR."/views/pages/custom/".$fields["url_page"];

						if(!file_exists($directory)){

							mkdir($directory, 0755);
						}

						/*=============================================
						Copiamos el archivo custom con el nuevo nombre
						=============================================*/	

						$from = DIR."/views/pages/custom/custom.php";

						if(copy($from, $directory.'/'.$fields["url_page"].'.php')){

							echo '

							<script>

								fncMatPreloader("off");
								fncFormatInputs();
							    fncSweetAlert("success","La página ha sido creada con éxito",setTimeout(()=>window.location="/'.$fields["url_page"].'",1250));	

							</script>

							';

						}

					}else if($fields["type_page"] == "external_link" || $fields["type_page"] == "internal_link"){

						echo '

						<script>

							fncMatPreloader("off");
							fncFormatInputs();
						    fncSweetAlert("success","La página ha sido creada con éxito",setTimeout(()=>location.reload(),1250));	

						</script>

						';


					}else{

						echo '

						<script>

							fncMatPreloader("off");
							fncFormatInputs();
						    fncSweetAlert("success","La página ha sido creada con éxito",setTimeout(()=>window.location="/'.$fields["url_page"].'",1250));	

						</script>

						';

					}

				}


			}


		}

	}

}