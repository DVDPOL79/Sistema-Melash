/*=============================================
Cambiar de Listado a Cuadrícula
=============================================*/

$(document).on("click",".changeView",function(){

	var modules = $(".modules");

	modules.each((i)=>{

		$(modules[i]).hide();

	})

	$("#"+$(this).attr("module")).show();

	var changeView = $(".changeView");

	changeView.each((i)=>{

		$(changeView[i]).removeClass("text-white")
		$(changeView[i]).addClass("text-dark")

		$(changeView[i]).removeClass("bg-dark")
		$(changeView[i]).addClass("bg-white")

	})

	$(this).addClass("text-white")
	$(this).removeClass("text-dark")

	$(this).addClass("bg-dark")
	$(this).removeClass("bg-white")

	/*=============================================
	Ajustar imágenes cuando activamos el grid
	=============================================*/

	if($(this).attr("module") == "grid"){

		if($("#grid .col").length > 1 && $("#grid .col:first-child").html() == ""){

			$("#grid .col:first-child").remove();
		}

		imgAdjustGrid();
	}
})

/*=============================================
Zona Drag & Drop
=============================================*/

$("#dragFiles").on(
	'dragover',
	function(e) {

		e.preventDefault();
		e.stopPropagation();

		$(this).addClass("bg-light");
	}
)

$("#dragFiles").on(
	'dragenter',
	function(e) {

		e.preventDefault();
		e.stopPropagation();
	
	}
)

$("#dragFiles").on(
	'mouseleave',
	function(e) {

		e.preventDefault();
		e.stopPropagation();

		$(this).removeClass("bg-light");
	
	}
)

$("#dragFiles").on(
	'drop',
	function(e) {
		
		e.preventDefault();
		e.stopPropagation();

		if(e.originalEvent.dataTransfer){

			if(e.originalEvent.dataTransfer.files.length){

				$(this).removeClass("bg-light");

				var t = new Date();
				var time = t.getFullYear()+"-"+("0"+(t.getMonth()+1)).slice(-2)+"-"+("0"+t.getDate()).slice(-2)+", "+t.toLocaleTimeString();

				uploadFiles(e.originalEvent.dataTransfer.files,'drag',time);
			}
		}
	}
)

/*=============================================
Subir Archivos
=============================================*/
var files = new DataTransfer();

function uploadFiles(event, type, time){

	fncMatPreloader("on");
	fncSweetAlert("loading", "Loading...", "");

	/*=============================================
	Guardar en el LocalStorage estado inicial del checkbox
	=============================================*/

	localStorage.setItem("listFolders", $(".listFolders").html());

	/*=============================================
	Convertir los checkbox a radio
	=============================================*/

	var checkFMS = $(".check-fms");

	checkFMS.each((i)=>{

		$(checkFMS[i]).attr("type","radio");
		$(checkFMS[i]).attr("checked",false);

	})

	$(checkFMS[0]).attr("checked",true);

	/*=============================================
	Captura de Archivos
	=============================================*/
	
	if(type == "btn"){

		for (var i = 0; i < event.target.files.length; i++) {

			files.items.add(event.target.files[i]);
		}

	}else{

		for (var i = 0; i < event.length; i++) {

			files.items.add(event[i]);
		}
		
	
	}

	/*=============================================
	Limpiando las vistas de lista y cuadrícula
	=============================================*/

	var itemsUp = $(".itemsUp");

	itemsUp.each((i)=>{

		$(itemsUp[i]).remove();
	})

	/*=============================================
	Recorriendo los archivos
	=============================================*/

	Array.from(files.files).forEach((file,i)=>{

		if(file.type.split("/")[0] == "image" || 
		   file.type.split("/")[0] == "video" ||
		   file.type.split("/")[0] == "audio" ||
		   file.type.split("/")[1] == "pdf" ||
		   file.type.split("/")[1] == "zip"
		){
		
			/*=============================================
			Capturar el nombre
			=============================================*/

			var name = file.name.split(".");
			name.pop();
			name = name.toString().replace(/,/g,"_");

			/*=============================================
			Capturar la extensión
			=============================================*/

			var extension = file.name.split(".").pop();

			/*=============================================
			Capturar el tamaño
			=============================================*/

			var size = (Number(file.size)/1000000).toFixed(2);
			

			/*=============================================
			Capturar la miniatura en imágenes
			=============================================*/

			var path;

			if(file.type.split("/")[0] == "image"){

				var data  = new FileReader();
				data.readAsDataURL(file);

				$(data).on("load",function(event){
					
					path = event.target.result; 

					paintFiles(path,name,extension,size,time);

				})

			}

			/*=============================================
			Capturar la miniatura de videos
			=============================================*/

			if(file.type.split("/")[0] == "video"){

				/*=============================================
				Capturar la miniatura de videos MP4
				=============================================*/

				if(file.type.split("/")[1] == "mp4"){
					
					var canvas = document.createElement("canvas");
					var video = document.createElement("video");

					video.autoplay = true;
					video.muted = true;
					video.src = URL.createObjectURL(file);

					video.onloadeddata = () => {

						var ctx = canvas.getContext("2d");

						canvas.width = video.videoWidth;
						canvas.height = video.videoHeight;

						ctx.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
						video.pause();

						path = canvas.toDataURL("image/png");

						paintFiles(path,name,extension,size,time);

					}

				}else{

					path = "/views/assets/img/multimedia.png";
					paintFiles(path,name,extension,size,time);

				}

			}

			/*=============================================
			Capturar la miniatura de audios
			=============================================*/

			if(file.type.split("/")[0] == "audio"){

				path = "/views/assets/img/multimedia.png";
				paintFiles(path,name,extension,size,time);

			}

			/*=============================================
			Capturar la miniatura de PDF
			=============================================*/

			if(file.type.split("/")[1] == "pdf"){
				

				path = "/views/assets/img/pdf.jpeg";
				paintFiles(path,name,extension,size,time);

			}

			/*=============================================
			Capturar la miniatura de ZIP
			=============================================*/

			if(file.type.split("/")[1] == "zip"){	

				path = "/views/assets/img/zip.jpg";
				paintFiles(path,name,extension,size,time);

			}

			/*=============================================
			Función para pintar los archivos en la lista o cuadrícula
			=============================================*/

			function paintFiles(path,name,extension,size,time){

				/*=============================================
				Visualizando archivos a subir en la lista
				=============================================*/
			
				$("#list table tbody tr:first-child").before(`

					<tr style="height:100px" class="itemsUp">

						<td>
							<img src="${path}" class="rounded" style="width:100px; height:100px; object-fit: cover; object-position: center;">
						</td>

						<td class="align-middle columnName${i}">
							<div class="input-group">
								<input type="text" class="form-control" value="${name}" readonly>
								<span class="input-group-text">.${extension}</span>
							</div>
						</td>

						<td class="align-middle">${size} MB</td>

						<td class="align-middle">
							<span class="badge bg-dark rounded px-3 py-2 text-white typeFolder">Server</span>
						</td>

						<td class="align-middle progressList${i}" style="width:350px">
							<div class="progress-spinner"></div>
							<div class="progress mt-1" style="height:10px">
								<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width:0%">0%</div>
							</div>
						</td>

						<td class="align-middle">${time}</td>

						<td class="align-middle columnAction${i}">
							<button type="button" class="btn btn-sm py-2 px-3 bg-default border font-weight-bold rounded clearFile" mode="list" index="${i}" name="${file.name}">
								<i class="bi bi-x-circle"></i> Clear
							</button>
						</td>

					</tr>

				`)

				/*=============================================
				Visualizando archivos a subir en la cuadrícula
				=============================================*/

				$("#grid .col:first-child").before(`

					<div class="col itemsUp">
			 			
			 			<div class="card rounded p-3 border-0 shadow my-3">
			 				
			 				<div class="card-header bg-white border-0 p-0">
			 					
			 					<div class="d-flex justify-content-between mb-2">
			 						
			 						<div class="bg-white w-50 progressGrid${i}">
										<div class="progress-spinner"></div>
										<div class="progress mt-1" style="height:10px">
											<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width:0%">0%</div>
										</div>
									</div>

									<div class="bg-white m-0 gridAction${i}">
										<button type="button" class="btn btn-sm py-2 px-3 bg-default border font-weight-bold rounded clearFile" mode="grid" index="${i}" name="${file.name}">
											<i class="bi bi-x-circle"></i> Clear
										</button>
									</div>

			 					</div>
			 				</div>

			 				<img src="${path}" class="card-img-top rounded w-100">

			 				<div class="card-body p-1">
			 					
			 					<p class="card-text">
			 						
			 						<div class="input-group gridName${i}">
										<input type="text" class="form-control" value="${name}" readonly>
										<span class="input-group-text">.${extension}</span>
									</div>

									<div class="d-flex justify-content-between mt-3">

										<div class="bg-white">
											<p class="small mt-1">${size} MB</p>
										</div>

										<div class="bg-white m-0">
											<span class="badge bg-dark border rounded px-3 py-2 text-white typeFolder">Server</span>
										</div>
									</div>

									<h6 class="float-end my-0 py-0">
										<small>${time}</small>
									</h6>

			 					</p>

			 				</div>

			 			</div>

			 		</div>

			 	`);

			 	console.log("cerrar")


				fncMatPreloader("off");
				fncSweetAlert("close", "", "");

				/*=============================================
				Ejecutar función ajuste de imagen
				=============================================*/

				imgAdjustGrid();

			}

		}else{

			fncToastr("error", "El formato de archivo que intenta subir no es permitido");
			return;
		}
		

	})

}

/*=============================================
Ajuste de imagen para el grid
=============================================*/

function imgAdjustGrid(){

	if($(".card-img-top").length > 0){

		var cardImgTop = $(".card-img-top");

		cardImgTop.each((i)=>{

			$(cardImgTop[i]).attr("style", "height:"+$(cardImgTop[i]).width()+"px;  object-fit: cover; object-position: center;");		
			
		})
	}

}

/*=============================================
Cambio al seleccionar servidor
=============================================*/

$(document).on("change",".check-fms",function(){

	/*=============================================
	Seleccionar servidor
	=============================================*/

	if($(this).attr("type") == "radio"){

		var folder = $(this).val().split("_")[1];
		
		if($(".typeFolder").length > 0){

			var typeFolder = $(".typeFolder");

			typeFolder.each((i)=>{

				$(typeFolder[i]).html(folder);
			})

		}
	}

})

/*=============================================
Iniciar subida de archivos
=============================================*/

$(document).on("click","#startAll",function(){

	/*=============================================
	Validar si lo está haciendo un admin
	=============================================*/

	if(localStorage.getItem("tokenAdmin") == null){

		fncToastr("error", "Debe iniciar sesión para realizar esta acción");
		return;
	}

	/*=============================================
	Validar que si hayan archivos para subir
	=============================================*/
	
	if($(".itemsUp").length == 0){

		fncToastr("error", "Debe arrastrar mínimo un archivo para realizar esta acción");
		return;

	}
	
	/*=============================================
	Validar el folder donde se subiran los archivos
	=============================================*/

	var checkFMS = $(".check-fms");

	checkFMS.each((i)=>{

		if($(checkFMS[i]).attr("type") == "radio" && $(checkFMS[i]).prop("checked")){
			
			uploadFilesAjax($(checkFMS[i]).val());

		}

	})

})

/*=============================================
Función de carga
=============================================*/

function uploadFilesAjax(folder){
	
	fncMatPreloader("on");

	var countFiles = 0;

	/*=============================================
	Recorriendo los archivos
	=============================================*/

	Array.from(files.files).forEach((file,i)=>{
	
		var data = new FormData();
		data.append("file", file);
		data.append("folder", folder.split("_")[0]);
		data.append("token", localStorage.getItem("tokenAdmin"));

		$.ajax({

			xhr:function(){

				xhr = $.ajaxSettings.xhr();

				xhr.upload.onprogress = function(e){
					
					if(e.lengthComputable){

						var completePercent = (e.loaded / e.total) * 100;

						/*=============================================
						Precarga individual en la lista
						=============================================*/			

						$(".progressList"+i).find(".progress-spinner").html(`<div class="spinner-border spinner-border-sm me-1"></div><small>Uploading file to server...</small>`)

						$(".progressList"+i).find(".progress-bar").attr("style","width:"+completePercent.toFixed(2)+"%");

						$(".progressList"+i).find(".progress-bar").html(completePercent.toFixed(2)+"%");

						/*=============================================
						Precarga individual en la cuadrícula
						=============================================*/			

						$(".progressGrid"+i).find(".progress-spinner").html(`<div class="spinner-border spinner-border-sm"></div>`)

						$(".progressGrid"+i).find(".progress-bar").attr("style","width:"+completePercent.toFixed(2)+"%");

						$(".progressGrid"+i).find(".progress-bar").html(completePercent.toFixed(2)+"%");
					}

				}

				return xhr;

			},
			url:"/ajax/files.ajax.php",
			method:"POST",
			data:data,
			contentType: false,
			cache: false,
			processData: false,
			success: function(response){

				if(JSON.parse(response).status == 200){

					countFiles++;

					/*=============================================
					Modifica la vista de la lista
					=============================================*/
					$(".columnName"+i).parent().removeClass("itemsUp");
					$(".columnName"+i).find("input").attr("readonly", false);
					$(".columnName"+i).find("input").addClass("changeName");
					$(".columnName"+i).find("input").attr("idFile",JSON.parse(response).id_file);
					$(".columnName"+i).removeClass("columnName"+i);

					$(".progressList"+i).html(`<a href="${JSON.parse(response).link}" target="_blank">

						${JSON.parse(response).reduce_link}
						<i class="bi bi-box-arrow-up-right ps-2 btn"></i>

					</a>`);

					$(".progressList"+i).removeClass("progressList"+i);

					$(".columnAction"+i).html(`<svg class="bi bi-copy copyLink" copy="${JSON.parse(response).link}" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="cursor:pointer">
						  <path fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z"/>
						</svg>
					  <i class="bi bi-trash ps-2 btn deleteFile" idFile="${JSON.parse(response).id_file}" idFolder="${folder.split("_")[0]}" mode="list"></i>`);

					$(".columnAction"+i).removeClass("columnAction"+i);

					/*=============================================
					Modifica la vista de la cuadrícula
					=============================================*/
					$(".gridName"+i).parent().parent().parent().parent().removeClass("itemsUp");
					$(".gridName"+i).find("input").attr("readonly", false);
					$(".gridName"+i).find("input").addClass("changeName");
					$(".gridName"+i).find("input").attr("idFile",JSON.parse(response).id_file);
					$(".gridName"+i).removeClass("gridName"+i);

					$(".progressGrid"+i).html(`<a href="${JSON.parse(response).link}" target="_blank">

						<i class="bi bi-box-arrow-up-right ps-2 btn"></i>

					</a>`);

					$(".progressGrid"+i).removeClass("progressGrid"+i);

					$(".gridAction"+i).html(`<svg class="bi bi-copy copyLink" copy="${JSON.parse(response).link}" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="cursor:pointer">
						  <path fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z"/>
						</svg>
					  <i class="bi bi-trash ps-2 btn deleteFile" idFile="${JSON.parse(response).id_file}" idFolder="${folder.split("_")[0]}" mode="grid"></i>`);
					$(".gridAction"+i).removeClass("gridAction"+i);

					/*=============================================
					Finaliza la carga de todos los archivos
					=============================================*/

					if(countFiles == files.files.length){

						/*=============================================
						sumar el peso de todos los archivos que pertenecen al "folder"
						=============================================*/

						var data = new FormData();
						data.append("idFolder", folder.split("_")[0]);
						data.append("token", localStorage.getItem("tokenAdmin"));

						$.ajax({

							url:"/ajax/files.ajax.php",
							method:"POST",
							data:data,
							contentType: false,
							cache: false,
							processData: false,
							success: function(response){

								if(response == 200){

									/*=============================================
									Regresar al estado inicial los checkbox de los folders
									=============================================*/
	
									$(".listFolders").html(localStorage.getItem("listFolders"));

									fncMatPreloader("off");
									fncToastr("success", "Todos los archivos han subido exitosamente");

									files = new DataTransfer();

								}

							}

						})

					}

				}else{

					fncMatPreloader("off");
					fncToastr("error", JSON.parse(response).error);

					/*=============================================
					Precarga individual en la lista
					=============================================*/			

					$(".progressList"+i).find(".progress-spinner").html('')

					$(".progressList"+i).find(".progress-bar").attr("style","width:0%");

					$(".progressList"+i).find(".progress-bar").html("0%");

					/*=============================================
					Precarga individual en la cuadrícula
					=============================================*/			

					$(".progressGrid"+i).find(".progress-spinner").html('')

					$(".progressGrid"+i).find(".progress-bar").attr("style","width:0%");

					$(".progressGrid"+i).find(".progress-bar").html("0%");

					files = new DataTransfer();
				}
			
			}

		})

	})

}

/*=============================================
Eliminar Archivo
=============================================*/ 

$(document).on("click",".deleteFile",function(){

	/*=============================================
	Confirmar si esta como administrador
	=============================================*/

	if(localStorage.getItem("tokenAdmin") == null){

		fncToastr("error", "Debe iniciar sesión para realizar esta acción");
		return;
	}

	/*=============================================
	Confirmar si deseo eliminar el archivo
	=============================================*/

	fncSweetAlert("confirm", "¿Está seguro de eliminar este archivo?", "").then(resp=>{

		if(resp){

			fncMatPreloader("on");
			fncSweetAlert("loading","Loading...","");

			var idFile = $(this).attr("idFile");
			var idFolder = $(this).attr("idFolder");
			var mode = $(this).attr("mode");

			/*=============================================
			Quitar archivo de la vista
			=============================================*/

			if(mode == "list"){

				$(this).parent().parent().remove();
				$(".deleteFile[idFile='"+idFile+"']").parent().parent().parent().parent().parent().remove();

			}

			if(mode == "grid"){

				$(this).parent().parent().parent().parent().parent().remove();
				$(".deleteFile[idFile='"+idFile+"']").parent().parent().remove();
				

			}

			/*=============================================
			Eliminar archivo del servidor y la base de datos
			=============================================*/

			var data = new FormData();
			data.append("idFileDelete", idFile);
			data.append("idFolderDelete", idFolder);
			data.append("token", localStorage.getItem("tokenAdmin"));

			$.ajax({

				url:"/ajax/files.ajax.php",
				method:"POST",
				data:data,
				contentType: false,
				cache: false,
				processData: false,
				success: function(response){
					
					if(response == 200){

						fncMatPreloader("off");
						fncToastr("success", "El archivo se ha eliminado exitosamente");
					}

				}

			})

		}

	})

})

/*=============================================
Quitar archivos antes subir al servidor
=============================================*/ 

$(document).on("click",".clearFile",function(){

	var mode = $(this).attr("mode");
	var index = $(this).attr("index");
	var name = $(this).attr("name");

	/*=============================================
	Quitar archivo de la vista
	=============================================*/

	if(mode == "list"){

		$(this).parent().parent().remove();
		$(".clearFile[index='"+index+"'][name='"+name+"']").parent().parent().parent().parent().parent().remove();

	}

	if(mode == "grid"){

		$(this).parent().parent().parent().parent().parent().remove();
		$(".clearFile[index='"+index+"'][name='"+name+"']").parent().parent().remove();
		
	}	

	/*=============================================
	Recorriendo los archivos
	=============================================*/

	Array.from(files.files).forEach((file,i)=>{

		if(i == index && file.name == name){
			
			files = removeFileFromList(files.files, i);
			// console.log("files", files);

		}

	})

})

/*=============================================
Remover índice de un array de Archivos (FileList)
=============================================*/

function removeFileFromList(fileList, indexToRemove) {
   
    const dt = new DataTransfer(); // Crea un nuevo objeto DataTransfer

    // Agrega todos los archivos excepto el que quieres eliminar
    
    for (let i = 0; i < fileList.length; i++) {

        if (i !== indexToRemove) {
            dt.items.add(fileList[i]); // Añade el archivo al nuevo FileList
        }
    
    }

    // Devuelve el nuevo FileList
    return dt;
}

/*=============================================
Copiar link en el portapapeles
=============================================*/ 

$(document).on("click",".copyLink",function(){

	var link = $(this).attr("copy");
	// console.log("link", link);
	
	var textArea = document.createElement("textarea");
	textArea.value = link;

	$(this).after(textArea);

	textArea.focus();

	textArea.select();

	try{

		document.execCommand("copy");
		fncToastr("success", "Link copiado en el portapapeles");
	
	}catch(err){

		fncToastr("error", "El link no se pudo copiar en el portapapeles");
	}

	$(this).parent().find(textArea).remove();

})


/*=============================================
Cambiar el nombre del archivo
=============================================*/ 

$(document).on("change",".changeName", function(){

	/*=============================================
	Confirmar si esta como administrador
	=============================================*/

	if(localStorage.getItem("tokenAdmin") == null){

		fncToastr("error", "Debe iniciar sesión para realizar esta acción");
		return;
	}

	var name = $(this).val();
	var idFile = $(this).attr("idFile");

	/*=============================================
	Cambiar el nombre en base de datos
	=============================================*/

	var data = new FormData();
	data.append("name", name);
	data.append("idFile", idFile);
	data.append("token", localStorage.getItem("tokenAdmin"));

	$.ajax({

		url:"/ajax/files.ajax.php",
		method:"POST",
		data:data,
		contentType: false,
		cache: false,
		processData: false,
		success: function(response){
			
			if(response == 200){

				fncToastr("success", "El archivo ha cambiado de nombre exitosamente");
			}

		}

	})

})

/*=============================================
Buscador de archivos
=============================================*/ 

$("#searchFiles").keyup(function(event){

	event.preventDefault();

	var search = fncSearch($("#searchFiles").val().toLowerCase());
	var sortBy = $("#sortBy").val();
	var filterBy = $("#filterBy").val();
	var folders = $("input.check-fms[type='checkbox']");
	
	loadFiles(search,sortBy,filterBy,folders,0,15);
	
})

/*=============================================
función de búsqueda
=============================================*/

function fncSearch(search){

	search = search.replace(/[#\\;\\$\\&\\%\\=\\(\\)\\:\\,\\'\\"\\.\\¿\\¡\\!\\?\\]/g, "");
	
	search = search.replace(/[á]/g, "a");
	search = search.replace(/[é]/g, "e");
	search = search.replace(/[í]/g, "i");
	search = search.replace(/[ó]/g, "o");
	search = search.replace(/[ú]/g, "u");
	search = search.replace(/[ñ]/g, "n");

	search = search.replace(/[ ]/g, "_");

	return search;
	
}

/*=============================================
Cambio de órden, filtrar formato o filtrar servidor
=============================================*/

$(document).on("change",".changeFilters",function(){

	var search = fncSearch($("#searchFiles").val().toLowerCase());
	var sortBy = $("#sortBy").val();
	var filterBy = $("#filterBy").val();
	var folders = $("input.check-fms[type='checkbox']");
	
	loadFiles(search,sortBy,filterBy,folders,0,15);
	
})

/*=============================================
Cambio de órden, filtrar formato o filtrar servidor
=============================================*/

$(document).on("change",".changeFolders",function(){

	if($(this).attr("type") == "checkbox"){
	
		var search = fncSearch($("#searchFiles").val().toLowerCase());
		var sortBy = $("#sortBy").val();
		var filterBy = $("#filterBy").val();
		var folders = $("input.check-fms[type='checkbox']");
		
		loadFiles(search,sortBy,filterBy,folders,0,15);

	}
})


/*=============================================
Llevar el Scroll al final de la página
=============================================*/

$(window).on("scroll",function(){

	var scrollHeight = $(document).height();	
	var scrollPosition = $(window).height() + $(window).scrollTop();
	
	if((scrollHeight - scrollPosition) / scrollHeight === 0) {

		if(Number($("#currentPage").val()) < Number($("#totalPages").val())){

		 	$("#scrollControl").html(`
		 		<div class="text-center">
					<div class="spinner-border mb-4"></div>
				</div>
		 	`)

		 	var nextPage = Number($("#currentPage").val())+1;

		 	if(Number($("#totalPages").val()) == nextPage){
				$("#btnControl").html('');
				$("#scrollControl").html('');
			}
	
		 	$("#currentPage").val(nextPage);

		 	var search = fncSearch($("#searchFiles").val().toLowerCase());
			var sortBy = $("#sortBy").val();
			var filterBy = $("#filterBy").val();
			var folders = $("input.check-fms[type='checkbox']");
			var startAt = (nextPage*15)-15;

		 	loadFiles(search,sortBy,filterBy,folders,startAt,15);

		}else{

			$("#btnControl").html('');
			$("#scrollControl").html('');

		}	 

	}

})

/*=============================================
Cargar más archivos con botón
=============================================*/

$(document).on("click","#btnControl",function(){

	if(Number($("#currentPage").val()) < Number($("#totalPages").val())){

		var nextPage = Number($("#currentPage").val())+1;

		if(Number($("#totalPages").val()) == nextPage){
			$("#btnControl").html('');
			$("#scrollControl").html('');
		}
		
	 	$("#currentPage").val(nextPage);

	 	var search = fncSearch($("#searchFiles").val().toLowerCase());
		var sortBy = $("#sortBy").val();
		var filterBy = $("#filterBy").val();
		var folders = $("input.check-fms[type='checkbox']");
		var startAt = (nextPage*15)-15;

	 	loadFiles(search,sortBy,filterBy,folders,startAt,15);

	}else{

		$("#btnControl").html('');
		$("#scrollControl").html('');

	}
})



/*=============================================
funcion para cambiar la vista del DOM
=============================================*/

function loadFiles(search,sortBy,filterBy,folders,startAt,endAt){

	var arrayFolders = [];
	var countArrayFolder = 0;

	if(folders.length == 0){

		folders = $("input.check-fms[type='radio']");
		
	}

	// console.log("folders", folders.length);

	folders.each((i)=>{

		countArrayFolder++;

		/*=============================================
		Agregamos los folders seleccionados
		=============================================*/ 

		if($(folders[i]).prop("checked")){
			
			arrayFolders.push($(folders[i]).val().split("_")[0]);

		}

		/*=============================================
		Llevar información a AJAX
		=============================================*/
			
		if(countArrayFolder == folders.length){

			var data = new FormData();
			data.append("search", search);
			data.append("sortBy", sortBy);
			data.append("filterBy", filterBy);
			data.append("arrayFolders", JSON.stringify(arrayFolders));
			data.append("startAt", startAt);
			data.append("endAt", endAt);

			$.ajax({

				url:"/ajax/files.ajax.php",
				method:"POST",
				data:data,
				contentType: false,
				cache: false,
				processData: false,
				success: function(response){

					if(startAt == 0){
					
						/*=============================================
						Limpiar la lista y la cuadrícula
						=============================================*/

						$("#list table tbody").html('<tr></tr>');
						$("#grid").html('<div class="col col-12"></div>');

					}

					/*=============================================
					Pintar la lista y la cuadrícula con lo que viene de AJAX
					=============================================*/

					$("#list table tbody").append(JSON.parse(response).htmlList);
					$("#grid").append(JSON.parse(response).htmlGrid);

					imgAdjustGrid();

				}

			})

		}

	})

}
