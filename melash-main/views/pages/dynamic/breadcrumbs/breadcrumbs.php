<!--==============================
  Breadcrumb
 ================================-->

<div class="<?php if ($module->width_module == "100"): ?> col-lg-12 <?php endif ?><?php if ($module->width_module == "75"): ?> col-lg-9 <?php endif ?><?php if ($module->width_module == "50"): ?> col-lg-6 <?php endif ?><?php if ($module->width_module == "33"): ?> col-lg-4 <?php endif ?><?php if ($module->width_module == "25"): ?> col-lg-3 <?php endif ?> col-12 mb-3 position-relative">

	<?php if ($_SESSION["admin"]->rol_admin == "superadmin"): ?>

		<div class="position-absolute border rounded" style="top:-15px; right:25px">
			
			<button type="button" class="btn btn-sm text-muted rounded m-0 px-1 py-0 border-0 myModule" item='<?php echo json_encode($module) ?>' idPage="<?php echo $page->results[0]->id_page ?>">
				<i class="bi bi-pencil-square"></i>
			</button>

			<button type="button" class="btn btn-sm text-muted rounded m-0 px-1 py-0 border-0 deleteModule" idModule=<?php echo base64_encode($module->id_module) ?> >
				<i class="bi bi-trash"></i>
			</button>


		</div>
		
	<?php endif ?>

	<div class="d-lg-flex justify-content-lg-between mt-2">

		<div class="text-capitalize h5 ps-2"><?php echo $module->title_module ?></div>

		<div class="pe-0">
			<ul class="nav justify-content-lg-end">
				<li class="nav-item">
					<a class="nav-link py-0 px-0 text-dark" href="/">Inicio</a>
				</li>
				<li class="nav-item ps-3">/</li>
				<li class="nav-item">
					<a class="nav-link py-0 disabled text-capitalize" href="#"><?php echo $module->title_module ?></a>
				</li> 
			</ul>
		</div>

	</div>

</div>