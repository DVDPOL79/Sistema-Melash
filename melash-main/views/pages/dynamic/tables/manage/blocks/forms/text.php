<?php if ($module->columns[$i]->type_column == "text" || $module->columns[$i]->type_column == "link" || $module->columns[$i]->type_column == "pos"): ?>

 	<input 
	type="text" 
	class="form-control rounded"
	id="<?php echo $module->columns[$i]->title_column ?>"
	name="<?php echo $module->columns[$i]->title_column ?>"
	value="<?php if (!empty($data) && $data[$module->columns[$i]->title_column] != null): ?><?php echo htmlspecialchars(urldecode($data[$module->columns[$i]->title_column])) ?><?php endif ?>">
 	
<?php endif ?>

