<?php 

class OrdersController{

	/*=============================================
	Gestionar Órdenes
	=============================================*/

	public function manageOrder(){

		if(isset($_POST["idOrderPay"])){

			// echo '<script>
			// 	fncMatPreloader("on");
			// 	fncSweetAlert("loading", "Procesando la orden...", "");
			// </script>';

			$modeTV = "demo";

			$url = "https://developers.titulovalor.com/api/".$modeTV."/vwmk4xcqye81so2";
			$method = "GET";
			$fields = array();

			$getStatus = CurlController::apiTituloValor($url,$method,$fields);

			// if($getStatus->status == 200 && 
			// 	$getStatus->results->quality != 1 &&
			// 	$getStatus->results->resolution->status != 200 && 
			// 	$getStatus->results->events == 0){

			// 	echo'<div class="alert alert-danger mt-3 p-3 rounded alertPos">Error: Validar con Título Valor la Facturación Electrónica</div>

			// 	<script>

			// 		fncMatPreloader("off");
			// 		fncSweetAlert("close", "", "");
			// 		fncFormatInputs();
				 
			// 	</script>

			// 	';

			// 	return;
			// }

			$url = "orders?id=".$_POST["idOrderPay"]."&nameId=id_order&token=".$_SESSION["admin"]->token_admin."&table=admins&suffix=admin";
			$method = "PUT";
			$fields = array(
				"method_order" => $_POST["methodPay"],
				"transfer_order" => $_POST["transferPay"],
				"status_order" => "Completada"
			);

			// $fields = array(
			// 	"status_order" => "Pendiente"
			// );

			$fields = http_build_query($fields);

			$updateOrder = CurlController::request($url,$method,$fields);

			if($updateOrder->status == 200){

				/*=============================================
				Actualizar las ventas como completadas
				=============================================*/

				$url = "relations?rel=sales,orders&type=sale,order&linkTo=id_order_sale&equalTo=".$_POST["idOrderPay"]."&select=*";
				$method = "GET";
				$fields = array();

				$getSales = CurlController::request($url,$method,$fields);

				if($getSales->status == 200){

					$countSales = 0;

					$arrayProducts = array();

					foreach ($getSales->results as $key => $value) {

						$url = "sales?id=".$value->id_sale."&nameId=id_sale&token=".$_SESSION["admin"]->token_admin."&table=admins&suffix=admin";
						$method = "PUT";
						$fields = array(
							"status_sale" => "Completada"
						);

						// $fields = array(
						// 	"status_sale" => "Pendiente"
						// );

						$fields = http_build_query($fields);

						$updateSale = CurlController::request($url,$method,$fields);

						if($updateSale->status == 200){

							$countSales ++;

							/*=============================================
							Info de los productos
							=============================================*/

							$url = "products?linkTo=id_product&equalTo=".$value->id_product_sale;
							$method = "GET";
							$fields = array();

							$getProducts = CurlController::request($url,$method,$fields);	

							if($getProducts->status == 200){

								$product = $getProducts->results[0];
							
							}

							/*=============================================
							Arreglo de productos
							=============================================*/

							array_push($arrayProducts, array(

								"title_product" => urldecode($product->title_product),
							    "sku_product"=>  $product->sku_product,
							    "unit_product"=> $product->unit_product,
							    "qty_product"=> $value->qty_sale,
							    "tax_type_product"=> $value->tax_type_sale,
							    "tax_product"=> $value->tax_sale,
							    "discount_product"=> $value->discount_sale,
							    "subtotal_product"=> $value->subtotal_sale
							));

							if($countSales == count($getSales->results)){

								/*=============================================
								Traer info de la Sucursal
								=============================================*/

								$url = "offices?linkTo=id_office&equalTo=".$_SESSION["admin"]->id_office_admin;
								$method = "GET";
								$fields = array();

								$getOffice = CurlController::request($url,$method,$fields);

								if($getOffice->status == 200){

									$office = $getOffice->results[0];
								}

								/*=============================================
								El cliente es facturador
								=============================================*/

								if(isset($_POST["clientInvoice"]) && $_POST["clientInvoice"] == "yes"){

									$url = "clients?linkTo=id_client&equalTo=".$getSales->results[0]->id_client_order;
									$method = "GET";
									$fields = array();

									$getClient = CurlController::request($url,$method,$fields);

									if($getClient->status == 200){

										$client = $getClient->results[0];
										$customerDoc = $client->dni_client;
										$customerName = $client->name_client." ".$client->surname_client;
										$customerEmail = $client->email_client;
									}


								}else{

									$customerDoc = "222222222222";
									$customerName = "Consumidor Final";
									$customerEmail = "";

								}

						if(isset($_POST["emitirInvoice"]) && $_POST["emitirInvoice"] == "yes"){
								/*=============================================
								Enviar info de factura a la DIAN
								=============================================*/
							
								$url = "https://developers.titulovalor.com/api/".$modeTV."/vwmk4xcqye81so2";
								$method = "POST";
								$fields = array(
									"type"=>"invoice",
									"subtotal" => $getSales->results[0]->subtotal_order,
									"tax_amount" => $getSales->results[0]->tax_order,
									"discount" => $getSales->results[0]->discount_order,
									"total" => $getSales->results[0]->total_order,
									"tax_base" => $getSales->results[0]->tax_sale,
									"tax_type" => $getSales->results[0]->tax_type_sale,
									"customer" => array(
									    "doc"=> $customerDoc,
									    "name"=> $customerName,
									    "email"=> $customerEmail
									),
									"products" => $arrayProducts,
									"pos" => array(
									    "box_code" => $office->id_office,
									    "box_location"=> $office->title_office,
									    "cashier" => $_SESSION["admin"]->name_admin,
									    "box_type"=>"Caja de apoyo",
									    "sales_code"=>  $getSales->results[0]->transaction_order
								  	)
								);

								$setInvoice = CurlController::apiTituloValor($url,$method,json_encode($fields));
							
								if(isset($setInvoice->status)){

									if($setInvoice->status == 200){

										/*=============================================
										Creando la info de la factura
										=============================================*/
	
										$url = "invoices?token=".$_SESSION["admin"]->token_admin."&table=admins&suffix=admin";
										$method = "POST";
										$fields = array(
											"id_order_invoice" => $_POST["idOrderPay"],
											"type_invoice" => "Factura POS",
											"document_invoice" => $setInvoice->document,
											"cude_invoice" => $setInvoice->XmlDocumentKey,
											"zip_invoice" => $setInvoice->zip,
											"dian_invoice" => "https://catalogo-vpfe.dian.gov.co/document/searchqr?documentkey=".$setInvoice->XmlDocumentKey,
											"convert_invoice" => "/facturacion?idOrder=".$_POST["idOrderPay"]."&document=".$setInvoice->document."&cude=".$setInvoice->XmlDocumentKey,
											"fields_invoice" => json_encode($fields),
											"date_created_invoice" => date("Y-m-d")
										);

										$createInvoice = CurlController::request($url,$method,$fields);

										if($createInvoice->status == 200){

											/*=============================================
											Imprimos el Ticket y Abrimos cajón Monedero
											=============================================*/

											// $print = CurlController::ticketPrint($_POST["idOrderPay"],urlencode($_SESSION["admin"]->name_admin),$setInvoice->XmlDocumentKey);

											/*=============================================
											Devolvemos respuesta al vendedor
											=============================================*/

											echo '

											<script>

												fncMatPreloader("off");
												fncSweetAlert("success", "La órden #'.$getSales->results[0]->transaction_order.' ha sido completada con éxito", "/pos");
												fncFormatInputs();
											 
											</script>

											';


										}

									}else{

										echo '

										<script>

											fncMatPreloader("off");
											fncSweetAlert("error", "'.$setInvoice->results.' '.$setInvoice->message.'", "/pos");
											fncFormatInputs();
										 
										</script>

										';
									}

								}else{

									echo '

									<script>

										fncMatPreloader("off");
										fncSweetAlert("error", "Error con la API de Título Valor", "/pos");
										fncFormatInputs();
									 
									</script>

									';

								}

							}else{
									        /*=============================================
											Imprimos el Ticket y Abrimos cajón Monedero sin enviar factura a la Dian
											=============================================*/

											// $print = CurlController::ticketPrint($_POST["idOrderPay"],urlencode($_SESSION["admin"]->name_admin),$setInvoice->XmlDocumentKey);

											/*=============================================
											Devolvemos respuesta al vendedor
											=============================================*/

											echo '

											<script>

												fncMatPreloader("off");
												fncSweetAlert("success", "La órden #'.$getSales->results[0]->transaction_order.' ha sido completada con éxito", "/pos");
												fncFormatInputs();
											 
											</script>

											';

							}


							}

						}

					}

				}


			}else{

				echo'<div class="alert alert-danger mt-3 p-3 rounded alertPos">Error al procesar la orden</div>

				<script>

					fncMatPreloader("off");
					fncSweetAlert("close", "", "");
					fncFormatInputs();
				 
				</script>

				';

			}

		}

	}

}