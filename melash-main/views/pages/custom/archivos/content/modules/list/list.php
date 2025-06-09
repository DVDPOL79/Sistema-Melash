<!--=====================================
LIST
======================================-->

<div class="table-responsive modules" id="list">
	
	<table class="table mb-5">
		
		<thead>
			
			<th>Preview</th>
			<th>Name</th>
			<th>Size</th>
			<th>Folder</th>
			<th>Link</th>
			<th>Modified</th>
			<th>Actions</th>

		</thead>

		<tbody>

			<tr></tr>

			<?php if (!empty($files)): ?>

				<?php foreach ($files as $key => $value): ?>

					<?php 

					$path = TemplateController::returnThumbnailList($value);
				

					?>

					<tr style="height:100px">

						<td>
							<?php echo $path ?>
						</td>

						<td class="align-middle">
							<div class="input-group">
								<input type="text" class="form-control changeName" value="<?php echo $value->name_file ?>" idFile="<?php echo $value->id_file ?>">
								<span class="input-group-text">.<?php echo $value->extension_file ?></span>
							</div>
						</td>

						<td class="align-middle"><?php echo number_format($value->size_file/1000000,2) ?> MB</td>

						<td class="align-middle">
							<span class="badge bg-dark rounded px-3 py-2 text-white"><?php echo $value->name_folder ?></span>
						</td>

						<td class="align-middle">
							<a href="<?php echo $value->link_file ?>" target="_blank">
								<?php echo TemplateController::reduceText($value->link_file,35) ?>...
								<i class="bi bi-box-arrow-up-right ps-2 btn"></i>
							</a>
						</td>

						<td class="align-middle"><?php echo $value->date_updated_file ?></td>

						<td class="align-middle">
						  <svg class="bi bi-copy copyLink" copy="<?php echo $value->link_file ?>" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="cursor:pointer">
							  <path fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z"/>
							</svg>
						  <i class="bi bi-trash ps-2 btn deleteFile" idFile="<?php echo $value->id_file ?>" idFolder="<?php echo $value->id_folder ?>" mode="list"></i>
						</td>

					</tr>
					
				<?php endforeach ?>
				
			<?php endif ?>

		</tbody>

	</table>


</div>