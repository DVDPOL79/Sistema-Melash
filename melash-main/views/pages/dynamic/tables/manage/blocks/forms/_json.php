<?php if ($module->columns[$i]->type_column == "json"): ?>

	<?php if (!empty($data) && $data[$module->columns[$i]->title_column] != null): $arrayObj = new ArrayObject(json_decode(urldecode($data[$module->columns[$i]->title_column])));?>

		<?php if (!empty($arrayObj) && $arrayObj->count() > 0): ?>

			<?php foreach ($arrayObj as $key => $value): ?>

				<div class="rounded p-2 border mb-3 jsonGroup <?php echo $module->columns[$i]->title_column ?>" position="<?php echo $key ?>_">

					<?php foreach ($value as $index => $item): ?>
		
						<div class="itemsJson">

							<div class="row row-cols-1 row-cols-sm-2 itemJson">

								<div class="col">
								
									<div class="form-floating mb-3">
										
										<input 
										type="text"
										class="form-control rounded <?php echo $key ?>_propertyJson <?php echo $module->columns[$i]->title_column ?>"
										value="<?php echo $index ?>"
										onchange="changeItemJson('<?php echo $module->columns[$i]->title_column ?>')" 
										>

										<label>Propiedad</label>

									</div>

								</div>

								<div class="col">
									
									<div class="form-floating mb-3">
										
										<input 
										type="text"
										class="form-control rounded position-relative <?php echo $key ?>_valueJson <?php echo $module->columns[$i]->title_column ?>"
										value="<?php echo htmlspecialchars($item) ?>" 
										onchange="changeItemJson('<?php echo $module->columns[$i]->title_column ?>')"
										>

										<label>Valor</label>

										<button type="button" class="btn btn-sm position-absolute" style="top:0; right:0;" onclick="removeJson('<?php echo $module->columns[$i]->title_column ?>', '_<?php echo array_search($index,array_keys(json_decode(json_encode($value),true))) ?>',event)">
											<i class="bi bi-x"></i>
										</button>

									</div>
									
								</div>

							</div>

						</div>

					<?php endforeach ?>

					<button type="button" class="btn btn-sm btn-default backColor rounded addJson float-start">
						<small>Add Item</small>
					</button>
					<button type="button" class="btn btn-sm btn-default border rounded  float-end" onclick="removeJsonGroup('<?php echo $module->columns[$i]->title_column ?>','<?php echo $key ?>_',event)">
						<small>Remove Group</small>
					</button>
					<div class="clearfix"></div>

				</div>

			<?php endforeach ?>	

		<?php else: ?>

			<div class="rounded p-2 border mb-3 jsonGroup <?php echo $module->columns[$i]->title_column ?>" position="0_" titleColumn="">
				
				<div class="itemsJson">

					<div class="row row-cols-1 row-cols-sm-2 itemJson">

						<div class="col">
						
							<div class="form-floating mb-3">
								
								<input 
								type="text"
								class="form-control rounded  0_propertyJson <?php echo $module->columns[$i]->title_column ?>"
								onchange="changeItemJson('<?php echo $module->columns[$i]->title_column ?>')"
								>

								<label>Propiedad</label>

							</div>

						</div>

						<div class="col">
							
							<div class="form-floating mb-3">
								
								<input 
								type="text"
								class="form-control rounded position-relative 0_valueJson <?php echo $module->columns[$i]->title_column ?>"
								onchange="changeItemJson('<?php echo $module->columns[$i]->title_column ?>')"
								>

								<label>Valor</label>

								<button type="button" class="btn btn-sm position-absolute" style="top:0; right:0;" onclick="removeJson('<?php echo $module->columns[$i]->title_column ?>', '_0',event)">
									<i class="bi bi-x"></i>
								</button>

							</div>
							
						</div>

					</div>
					

				</div>

				<button type="button" class="btn btn-sm btn-default backColor rounded addJson float-start">
					<small>Add Item</small>
				</button>
				<button type="button" class="btn btn-sm btn-default border rounded  float-end" onclick="removeJsonGroup('<?php echo $module->columns[$i]->title_column ?>','0_',event)">
					<small>Remove Group</small>
				</button>
				<div class="clearfix"></div>

			</div>

		<?php endif ?>	

	<?php else: ?>	

		<div class="rounded p-2 border mb-3 jsonGroup <?php echo $module->columns[$i]->title_column ?>" position="0_">
			
			<div class="itemsJson">

				<div class="row row-cols-1 row-cols-sm-2 itemJson">

					<div class="col">
					
						<div class="form-floating mb-3">
							
							<input 
							type="text"
							class="form-control rounded 0_propertyJson <?php echo $module->columns[$i]->title_column ?>"
							onchange="changeItemJson('<?php echo $module->columns[$i]->title_column ?>')"
							>

							<label>Propiedad</label>

						</div>

					</div>

					<div class="col">
						
						<div class="form-floating mb-3">
							
							<input 
							type="text"
							class="form-control rounded position-relative 0_valueJson <?php echo $module->columns[$i]->title_column ?>"
							onchange="changeItemJson('<?php echo $module->columns[$i]->title_column ?>')">

							<label>Valor</label>

							<button type="button" class="btn btn-sm position-absolute" style="top:0; right:0;" onclick="removeJson('<?php echo $module->columns[$i]->title_column ?>', '_0',event)">
								<i class="bi bi-x"></i>
							</button>

						</div>
						
					</div>

				</div>
				

			</div>

			<button type="button" class="btn btn-sm btn-default backColor rounded addJson float-start">
				<small>Add Item</small>
			</button>
			<button type="button" class="btn btn-sm btn-default border rounded float-end" onclick="removeJsonGroup('<?php echo $module->columns[$i]->title_column ?>','0_',event)">
				<small>Remove Group</small>
			</button>
			<div class="clearfix"></div>

		</div>

	<?php endif ?>

	<button type="button" class="btn btn-sm btn-default backColor rounded addJsonGroup float-end">
		<small>Add Group</small>
	</button>

	<?php if (!empty($data)): ?>

		<input type="hidden" name="<?php echo $module->columns[$i]->title_column ?>" id="<?php echo $module->columns[$i]->title_column ?>" value='<?php echo urldecode($data[$module->columns[$i]->title_column]) ?>'>

	<?php else: ?>

		<input type="hidden" name="<?php echo $module->columns[$i]->title_column ?>" id="<?php echo $module->columns[$i]->title_column ?>" value='[]'>

	<?php endif ?>	

<?php endif ?>