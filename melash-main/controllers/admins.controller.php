<?php 

class AdminsController{

	/*=============================================
	Login de adminstradores
	=============================================*/	

	public function login(){

		if(isset($_POST["email_admin"])){

			echo '<script>

				fncMatPreloader("on");
				fncSweetAlert("loading", "Ingresando...", "");

			</script>';

			$url = "admins?login=true&suffix=admin";
			$method = "POST";
			$fields = array(
				"email_admin" => $_POST["email_admin"],
				"password_admin" => $_POST["password_admin"]
			);

			$login = CurlController::request($url,$method,$fields);
			
			if($login->status == 200){

				/*=============================================
				Validar estado del administrador
				=============================================*/

				if($login->results[0]->status_admin == 0){

					echo '<div class="alert alert-danger mt-3 rounded">Error al ingresar: Administrador desactivado</div>

					<script>

						fncMatPreloader("off");
						fncFormatInputs();
						fncToastr("error", "Error al ingresar: Administrador desactivado");

					</script>';

					return;
				}

				/*=============================================
				Traer la info de sucursales
				=============================================*/

				if($login->results[0]->id_office_admin > 0){

					$url = "relations?rel=admins,offices&type=admin,office&linkTo=id_admin,id_office&equalTo=".$login->results[0]->id_admin.",".$login->results[0]->id_office_admin;
					$method = "GET";
					$fields = array();

					$login = CurlController::request($url,$method,$fields);


				}

				/*=============================================
				Crear variable de Sesión
				=============================================*/

				$_SESSION["admin"] = $login->results[0];

				echo '<script>

					localStorage.setItem("tokenAdmin","'.$login->results[0]->token_admin.'");
					fncMatPreloader("off");
					fncFormatInputs();
					location.reload();

				</script>';

				/*=============================================
				Generar y enviar código de seguridad al correo
				=============================================*/

				/*
				$securityCode = TemplateController::genPassword(6);

				$url = "admins?id=".$login->results[0]->id_admin."&nameId=id_admin&token=no&except=scode_admin";
				$method = "PUT";
				$fields = "scode_admin=".$securityCode;

				$updateAdmin = CurlController::request($url,$method,$fields);

				if($updateAdmin->status == 200){	

					$subject = "Códido de seguridad para ingresar";
					$email = $login->results[0]->email_admin;
					$title = 'CÓDIGO DE SEGURIDAD';
					$message = '<h4 style="font-weight: 100; color:#999; padding:0px 20px"><strong>Su código de seguridad: '.$securityCode.'</strong></4><h4 style="font-weight: 100; color:#999; padding:0px 20px">Ingrese nuevamente al sitio con este código de seguridad</4>';
					$link = $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"]."?scode=".base64_encode($login->results[0]->email_admin);

					$sendEmail = TemplateController::sendEmail($subject, $email, $title, $message, $link);

					if($sendEmail == "ok"){

						echo '<script>

								fncFormatInputs();
								fncMatPreloader("off");
								fncSweetAlert("success", 
								"Se ha enviado un código de seguridad para ingresar al sistema, por favor revise su correo electrónico o bandeja SPAM",
								setTimeout(()=>window.location="'.$_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["SERVER_NAME"].'?scode='.base64_encode($login->results[0]->email_admin).'",2000));

							</script>
						';

						return;

					}else{

						echo '<script>

							fncFormatInputs();
							fncMatPreloader("off");
							fncNotie("error", "'.$sendEmail.'");

							</script>
						';

						return;

					}

				}
				*/

			}else{

				echo '<div class="alert alert-danger mt-3 rounded">Error al ingresar: '.$login->results.'</div>

				<script>

					fncMatPreloader("off");
					fncFormatInputs();
					fncToastr("error", "Error al ingresar: '.$login->results.'");

				</script>';
			}


		}

	}


	/*=============================================
	Validar código de seguridad
	=============================================*/

	public function securityCode(){

		if(isset($_POST["scode_admin"])){

			echo '

			<script>

				fncMatPreloader("on");
			    fncSweetAlert("loading", "Procesando...", "");

			</script>

			';

			/*=============================================
			Validar admin
			=============================================*/

			$url = "admins?linkTo=scode_admin&equalTo=".$_POST["scode_admin"];
			$method = "GET";
			$fields = array();

			$admin = CurlController::request($url,$method,$fields);
			
			if($admin->status == 200){

				/*=============================================
				Crear variable de Sesión
				=============================================*/

				$_SESSION["admin"] = $admin->results[0];

				echo '<script>

					localStorage.setItem("tokenAdmin","'.$admin->results[0]->token_admin.'");
					fncMatPreloader("off");
					fncFormatInputs();
					location.reload();

				</script>';

			}else{

				echo '<div class="alert alert-danger mt-3 rounded">Error al ingresar: Código de seguridad no coincide</div>

				<script>

					fncMatPreloader("off");
					fncFormatInputs();
					fncToastr("error", "Error al ingresar: Código de seguridad no coincide");

				</script>';
			}

		}

	}

	/*=============================================
	Actualizar Administrador
	=============================================*/

	public function updateAdmin(){

		if(isset($_POST["id_admin"])){

			echo '

			<script>

				fncMatPreloader("on");
			    fncSweetAlert("loading", "Procesando...", "");

			</script>

			';

			/*=============================================
			Validar admin
			=============================================*/

			$url = "admins?linkTo=id_admin&equalTo=".base64_decode($_POST["id_admin"])."&select=id_admin,password_admin,rol_admin";
			$method = "GET";
			$fields = array();

			$admin = CurlController::request($url,$method,$fields);
			
			if($admin->status == 200){

				/*=============================================
				Si hay cambio de contraseña
				=============================================*/

				if(!empty($_POST["password_admin"])){

					$crypt = crypt($_POST["password_admin"], '$2a$07$azybxcags23425sdg23sdfhsd$');

				}else{

					$crypt = $admin->results[0]->password_admin;
					
				}

				/*=============================================
				Subir cambios a base de datos
				=============================================*/

				$url = "admins?id=".$admin->results[0]->id_admin."&nameId=id_admin&token=".$_SESSION["admin"]->token_admin."&table=admins&suffix=admin";	
				$method = "PUT";

				if($admin->results[0]->rol_admin == "superadmin"){

					$fields = "email_admin=".$_POST["email_admin"]."&password_admin=".$crypt."&title_admin=".$_POST["title_admin"]."&symbol_admin=".$_POST["symbol_admin"]."&font_admin=".urlencode($_POST["font_admin"])."&color_admin=".$_POST["color_admin"]."&back_admin=".$_POST["back_admin"];

				}else{

					$fields = "email_admin=".$_POST["email_admin"]."&password_admin=".$crypt;
				}

				$updateAdmin = CurlController::request($url,$method,$fields);

				if($updateAdmin->status == 200){

					$_SESSION["admin"]->email_admin = $_POST["email_admin"];

					echo '

					<script>

						fncMatPreloader("off");
						fncFormatInputs();
					    fncSweetAlert("success","El registro ha sido actualizado con éxito",setTimeout(()=>location.reload(),1250));
						
					</script>

					';

				}

			}else{

				echo '

				<script>

				    fncToastr("error","El registro no existe");
					fncMatPreloader("off");
					fncFormatInputs();

				</script>

				';
			}



		}

	}

	/*=============================================
	Recuperar contraseña
	=============================================*/

	public function resetPassword(){

		if(isset($_POST["resetPassword"])){

			echo '<script>

				fncMatPreloader("on");
				fncSweetAlert("loading", "", "");

			</script>';

			/*=============================================
			Preguntamos primero si el usuario está registrado
			=============================================*/	

			$url = "admins?linkTo=email_admin&equalTo=".$_POST["resetPassword"]."&select=id_admin";
			$method = "GET";
			$fields = array();

			$admin = CurlController::request($url,$method,$fields);
			
			if($admin->status == 200){

				$newPassword = TemplateController::genPassword(11);
				$crypt = crypt($newPassword, '$2a$07$azybxcags23425sdg23sdfhsd$');

				/*=============================================
				Actualizar contraseña en base de datos
				=============================================*/
				$url = "admins?id=".$admin->results[0]->id_admin."&nameId=id_admin&token=no&except=password_admin";
				$method = "PUT";
				$fields = "password_admin=".$crypt;

				$updatePassword = CurlController::request($url,$method,$fields);

				if($updatePassword->status == 200){

					$subject = "Solicitud de nueva contraseña";
					$email = $_POST["resetPassword"];
					$title = 'SOLICITUD DE NUEVA CONTRASEÑA';
					$message = '<h4 style="font-weight: 100; color:#999; padding:0px 20px"><strong>Su nueva contraseña: '.$newPassword.'</strong></4><h4 style="font-weight: 100; color:#999; padding:0px 20px">Ingrese nuevamente al sitio con esta contraseña y recuerde cambiarla</4>';
					$link = $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"];

					$sendEmail = TemplateController::sendEmail($subject, $email, $title, $message, $link);

					if($sendEmail == "ok"){

						echo '<script>

								fncFormatInputs();
								fncMatPreloader("off");
								fncToastr("success", "Su nueva contraseña ha sido enviada con éxito, por favor revise su correo electrónico");

							</script>
						';

					}else{

						echo '<script>

							fncFormatInputs();
							fncMatPreloader("off");
							fncNotie("error", "'.$sendEmail.'");

							</script>
						';
					}
				}

			}else{
				
				echo '<script>

						fncFormatInputs();
						fncMatPreloader("off");
						fncNotie("error", "El correo no existe en la base de datos");

					</script>
				';

			}
		}
	}

}