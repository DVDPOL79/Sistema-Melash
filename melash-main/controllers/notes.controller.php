<?php 

class NotesController{

	static public function createNote($idOrder,$document,$cude){

		$url = "invoices?linkTo=id_order_invoice,document_invoice,cude_invoice&equalTo=".$idOrder.",".$document.",".$cude."&select=id_invoice,fields_invoice";
		$method = "GET";
		$fields = array();

		$getInvoice = CurlController::request($url,$method,$fields);
		
		if($getInvoice->status == 200){
			
			$getInvoice = $getInvoice->results[0];

			$fields = json_decode($getInvoice->fields_invoice);
			$fields->type = "note";
			$fields->prefix = preg_replace('/\d/','', $document)."NC";
			$fields->number = filter_var($document, FILTER_SANITIZE_NUMBER_INT);
			$fields->invoice = $document;
			$fields->cude =  $cude;

			$modeTV = "demo";

			$url = "https://developers.titulovalor.com/api/".$modeTV."/vwmk4xcqye81so2";
			$method = "POST";

			$setNote = CurlController::apiTituloValor($url,$method,json_encode($fields));
			
			if(isset($setNote->status)){
				
				if($setNote->status == 200){

					/*=============================================
					Creamos la Nota Crédito
					=============================================*/

					$url = "invoices?token=".$_SESSION["admin"]->token_admin."&table=admins&suffix=admin";
					$method = "POST";
					$fields = array(
						"id_order_invoice" => $idOrder,
						"type_invoice" => "Nota Crédito",
						"document_invoice" => $setNote->document,
						"cude_invoice" => $setNote->XmlDocumentKey,
						"zip_invoice" => $setNote->zip,
						"dian_invoice" => "https://catalogo-vpfe.dian.gov.co/document/searchqr?documentkey=".$setNote->XmlDocumentKey,
						"convert_invoice" => "",
						"fields_invoice" => json_encode($fields),
						"date_created_invoice" => date("Y-m-d")
					);


					$createNC = CurlController::request($url,$method,$fields);

					if($createNC->status == 200){

						/*=============================================
						Actualizamos Factura Electrónica
						=============================================*/

						$url = "invoices?id=".$getInvoice->id_invoice."&nameId=id_invoice&token=".$_SESSION["admin"]->token_admin."&table=admins&suffix=admin";
						$method = "PUT";
						$fields = array(
							"convert_invoice" => ""
						);

						$fields = http_build_query($fields);

						$updateInvoice = CurlController::request($url,$method,$fields);

						if($updateInvoice->status == 200){

							return "ok";
						
						}
	

					}

				}else{

					return $setNote->results." ".$setNote->message;

				}

			}else{

				return "Error con la API de Título Valor";
			}
			

		}else{

			return "Error al encontrar la factura";

		}


	}

}