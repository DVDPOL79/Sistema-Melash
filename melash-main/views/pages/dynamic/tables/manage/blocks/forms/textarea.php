<?php if ($module->columns[$i]->type_column == "textarea"): ?>

 	<textarea 
	class="form-control rounded"
	rows="3"
	id="<?php echo $module->columns[$i]->title_column ?>" 
	name="<?php echo $module->columns[$i]->title_column ?>"><?php if (!empty($data)): ?><?php echo htmlspecialchars(urldecode($data[$module->columns[$i]->title_column])) ?><?php endif ?></textarea>
 	
<?php endif ?>

