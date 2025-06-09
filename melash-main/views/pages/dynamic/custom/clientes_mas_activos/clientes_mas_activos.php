<?php 

$clientSale = array();
$topClients = array();

if($_SESSION["admin"]->id_office_admin > 0){

	$url = "sales?linkTo=id_office_sale&equalTo=".$_SESSION["admin"]->id_office_admin."&select=id_client_sale,qty_sale";

}else{

	$url = "sales?select=id_client_sale,qty_sale";

}

$method = "GET";
$fields = array();

$bestClient = CurlController::request($url,$method,$fields);

if($bestClient->status == 200){

	/*=============================================
	Creamos los índices del array
	=============================================*/

	foreach ($bestClient->results as $key => $value) {
		
		$clientSale[$value->id_client_sale] = 0;
		
	
	}

	/*=============================================
	Agregamos los valores del array
	=============================================*/

	foreach ($bestClient->results as $key => $value) {

		$clientSale[$value->id_client_sale] += $value->qty_sale;
	
	}

	arsort($clientSale);

	$topClients = array_slice($clientSale, 0, 5, true);

}

?>

<!--==============================
Custom
 ================================-->

<div class="<?php if ($module->width_module == "100"): ?> col-lg-12 <?php endif ?><?php if ($module->width_module == "75"): ?> col-lg-9 <?php endif ?><?php if ($module->width_module == "50"): ?> col-lg-6 <?php endif ?><?php if ($module->width_module == "33"): ?> col-lg-4 <?php endif ?><?php if ($module->width_module == "25"): ?> col-lg-3 <?php endif ?> col-12 mb-3 position-relative">

	<?php if ($_SESSION["admin"]->rol_admin == "superadmin"): ?>

		<div class="position-absolute border rounded" style="top:0px; right:12px; z-index:100">
			
			<button type="button" class="btn btn-sm text-muted rounded m-0 px-1 py-0 border-0 myModule" item='<?php echo json_encode($module) ?>' idPage="<?php echo $page->results[0]->id_page ?>">
				<i class="bi bi-pencil-square"></i>
			</button>

			<button type="button" class="btn btn-sm text-muted rounded m-0 px-1 py-0 border-0 deleteModule" idModule=<?php echo base64_encode($module->id_module) ?> >
				<i class="bi bi-trash"></i>
			</button>


		</div>
		
	<?php endif ?>

	<!--==============================
   Start Custom
  ================================-->

  <div class="card rounded">
  	
  	 <div class="card-header d-flex justify-content-between align-items-cente">
        <h3 class="card-title">Clientes más activos</h3>
		<button class="btn btn-primary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        Exportar
    </button>
    <ul class="dropdown-menu" aria-labelledby="exportDropdown">
        <li><a class="dropdown-item" href="#" id="exportCSV">Exportar a CSV</a></li>
    </ul>

      </div>

      <div class="card-body">

    		<?php if (!empty($topClients)): ?>

      		<ul class="list-group">
      			
      			<?php foreach ($topClients as $key => $value): ?>

      				<?php 

      				$url = "relations?rel=clients,offices&type=client,office&linkTo=id_client&equalTo=".$key."&select=name_client,surname_client,email_client,phone_client,title_office";
      				$listClients = CurlController::request($url,$method,$fields)->results[0];	
  
      				?>

      				<li class="list-group-item">
      					
      					<div class="d-flex border-bottom">

      						<div class="flex-fill w-100 text-center">
      							
      							<span class="badge badge-default backColor rounded small mt-2"><?php echo TemplateController::reduceText(urldecode($listClients->title_office),10) ?></span>

      						</div>

      						<div class="flex-fill w-100 text-center">
      							
      							<p class="mt-2"><?php echo TemplateController::reduceText(urldecode($listClients->name_client)." ".urldecode($listClients->surname_client),15) ?></p>
      							
      						</div>

      						<div class="flex-fill w-100 text-center">
      							
      							<p class="mt-2"><?php echo TemplateController::reduceText(urldecode($listClients->email_client),10) ?></p>
      							
      						</div>

      						<div class="flex-fill w-100 text-center">
      							
      							<p class="mt-2"><?php echo urldecode($listClients->phone_client) ?></p>
      							
      						</div>

      						<div class="flex-fill w-100 text-center">
      							
      							<span class="badge badge-default bg-teal rounded small mt-2"><?php echo $value ?></span>

      						</div>

      					</div>

      				</li>
	
      			<?php endforeach ?>

      		</ul>
      		
      	<?php endif ?>

      </div>


  </div>


</div>

<script>
   
   document.getElementById("exportCSV").addEventListener("click", function () {
    let csvContent = "\uFEFF"; // Agregamos BOM para que Excel detecte UTF-8 correctamente
    csvContent += "Oficina,Nombre,Correo,Teléfono,Ventas\n"; // Encabezados

    document.querySelectorAll(".list-group-item").forEach(row => {
        let office = row.querySelector(".badge.badge-default.backColor")?.innerText.trim() || "N/A";
        let name = row.querySelector(".flex-fill:nth-child(2) p")?.innerText.trim() || "N/A";
        let email = row.querySelector(".flex-fill:nth-child(3) p")?.innerText.trim() || "N/A";
        let phone = row.querySelector(".flex-fill:nth-child(4) p")?.innerText.trim() || "N/A";
        let sales = row.querySelector(".badge.bg-teal")?.innerText.trim() || "0";

        if (name !== "N/A") { // Evita agregar filas vacías
            csvContent += `"${office}","${name}","${email}","${phone}","${sales}"\n`;
        }
    });

    let blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
    let link = document.createElement("a");
    let url = URL.createObjectURL(blob);
    link.setAttribute("href", url);
    link.setAttribute("download", "clientes_activos.csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
});


</script>
