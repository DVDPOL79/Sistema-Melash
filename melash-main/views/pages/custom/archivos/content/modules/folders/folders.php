<?php 

$url = "folders";
$method = "GET";
$fields = array();

$folders = CurlController::request($url,$method,$fields);

if($folders->status == 200){

	$folders = $folders->results;
	

}else{

	$folders = array();
}

?>

<!--=====================================
FOLDERS
======================================-->

<div class="col-12 col-lg-7 mt-3">

		<div class="row listFolders">

			<?php if (!empty($folders)): ?>

				<?php foreach ($folders as $key => $value): ?>

					<div class="col">

						<div class="form-check">
							<input class="form-check-input check-fms changeFolders" type="checkbox" id="check_<?php echo $key ?>" name="folders" value="<?php echo $value->id_folder ?>_<?php echo $value->name_folder ?>" checked>
							<label class="form-check-label ps-1 align-middle"><?php echo $value->name_folder ?></label>
						</div>

						<?php 

						 $percent = $value->total_folder*100/$value->size_folder;
						 $percent = number_format($percent,3);

						?>

						<div class="progress mt-1" style="height:10px">
							<div class="progress-bar progress-bar-striped progress-bar-animated 
							<?php if ($percent < 50): ?>bg-success<?php endif ?>
							<?php if ($percent >= 50 && $percent < 75): ?>bg-primary<?php endif ?>  
							<?php if ($percent >= 75 && $percent < 85): ?>bg-warning<?php endif ?> 
							<?php if ($percent >= 85): ?>bg-danger<?php endif ?> "  
							style="width:<?php echo $percent ?>%"><?php echo $percent ?>%</div>
						</div>
					</div>
					
				<?php endforeach ?>
				
			<?php endif ?>

		</div>
		
</div>