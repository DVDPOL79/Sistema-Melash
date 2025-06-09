<?php if ($module->columns[$i]->type_column == "password"): ?>

 	<input 
	type="password" 
	class="form-control rounded"
	id="<?php echo $module->columns[$i]->title_column ?>"
	name="<?php echo $module->columns[$i]->title_column ?>"
	placeholder="******"
	>
 	
<?php endif ?>
