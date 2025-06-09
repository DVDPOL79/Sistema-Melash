<?php if ($module->columns[$i]->type_column == "relations"): ?>

	<?php 

	/*=============================================
	Traemos todas las tablas
	=============================================*/

	require_once "controllers/install.controller.php";
	$tables = InstallController::getTables();

	?>

	<select 
	class="form-select rounded mb-3 select2 changeRelations"
	idColumn="<?php echo $module->columns[$i]->id_column ?>">

		<?php if ($module->columns[$i]->matrix_column != null): ?>

			<option value="<?php echo $module->columns[$i]->matrix_column ?>"><?php echo $module->columns[$i]->matrix_column ?></option>

		<?php else: ?>

			<option value="">Seleccione Tabla</option>


		<?php endif	?>

			<?php foreach ($tables as $index => $item): ?>

				<option value="<?php echo $item ?>" <?php if (!empty($data) && $module->columns[$i]->matrix_column == $item): ?> selected <?php endif ?> ><?php echo $item ?></option>
				
			<?php endforeach ?>


	</select>

	<div class="mb-3"></div>

	<select 
	class="form-select rounded select2 selectRelations"
	name="<?php echo $module->columns[$i]->title_column ?>" 
	id="<?php echo $module->columns[$i]->title_column ?>">

	<?php if ($module->columns[$i]->matrix_column != null): ?>

		<?php 

			$url = $module->columns[$i]->matrix_column;
			$method = "GET";
			$fields = array();

			$columnsTable = CurlController::request($url,$method,$fields);

			if($columnsTable->status == 200){

				$columnsTable = $columnsTable->results;

			}else{

				$columnsTable = array();
			}

		?>

		<?php if (!empty($columnsTable)): ?>

			<?php foreach ($columnsTable as $index => $item): ?>

				<option value="<?php echo json_decode(json_encode($item),true)[array_keys((array)$item)[0]] ?>" <?php if (!empty($data) && json_decode(json_encode($item),true)[array_keys((array)$item)[0]] == $data[$module->columns[$i]->title_column]): ?> selected <?php endif ?>><?php echo json_decode(json_encode($item),true)[array_keys((array)$item)[0]] ?> - <?php echo urldecode(json_decode(json_encode($item),true)[array_keys((array)$item)[1]]) ?></option>

			<?php endforeach ?>

		<?php endif ?>

	<?php endif ?>
		

	</select>

<?php endif ?>