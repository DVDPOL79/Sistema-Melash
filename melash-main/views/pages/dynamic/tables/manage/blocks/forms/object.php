<?php if ($module->columns[$i]->type_column == "object"): ?>


	<div class="itemsObject">

		<?php if (!empty($data) && $data[$module->columns[$i]->title_column] != null): $arrayObj =  new ArrayObject(json_decode(urldecode($data[$module->columns[$i]->title_column])));?>

			<?php if (!empty($arrayObj) && $arrayObj->count() > 0): ?>

				<?php foreach ($arrayObj as $key => $value): ?>

					<div class="row row-cols-1 row-cols-sm-2 itemObject">
						
						<div class="col">
							
							<div class="form-floating mb-3">
								<input 
								type="text"
								class="form-control rounded propertyObject <?php echo $module->columns[$i]->title_column ?>"
								onchange="changeItemObject('<?php echo $module->columns[$i]->title_column ?>')"
								value="<?php echo $key ?>"
								>

								<label>Propiedad</label>

							</div>

						</div>

						<div class="col">
							
							<div class="form-floating mb-3">
								
								<input 
								type="text"
								class="form-control rounded position-relative valueObject <?php echo $module->columns[$i]->title_column ?>"
								onchange="changeItemObject('<?php echo $module->columns[$i]->title_column ?>')"
								value="<?php echo htmlspecialchars($value) ?>"
								>

								<label>Valor</label>

								<button type="button" class="btn btn-sm position-absolute" style="top:0; right:0;" onclick="removeObject('<?php echo $module->columns[$i]->title_column ?>','_<?php echo $key ?>',event)">
									<i class="bi bi-x"></i>
								</button>

							</div>
							
						</div>

					</div>	
					
				<?php endforeach ?>

			<?php else: ?>

				<div class="row row-cols-1 row-cols-sm-2 itemObject">
				
					<div class="col">
						
						<div class="form-floating mb-3">
							<input 
							type="text"
							class="form-control rounded propertyObject <?php echo $module->columns[$i]->title_column ?>"
							onchange="changeItemObject('<?php echo $module->columns[$i]->title_column ?>')"
							>

							<label>Propiedad</label>

						</div>

					</div>

					<div class="col">
						
						<div class="form-floating mb-3">
							
							<input 
							type="text"
							class="form-control rounded position-relative valueObject <?php echo $module->columns[$i]->title_column ?>"
							onchange="changeItemObject('<?php echo $module->columns[$i]->title_column ?>')"
							>

							<label>Valor</label>

							<button type="button" class="btn btn-sm position-absolute" style="top:0; right:0;" onclick="removeObject('<?php echo $module->columns[$i]->title_column ?>','_0',event)">
								<i class="bi bi-x"></i>
							</button>

						</div>
						
					</div>

				</div>	

			<?php endif ?>


		<?php else: ?>
		
			<div class="row row-cols-1 row-cols-sm-2 itemObject">
				
				<div class="col">
					
					<div class="form-floating mb-3">
						<input 
						type="text"
						class="form-control rounded propertyObject <?php echo $module->columns[$i]->title_column ?>"
						onchange="changeItemObject('<?php echo $module->columns[$i]->title_column ?>')"
						>

						<label>Propiedad</label>

					</div>

				</div>

				<div class="col">
					
					<div class="form-floating mb-3">
						
						<input 
						type="text"
						class="form-control rounded position-relative valueObject <?php echo $module->columns[$i]->title_column ?>"
						onchange="changeItemObject('<?php echo $module->columns[$i]->title_column ?>')"
						>

						<label>Valor</label>

						<button type="button" class="btn btn-sm position-absolute" style="top:0; right:0;" onclick="removeObject('<?php echo $module->columns[$i]->title_column ?>','_0',event)">
							<i class="bi bi-x"></i>
						</button>

					</div>
					
				</div>

			</div>	

		<?php endif ?>

	</div>

	<button type="button" class="btn btn-sm btn-default backColor rounded addObject"><small>Add Item</small></button>

	<?php if (!empty($data)): ?>

		<input type="hidden" name="<?php echo $module->columns[$i]->title_column ?>" id="<?php echo $module->columns[$i]->title_column ?>" value='<?php echo urldecode($data[$module->columns[$i]->title_column]) ?>'>

	<?php else: ?>

		<input type="hidden" name="<?php echo $module->columns[$i]->title_column ?>" id="<?php echo $module->columns[$i]->title_column ?>" value='{}'>

	<?php endif ?>	
<?php endif ?>