<?php if ($module->columns[$i]->type_column == "boolean"): ?>

<select 
class="form-select rounded"
name="<?php echo $module->columns[$i]->title_column ?>" 
id="<?php echo $module->columns[$i]->title_column ?>">

	<option value="1" 
	<?php if (!empty($data) && $data[$module->columns[$i]->title_column] == 1 ): ?>
	selected	
	<?php endif ?>>True</option>
	<option value="0"
	<?php if (!empty($data) && $data[$module->columns[$i]->title_column] == 0 ): ?>
	selected	
	<?php endif ?>>False</option>

</select>


<?php endif ?>