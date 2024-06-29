<?= view('head'); ?>

<?= view('nav'); ?>

<head>
	<title>Classes Table</title>
	<link href="/css/lib/jsgrid/jsgrid-theme.min.css" rel="stylesheet" />
	<link href="/css/lib/jsgrid/jsgrid.min.css" type="text/css" rel="stylesheet" />
</head>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">

				<div class="card-title">
					<h4 style="margin-left: 3px;">Classes Table </h4>

				</div>

				<a style="margin-left: 5px;" href="<?= base_url('/classes/input') ?>"><button class="btn btn-box" title="Add new"><i class="ti-plus"></i></button></a>
				<br>

				<div class="card-body">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th width="1%">#</th>
									<th width="10%">Class Name</th>
									<th width="10%">Teacher Name</th>
									<th width="10%">Total Student</th>
									<th width="5%">Lists</th>
									<th width="5%">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$no=1;
								foreach ($classes as $class) { ?>
									<tr>
										<th scope="row"><?= $no++ ?></th>
										<td><?= $class->class_name ?></td>
										<td><?= $class->teacher_name ?></td>
										<?php if (isset($count[$class->class_id])) { ?>
											<td><?= $count[$class->class_id]->total_students ?></td>
										<?php } else { ?>
											<td>0</td>
										<?php } ?>
										<td>
											<a href="<?= base_url('/classes/list/'. $class->class_id) ?>"><button class="btn btn-box" title=" Student list"><i class="ti-list"></i></button></a>
											<a href="<?= base_url('/classes/exams/'. $class->class_id) ?>"><button class="btn btn-box" title="exams list"><i class="ti-clipboard"></i></button></a>
										</td>
										<td>
											<a href="<?= base_url('/classes/edit/'. $class->class_id) ?>"><button class="btn btn-box" title="Edit"><i class="ti-pencil-alt"></i></button></a>

											<a href="<?= base_url('/classes/delete/'. $class->class_id) ?>"><button class="btn btn-box" title="Delete"><i class="mdi mdi-server-remove"></i></button></a>
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