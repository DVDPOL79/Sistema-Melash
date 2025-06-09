<?php if ($module->columns[$i]->type_column == "array"): ?>

	<input 
	type="text"
	class="form-control rounded tags-input"
	data-role="tagsinput"
	id="<?php echo $module->columns[$i]->title_column ?>"
	name="<?php echo $module->columns[$i]->title_column ?>"
	value="<?php if (!empty($data)): ?><?php echo urldecode($data[$module->columns[$i]->title_column]) ?><?php endif ?>">
	
<?php endif ?>


