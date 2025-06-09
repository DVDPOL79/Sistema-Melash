<?php if ($module->columns[$i]->type_column == "email"): ?>

 	<input 
	type="email" 
	class="form-control rounded"
	onchange="validateJS(event, 'email')"
	id="<?php echo $module->columns[$i]->title_column ?>"
	name="<?php echo $module->columns[$i]->title_column ?>"
	value="<?php if (!empty($data)): ?><?php echo htmlspecialchars(urldecode($data[$module->columns[$i]->title_column])) ?><?php endif ?>">
 	
<?php endif ?>

