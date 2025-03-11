<?= $this->extend('Views\default') ?>

<?= $this->section('stylesheet') ?>
<style>
	.center {
		text-align: center;
	}

	.pagination {
		display: inline-block;
	}

	.pagination li {
		color: black;
		float: left;
		padding: 8px 16px;
		text-decoration: none;
		transition: background-color .3s;
		border: 1px solid #007bff;
		margin: 0 1px;
		font-size: 18px;
		border-radius: 5px;
	}

	.pagination li.active {
		background-color: #dee2e6;
		/*#17a2b8, 212529, dee2e6*/
		color: white;
		border: 1px solid #4CAF50;
		border-radius: 5px;
	}

	.pagination li:hover:not(.active) {
		background-color: #ddd;
	}

	.csv button {
		color: black;
		float: left;
		padding: 8px 16px;
		text-decoration: none;
		transition: background-color .3s;
		border: 1px solid #007bff;
		margin: 0 1px;
		font-size: 18px;
		border-radius: 5px;
	}

	.csv button span {
		cursor: pointer;
		display: inline-block;
		position: relative;
		transition: 0.5s;
	}

	.csv button span:after {
		content: '\00bb';
		position: absolute;
		opacity: 0;
		top: 0;
		right: -20px;
		transition: 0.5s;
	}

	.csv button:hover span {
		padding-right: 25px;
	}

	.csv button:hover span:after {
		opacity: 1;
		right: 0;
	}

	.delete {
		position: relative;
		width: 50px;
		height: 50px;
		border-radius: 25px;
		border: 2px solid rgb(231, 50, 50);
		background-color: #fff;
		cursor: pointer;
		box-shadow: 0 0 10px #333;
		overflow: hidden;
		transition: .3s;
	}

	.delete:hover {
		background-color: rgb(245, 207, 207);
		transform: scale(1.2);
		box-shadow: 0 0 4px #111;
		transition: .3s;
	}

	.delete svg {
		color: rgb(231, 50, 50);
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		transition: .3s;
	}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>የመዝገበ ቃላት ዝርዝር</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href=<?= base_url('home') ?>>Home</a></li>
					<?php if (isset($Breadcrumbs)) {
						echo '<li class="breadcrumb-item"><a href="' . base_url('dictionarylist') . '">የመዝገበ ቃላት ዝርዝር</a></li>';
						echo '<li class="breadcrumb-item active">' . $Breadcrumbs . '</li>';
						//echo '<li class="breadcrumb-item">ገጾች</li>';
					} else
						echo '<li class="breadcrumb-item active"><a href="#">የመዝገበ ቃላት ዝርዝር</a></li>'; ?>
				</ol>
			</div>
		</div>
	</div><!-- /.container-fluid -->
</section>

<section class="container-fluid">
	<div class="row">
		<div class="container-fluid">
			<div class="card">
				<div class="card-header text-center">
					<strong>የመዝገበ ቃላት ዝርዝር</strong>
				</div>
				<div class="card-body">

					<!-- Pagination -->
					<div class="row" style="column-width:100px;">
						<div class="col-4 csv">
							<?php if (isset($pager)) { ?>
								<form action="" method="post">
									<button name="CSV" value="CSV">CSV</button>
									<button name="CSVonlythispage" value="CSVonlythispage">CSV Only this Page</button>
								</form><?php } ?>
						</div>
						<div class="col-8 float-right">
							<div class="float-right" style="color:blue;">
								<?php if (isset($pager)) {
									echo $pager->links();
								}
								?>
							</div>
						</div>

					</div>


					<div class="row">
						<div class="col-12">
							<div class="card card-info">
								<div class="card-header">
									<h3 class="card-title">መዝገበ ቃላት<?php if (isset($Breadcrumbs)) echo " / " . $Breadcrumbs; ?></h3>
									<div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
											<i class="fa fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="card-body p-0">
									<form action="" method="post">
										<?php if (isset($data)) {
											echo $maketable->generate();
										}
										if (isset($table))
											echo $table; ?>
									</form>
								</div>
							</div>
						</div>
					</div>

					<!-- Pagination -->
					<div class="row float-right">
						<?php if (isset($pager)) {
							echo $pager->links();
						}
						?>
					</div>
					<!-- Pagination -->

				</div>
			</div>
		</div>
	</div>
</section>






<?= $this->endSection() ?>

<?= $this->section('javascript') ?>

<?= $this->endSection() ?>