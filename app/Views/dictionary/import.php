<?= $this->extend('Views\default') ?>

<?= $this->section('stylesheet') ?>
<?= header('Content-Type: text/html; charset=UTF-8'); ?>



<?= $this->endSection() ?>

<?= $this->section('content') ?>

<body>
	<div class="container-fluid mt-2">
		<div class="card mt-2">
			<div class="card-header text-center">
				<strong>Upload CSV File</strong>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-12">
						<form action="<?php echo base_url('import'); ?>" method="post" enctype="multipart/form-data">
							<?php $style = 'class="form-control select2" style="width: 100%"'; ?>
							<div class="row">
								<div class="col-12 col-sm-6">
									<div class="form-group">
										<label>Dictionary</label>

										<?php echo form_dropdown('dictionary_id', $dictionary, set_value('dictionary_id'), $style); ?>
									</div>
									<div class="input-group">
										<span class="text-danger"><?= isset($validation) ? $validation->getError('dictionary_id') : '' ?></span>
									</div>
								</div>
								<div class="col-12 col-sm-6">
									<div class="form-group">
										<label>Number Of Fields</label>
										<input type="number" name="numberOfFields" value="<?= set_value('numberOfFields', 10) ?>" class="form-control" id="numberOfFields" min="10">
									</div>
									<div class="input-group">
										<span class="text-danger"><?= isset($validation) ? $validation->getError('numberOfFields') : '' ?></span>
									</div>
								</div>
							</div>

							<div class="row">

								<div class="col-12 col-sm-6">
									<div class="form-group">
										<label>Number of Rows</label>
										<input type="number" name="noofrows" value="<?= set_value('noofrows', 10000) ?>" class="form-control" id="noofrows" min="2" step="100">
									</div>
									<div class="input-group">
										<span class="text-danger"><?= isset($validation) ? $validation->getError('noofrows') : '' ?></span>
									</div>
								</div>
								<div class="col-12 col-sm-6">
									<div class="form-group">
										<label>CVS File</label>
										<input type="file" name="file" value="<?= set_value('file') ?>" class="form-control" id="file">
									</div>
									<div class="input-group">
										<span class="text-danger"><?= isset($validation) ? $validation->getError('file') : '' ?></span>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="d-grid">
									<input type="submit" name="submit" value="Upload" class="btn btn-dark" />
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="card-body mt-0 ml-0 mr-0 ">
				<?= $csv ?>
			</div>
		</div>
	</div>
</body>

</html>

<?= $this->endSection() ?>