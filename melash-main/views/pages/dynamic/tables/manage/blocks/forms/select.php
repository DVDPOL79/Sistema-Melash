<?php if ($module->columns[$i]->type_column == "select"): ?>

	<div class="input-group mb-3">
		
		<input 
		type="text"
		class="form-control rounded changeSelectType tags-input"
		idColumn="<?php echo $module->columns[$i]->id_column ?>"
		titleColumn="<?php echo $module->columns[$i]->title_column ?>"
		value="<?php echo $module->columns[$i]->matrix_column ?>"
		preValue="<?php if (!empty($data)): ?><?php echo urldecode($data[$module->columns[$i]->title_column])?><?php endif ?>"
		>
	</div>

	<select 
	class="form-select rounded select2"
	name="<?php echo $module->columns[$i]->title_column ?>" 
	id="<?php echo $module->columns[$i]->title_column ?>">

	<?php if ($module->columns[$i]->matrix_column != null): ?>

		<?php foreach (explode(",",urldecode($module->columns[$i]->matrix_column)) as $index => $item):?>

			<option value="<?php echo $item ?>" <?php if (!empty($data) && urldecode($data[$module->columns[$i]->title_column]) == $item): ?> selected <?php endif ?>><?php echo $item ?></option>
			
		<?php endforeach ?>
		
	<?php endif ?>

	</select>

<?php endif ?>