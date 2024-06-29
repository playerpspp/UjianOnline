<?= view('head'); ?>

<?= view('nav'); ?>

<head>
	<title>Students Table</title>
	<link href="/css/lib/jsgrid/jsgrid-theme.min.css" rel="stylesheet" />
	<link href="/css/lib/jsgrid/jsgrid.min.css" type="text/css" rel="stylesheet" />
</head>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">

				<div class="card-title">
					<h4 style="margin-left: 3px;">Students Table </h4>

				</div>

				<a style="margin-left: 5px;" href="<?= base_url('/students/input') ?>"><button class="btn btn-box" title="Add new"><i class="ti-plus"></i></button></a>
				<br>

				<div class="card-body">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>NISN</th>
									<th>Email</th>
									<th>Username</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$no=1;
								
								foreach ($students as $student) { ?>
									<tr>
										<th scope="row"><?= $no++ ?></th>
										<td><?= $student->student_name ?></td>
										<td><?= $student->NISN ?></td>
										<td><?= $student->email ?></td>
										<td><?= $student->username ?></td>
										<td>
											<a href="<?= base_url('/students/edit/'. $student->id_user) ?>"><button class="btn btn-box" title="Edit"><i class="ti-pencil-alt"></i></button></a>

											<a href="<?= base_url('/students/delete/'. $student->id_user) ?>"><button class="btn btn-box" title="Delete"><i class="ti-trash"></i></button></a>
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