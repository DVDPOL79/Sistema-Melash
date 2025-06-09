/*=============================================
Abrir ventana modal de módulos
=============================================*/

$(document).on("click",".myModule",function(){

	var idPage = $(this).attr("idPage");
	var item = $(this).attr("item");
	
	$("#myModule").modal("show");

	/*=============================================
	Cuando se abre la ventana modal
	=============================================*/

	$("#myModule").on('shown.bs.modal', function () {

		$("input[name='id_page_module']").remove();
		$("input[name='id_module']").remove();

		/*=============================================
		Capturar el Id de la página
		=============================================*/

		$("#type_module").before(`
			<input type="hidden" value="${btoa(idPage)}" name="id_page_module">
		 `)

		$("#metricsBlock").hide();
		$("#graphicsBlock").hide();
		$("#suffixModule").hide();
		$("#editableModule").hide();
		$("#columnsBlock").hide();

		/*=============================================
		tipo de módulo seleccionado
		=============================================*/

		$(document).on("change","#type_module",function(){

			$("#metricsBlock").hide();
			$("#graphicsBlock").hide();
			$("#suffixModule").hide();
			$("#editableModule").hide();
			$("#columnsBlock").hide();

			/*=============================================
			Aparecer campos de métricas
			=============================================*/

			if($(this).val() == "metrics"){

				$("#metricsBlock").show();

			}

			/*=============================================
			Aparecer campos de gráficos
			=============================================*/

			if($(this).val() == "graphics"){

				$("#graphicsBlock").show();

			}

			/*=============================================
			Aparecer campos de tablas
			=============================================*/

			if($(this).val() == "tables"){

				$("#suffixModule").show();
				$("#editableModule").show();
				$("#columnsBlock").show();
			}


		})
		
		/*=============================================
		Estamos editando módulo
		=============================================*/

		if(item != undefined){

			$("#type_module").before(`
				<input type="hidden" value="${btoa(JSON.parse(item).id_module)}" name="id_module">
			`)

			/*=============================================
			tipo breadcrumbs
			=============================================*/

			if(JSON.parse(item).type_module == "breadcrumbs"){

				$("#type_module").val(JSON.parse(item).type_module);
				$("#type_module").attr("disabled",true);
				$("#title_module").attr("readonly",false);
				$("#title_module").val(JSON.parse(item).title_module);
				$("#width_module").val(JSON.parse(item).width_module);
			}

			/*=============================================
			tipo metrics
			=============================================*/

			if(JSON.parse(item).type_module == "metrics"){

				$("#type_module").val(JSON.parse(item).type_module);
				$("#type_module").attr("disabled",true);
				$("#title_module").attr("readonly",false);
				$("#title_module").val(JSON.parse(item).title_module);
				$("#width_module").val(JSON.parse(item).width_module);
			
				$("#metricsBlock").show();

				$("#metricType").val(JSON.parse(JSON.parse(item).content_module).type);
				$("#metricTable").val(JSON.parse(JSON.parse(item).content_module).table);
				$("#metricColumn").val(JSON.parse(JSON.parse(item).content_module).column);
				$("#metricConfig").val(JSON.parse(JSON.parse(item).content_module).config);
				$("#metricIcon").val(JSON.parse(JSON.parse(item).content_module).icon);
				$("#metricColor").val(JSON.parse(JSON.parse(item).content_module).color);

				$("#content_module").val(JSON.parse(item).content_module);	      

			}

			/*=============================================
			tipo gráfico
			=============================================*/

			if(JSON.parse(item).type_module == "graphics"){

				$("#type_module").val(JSON.parse(item).type_module);
				$("#type_module").attr("disabled",true);
				$("#title_module").attr("readonly",false);
				$("#title_module").val(JSON.parse(item).title_module);
				$("#width_module").val(JSON.parse(item).width_module);
			
				$("#graphicsBlock").show();

				$("#graphicType").val(JSON.parse(JSON.parse(item).content_module).type);
				$("#graphicTable").val(JSON.parse(JSON.parse(item).content_module).table);
				$("#graphicX").val(JSON.parse(JSON.parse(item).content_module).xAxis);
				$("#graphicY").val(JSON.parse(JSON.parse(item).content_module).yAxis);
				$("#graphicColor").val(JSON.parse(JSON.parse(item).content_module).color);

				$("#content_module").val(JSON.parse(item).content_module);	      
				

			}

			/*=============================================
			tipo tables
			=============================================*/

			if(JSON.parse(item).type_module == "tables"){

				$("#type_module").val(JSON.parse(item).type_module);
				$("#type_module").attr("disabled",true);
				$("#type_module").before(`
					<input type="hidden" name="type_module" value="tables">
				 `);
				$("#title_module").val(JSON.parse(item).title_module);
				$("#title_module").attr("readonly", true);
				$("#suffixModule").show();
				$("#suffix_module").val(JSON.parse(item).suffix_module);
				$("#suffix_module").attr("readonly", true);
				$("#width_module").val(JSON.parse(item).width_module);
				$("#editableModule").show();
				$("#editable_module").val(JSON.parse(item).editable_module);

				$("#columnsBlock").show();

				var indexColumns = JSON.parse($("#indexColumns").val());

				$(".listColumns").html('');

				/*=============================================
				Visualizar las columnas a editar
				=============================================*/

				JSON.parse(item).columns.forEach((e,i)=>{

					/*=============================================
					Marcar tipo de columna seleccionado
					=============================================*/

					var typeColumn = ["text","textarea","int","double","image","video","file","boolean","select","array","object","json","date","time","datetime","timestamp","code","link","color","money","password","email","relations","order","chatgpt"];
					var selectColumn = [];

					typeColumn.forEach((v,f)=>{

						if(e.type_column == v){

							selectColumn[f] = "selected";
						
						}else{

							selectColumn[f] = "";
						}
					})

					/*=============================================
					Marcar el display y mt
					=============================================*/

					var display = "d-none";
					var mt = "";

					if(i == 0){

						display = "d-block";
						mt = "mt-4";
					}

					/*=============================================
					Marcar la selección de visibilidad
					=============================================*/

					var selectOn = "";
					var selectOff = "";	

					if(e.visible_column == 1){
						selectOn = "selected";
					}

					if(e.visible_column == 0){
						selectOff = "selected";
					}

					
					$(".listColumns").append(`

						<div class="row">

						    <input type="hidden" name="id_column_${i}" value="${e.id_column}">
						    <input type="hidden" name="original_title_column_${i}" value="${e.title_column}">

							<div class="col-4 mb-3">

								<label class="${display}">Título</label>
								<input
								type="text"
								class="form-control rounded form-control-sm"
								id="title_column_${i}"
								name="title_column_${i}"
								value="${e.title_column}"
								required>

								<div class="valid-feedback">Válido</div>
								<div class="invalid-feedback">Campo Inválido</div>

							</div>


							<div class="col-3 mb-3">

								<label class="${display}">Alias</label>
								<input
								type="text"
								class="form-control rounded form-control-sm"
								id="alias_column_${i}"
								name="alias_column_${i}"
								value="${e.alias_column}"
								required>

								<div class="valid-feedback">Válido</div>
								<div class="invalid-feedback">Campo Inválido</div>

							</div>

							<div class="col-2 mb-3">

								<label class="${display}">Típo</label>
								
								<select 
								class="form-select form-select-sm rounded" 
								id="type_column_${i}"
								name="type_column_${i}"
								required>

									<option value="text" ${selectColumn[0]}>Texto</option>
									<option value="textarea" ${selectColumn[1]}>Área Texto</option>
									<option value="int" ${selectColumn[2]}>Número Entero</option>
									<option value="double" ${selectColumn[3]}>Número Decimal</option>
									<option value="image" ${selectColumn[4]}>Imagen</option>
									<option value="video" ${selectColumn[5]}>Video</option>
									<option value="file" ${selectColumn[6]}>Archivo</option>
									<option value="boolean" ${selectColumn[7]}>Boleano</option>
									<option value="select" ${selectColumn[8]}>Selección</option>
									<option value="array" ${selectColumn[9]}>Arreglo</option>
									<option value="object" ${selectColumn[10]}>Objeto</option>
									<option value="json" ${selectColumn[11]}>JSON</option>
									<option value="date" ${selectColumn[12]}>Fecha</option>
									<option value="time" ${selectColumn[13]}>Hora</option>
									<option value="datetime" ${selectColumn[14]}>Fecha y Hora</option>
									<option value="timestamp" ${selectColumn[15]}>Fecha Automática</option>
									<option value="code" ${selectColumn[16]}>Código</option>
									<option value="link" ${selectColumn[17]}>Enlace</option>
									<option value="color" ${selectColumn[18]}>Color</option>
									<option value="money" ${selectColumn[19]}>Dinero</option>
									<option value="password" ${selectColumn[20]}>Contraseña</option>
									<option value="email" ${selectColumn[21]}>Email</option>
									<option value="relations" ${selectColumn[22]}>Relaciones</option>
									<option value="order" ${selectColumn[23]}>Ordenar</option>
									<option value="chatgpt" ${selectColumn[24]}>ChatGPT</option>

								</select>

								<div class="valid-feedback">Válido</div>
								<div class="invalid-feedback">Campo Inválido</div>

							</div>

							<div class="col-2 mb-3">

								<label class="${display}">Visibilidad</label>

								<select 
								class="form-select form-select-sm rounded" 
								name="visible_column_${i}" 
								id="visible_column_${i}" 
								required>
									<option value="1" ${selectOn}>ON</option>
									<option value="0" ${selectOff}>OFF</option>							
								</select>
							
								<div class="valid-feedback">Válido</div>
								<div class="invalid-feedback">Campo Inválido</div>

							</div>

							<div class="col-1 mb-3">

								<button type="button" class="btn btn-sm btn-default border rounded ${mt} deleteColumn" index="${i}" idItem="${e.id_column}">
									<i class="bi bi-trash"></i>
								</button>

							</div>

						</div>	

					 `)

					indexColumns.push(i);

				})

				$("#indexColumns").val(JSON.stringify(indexColumns));

			}

			/*=============================================
			tipo personalizable
			=============================================*/

			if(JSON.parse(item).type_module == "custom"){

				$("#type_module").val(JSON.parse(item).type_module);
				$("#type_module").attr("disabled",true);
				$("#title_module").val(JSON.parse(item).title_module);
				$("#title_module").attr("readonly", true);
			}


		/*=============================================
		Estamos creando módulo
		=============================================*/
		
		}else{
			$("#type_module").attr("disabled",false);
			$("#title_module").attr("readonly",false);
			$("#title_module").val("");
		}
	
	})

	/*=============================================
	Cuando se cierra la ventana modal
	=============================================*/

	$("#myModule").on('hidden.bs.modal', function (){

		$("#type_module").val("breadcrumbs");
		$("#metricsBlock").hide();
		$("#graphicsBlock").hide();
	})

})

/*=============================================
Eliminar un módulo
=============================================*/

$(document).on("click",".deleteModule",function(){

	var idModule = $(this).attr("idModule");
	
	if(atob(idModule) == 1 || atob(idModule) == 2){

		fncToastr("error", "Este módulo no se puede borrar");
		return;
	}

	fncSweetAlert("confirm", "¿Está seguro de borrar este módulo?", "").then(resp=>{

		if(resp){
			
			var data = new FormData();
			data.append("idModuleDelete",idModule);
			data.append("token", localStorage.getItem("tokenAdmin"));

			$.ajax({

				url:"/ajax/modules.ajax.php",
				method:"POST",
				data:data,
				contentType:false,
				cache:false,
				processData:false,
				success: function(response){
					
					if(response == 200){

						fncSweetAlert("success","El módulo ha sido eliminado con éxito",setTimeout(()=>location.reload(),1250));
					
					}else{

						fncToastr("error", "ERROR: El módulo tiene columnas vinculadas");
					}
				}

			})

		}
	})

})

/*=============================================
Cambio en datos de métricas
=============================================*/

$(document).on("change",".changeMetric",function(){

	var object = `{"type":"${$("#metricType").val()}","table":"${$("#metricTable").val()}", "column":"${$("#metricColumn").val()}","config":"${$("#metricConfig").val()}","icon":"${$("#metricIcon").val()}","color":"${$("#metricColor").val()}"  }`;

	$("#content_module").val(object);	           

})

/*=============================================
Cambio en datos de gráficos
=============================================*/

$(document).on("change",".changeGraphic",function(){

	var object = `{"type":"${$("#graphicType").val()}","table":"${$("#graphicTable").val()}","xAxis":"${$("#graphicX").val()}","yAxis":"${$("#graphicY").val()}","color":"${$("#graphicColor").val()}"}`;

	$("#content_module").val(object);	           

})

/*=============================================
Agregar columnas
=============================================*/

$(document).on("click",".addColumn",function(){

	var display = "d-none";
	var mt = "";

	if($(".listColumns").html() == ""){
		display = "d-block";
		mt = "mt-4";
	}

	var indexRandom = Math.ceil(Math.random() * 10000);

	$(".listColumns").append(`

		<div class="row">

		 	<input type="hidden" name="id_column_${indexRandom}" value="0">

			<div class="col-4 mb-3">

				<label class="${display}">Título</label>
				<input
				type="text"
				class="form-control rounded form-control-sm"
				id="title_column_${indexRandom}"
				name="title_column_${indexRandom}"
				required>

				<div class="valid-feedback">Válido</div>
				<div class="invalid-feedback">Campo Inválido</div>

			</div>


			<div class="col-3 mb-3">

				<label class="${display}">Alias</label>
				<input
				type="text"
				class="form-control rounded form-control-sm"
				id="alias_column_${indexRandom}"
				name="alias_column_${indexRandom}"
				required>

				<div class="valid-feedback">Válido</div>
				<div class="invalid-feedback">Campo Inválido</div>

			</div>

			<div class="col-2 mb-3">

				<label class="${display}">Típo</label>
				
				<select 
				class="form-select form-select-sm rounded" 
				id="type_column_${indexRandom}"
				name="type_column_${indexRandom}"
				required>

					<option value="text">Texto</option>
					<option value="textarea">Área Texto</option>
					<option value="int">Número Entero</option>
					<option value="double">Número Decimal</option>
					<option value="image">Imagen</option>
					<option value="video">Video</option>
					<option value="file">Archivo</option>
					<option value="boolean">Boleano</option>
					<option value="select">Selección</option>
					<option value="array">Arreglo</option>
					<option value="object">Objeto</option>
					<option value="json">JSON</option>
					<option value="date">Fecha</option>
					<option value="time">Hora</option>
					<option value="datetime">Fecha y Hora</option>
					<option value="timestamp">Fecha Automática</option>
					<option value="code">Código</option>
					<option value="link">Enlace</option>
					<option value="color">Color</option>
					<option value="money">Dinero</option>
					<option value="password">Contraseña</option>
					<option value="email">Email</option>
					<option value="relations">Relaciones</option>
					<option value="order">Ordenar</option>
					<option value="chatgpt">ChatGPT</option>

				</select>

				<div class="valid-feedback">Válido</div>
				<div class="invalid-feedback">Campo Inválido</div>

			</div>

			<div class="col-2 mb-3">

				<label class="${display}">Visibilidad</label>

				<select 
				class="form-select form-select-sm rounded" 
				name="visible_column_${indexRandom}" 
				id="visible_column_${indexRandom}" 
				required>
					<option value="1">ON</option>
					<option value="0">OFF</option>							
				</select>
			
				<div class="valid-feedback">Válido</div>
				<div class="invalid-feedback">Campo Inválido</div>

			</div>

			<div class="col-1 mb-3">

				<button type="button" class="btn btn-sm btn-default border rounded ${mt} deleteColumn" index="${indexRandom}" idItem="0">
					<i class="bi bi-trash"></i>
				</button>

			</div>

		</div>	

	 `)

	var indexColumns = JSON.parse($("#indexColumns").val());

	indexColumns.push(indexRandom);

	$("#indexColumns").val(JSON.stringify(indexColumns));

})

/*=============================================
Eliminar columnas
=============================================*/

$(document).on("click",".deleteColumn",function(){

	var elem = $(this);

	fncSweetAlert("confirm","¿Está seguro de borrar esta columna?","").then(resp=>{

		if(resp){

			$(elem).parent().parent().remove();

			/*=============================================
			 ID de columnas a borrar
			=============================================*/
			
			if($(elem).attr("idItem") > 0){

				var deleteColumns = JSON.parse($("#deleteColumns").val());

				deleteColumns.push(Number($(elem).attr("idItem")));

				$("#deleteColumns").val(JSON.stringify(deleteColumns));
			}

			/*=============================================
			Actualizar el Índice de columnas
			=============================================*/

			var indexColumns = JSON.parse($("#indexColumns").val());

			indexColumns = indexColumns.filter(e => e != $(elem).attr("index"));

			$("#indexColumns").val(JSON.stringify(indexColumns));
			
		}

	})

})




