<div class="card rounded border-0 shadow mb-3 pb-3">
	
	<div class="card-body">

		<label for="<?php echo $module->columns[$i]->title_column ?>" class="form-label float-start text-capitalize">
			<?php echo $module->columns[$i]->alias_column ?>:
		</label>
		<span class="float-end badge badge-default border small rounded text-muted">
			<?php echo $module->columns[$i]->type_column ?>
		</span>
		<div class="clearfix"></div>

		<?php 
		
		/*=============================================
		Formulario de tipo Texto		
		=============================================*/
		
		include "forms/text.php"; 

		/*=============================================
		Formulario de tipo TextoArea			
		=============================================*/
		
		include "forms/textarea.php"; 

		/*=============================================
		Formulario de tipo Número Entero		
		=============================================*/
		
		include "forms/int.php"; 

		/*=============================================
		Formulario de tipo Número con decimal			
		=============================================*/
		
		include "forms/double.php"; 

		/*=============================================
		Formulario de tipo Selección	
		=============================================*/
		
		include "forms/select.php"; 

		/*=============================================
		Formulario de tipo Boleano		
		=============================================*/
		
		include "forms/boolean.php"; 

		/*=============================================
		Formulario de tipo Arreglo	
		=============================================*/
		
		include "forms/array.php"; 

		/*=============================================
		Formulario de tipo Objeto		
		=============================================*/
		
		include "forms/object.php"; 

		/*=============================================
		Formulario de tipo JSON		
		=============================================*/
		
		include "forms/_json.php"; 

		/*=============================================
		Formulario de tipo Archivo, Imagen, Video
		=============================================*/
		
		include "forms/file.php"; 

		/*=============================================
		Formulario de tipo Fecha	
		=============================================*/
		
		include "forms/date.php"; 

		/*=============================================
		Formulario de tipo tiempo	
		=============================================*/
		
		include "forms/time.php"; 

		/*=============================================
		Formulario de tipo Fecha y Tiempo
		=============================================*/
		
		include "forms/datetime.php"; 

		/*=============================================
		Formulario de tipo Fecha y Tiempo Automático
		=============================================*/

		include "forms/timestamp.php"; 

		/*=============================================
		Formulario de tipo Código
		=============================================*/

		include "forms/code.php"; 

		/*=============================================
		Formulario de tipo Color
		=============================================*/

		include "forms/color.php"; 

		/*=============================================
		Formulario de tipo Contraseña
		=============================================*/

		include "forms/password.php"; 

		/*=============================================
		Formulario de tipo Email
		=============================================*/

		include "forms/email.php"; 

		/*=============================================
		Formulario de tipo Relaciones
		=============================================*/

		include "forms/relations.php";

		/*=============================================
		Formulario de tipo Relaciones
		=============================================*/

		include "forms/chatgpt.php";


		?>

		<div class="valid-feedback">Válido.</div>
		<div class="invalid-feedback">Campo inválido.</div>
	
	</div>

</div>