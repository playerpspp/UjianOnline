<?= view('head'); ?>

<?= view('nav'); ?>

<head>
	<title>Teachers Table</title>
	<link href="/css/lib/jsgrid/jsgrid-theme.min.css" rel="stylesheet" />
	<link href="/css/lib/jsgrid/jsgrid.min.css" type="text/css" rel="stylesheet" />
</head>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">

				<div class="card-title">
					<h4 style="margin-left: 3px;">Teachers Table </h4>

				</div>

				<a style="margin-left: 5px;" href="<?= base_url('/teachers/input/') ?>"><button class="btn btn-box" title="Add new"><i class="ti-plus"></i></button></a>
				<br>

				<div class="card-body">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Email</th>
									<th>Level</th>
									<th>Username</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$no=1;
								
								foreach ($teachers as $teacher) { ?>
									<tr>
										<th scope="row"><?= $no++ ?></th>
										<td><?= $teacher->teacher_name ?></td>
										<td><?= $teacher->email ?></td>
										<td><?= $teacher->role ?></td>
										<td><?= $teacher->username ?></td>
										<td>
											<a href="<?= base_url('/teachers/edit/'. $teacher->id_user) ?>"><button class="btn btn-box" title="Edit"><i class="ti-pencil-alt"></i></button></a>

											<a href="<?= base_url('/teachers/delete/'. $teacher->id_user) ?>"><button class="btn btn-box" title="Delete"><i class="ti-trash"></i></button></a>
										</td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>






	<?= view('footer'); ?>