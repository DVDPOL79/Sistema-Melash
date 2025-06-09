<?php if ($module->columns[$i]->type_column == "timestamp"): ?>

	<?php 

	if($module->columns[$i]->type_column == "timestamp" && empty($data)){

		$timestamp = date("Y-m-d H:i:s");
	
	}else{

		$timestamp = $data[$module->columns[$i]->title_column];
	}
		
	?>

	<div class="input-group">
		
		<input 
		type="text" 
		class="form-control rounded-start" 
		id="<?php echo $module->columns[$i]->title_column ?>"  
		name="<?php echo $module->columns[$i]->title_column ?>"		
		readonly	
		value="<?php echo urldecode($timestamp) ?>"
		>

		<div class="input-group-text rounded-end">
			<i class="bi bi-calendar-week"></i>
		</div>

	</div>

<?php endif ?>