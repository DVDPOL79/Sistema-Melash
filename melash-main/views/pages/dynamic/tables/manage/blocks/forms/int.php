<?php if ($module->columns[$i]->type_column == "int" || $module->columns[$i]->type_column == "order"  || $module->columns[$i]->type_column == "stock"): ?>

 	<input 
	type="number" 
	class="form-control rounded"
	id="<?php echo $module->columns[$i]->title_column ?>"
	name="<?php echo $module->columns[$i]->title_column ?>"
	value="<?php if (!empty($data)): ?><?php echo urldecode($data[$module->columns[$i]->title_column]) ?><?php endif ?>">
 	
<?php endif ?>

