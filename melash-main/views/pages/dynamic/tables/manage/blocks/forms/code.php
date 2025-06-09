<?php if ($module->columns[$i]->type_column == "code"): ?>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

	<textarea 
	class="form-control rounded summernote"
	id="<?php echo $module->columns[$i]->title_column ?>" 
	name="<?php echo $module->columns[$i]->title_column ?>"><?php if (!empty($data)): ?><?php echo urldecode($data[$module->columns[$i]->title_column]) ?><?php endif ?></textarea>

<?php endif ?>