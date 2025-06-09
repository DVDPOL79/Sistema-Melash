<?php if ($module->columns[$i]->type_column == "file" || 
$module->columns[$i]->type_column == "image" || 
$module->columns[$i]->type_column == "video"): ?>
<div class="input-group">

 	<input 
	type="text" 
	class="form-control rounded-start"
	id="<?php echo $module->columns[$i]->title_column ?>"
	name="<?php echo $module->columns[$i]->title_column ?>"
	value="<?php if (!empty($data)): ?><?php echo urldecode($data[$module->columns[$i]->title_column]) ?><?php endif ?>">

	<span class="input-group-text rounded-end myFiles" style="cursor:pointer"><i class="bi bi-cloud-arrow-up-fill"></i></span>

</div>
 	
<?php endif ?>
