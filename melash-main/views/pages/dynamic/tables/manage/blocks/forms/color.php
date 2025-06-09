<?php if ($module->columns[$i]->type_column == "color"): ?>

	<input 
	type="color" 
	class="form-control form-control-color rounded"
	id="<?php echo $module->columns[$i]->title_column ?>" 
	name="<?php echo $module->columns[$i]->title_column ?>"
	value="<?php if (!empty($data)): ?><?php echo urldecode($data[$module->columns[$i]->title_column]) ?><?php endif ?>">

<?php endif ?>