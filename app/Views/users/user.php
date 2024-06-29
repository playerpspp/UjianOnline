@include('head')

@include('nav')

<head>
	<title>Users Table</title>
	<link href="/css/lib/jsgrid/jsgrid-theme.min.css" rel="stylesheet" />
	<link href="/css/lib/jsgrid/jsgrid.min.css" type="text/css" rel="stylesheet" />
</head>


				<!-- /# column -->
				<!-- <div class="col-lg-4 p-l-0 title-margin-left">
					<div class="page-header">
						
					</div>
				</div> -->
				<!-- /# column -->
			<!-- </div> -->
			<!-- /# row -->
			<!-- <section id="main-content"> -->
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-body">
								<!-- Nav tabs -->
								<!-- <ul class="nav nav-tabs" role="tablist">

									<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#teacher" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">Teachers</span></a> </li>

									<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#students" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">Students</span></a> </li>

								</ul> -->
								<!-- Tab panes -->
								<!-- <div class="tab-content tabcontent-border">
									<div class="tab-pane active p-20" id="teacher" role="tabpanel">
 -->
										<div class="card-title">
											<h4 style="margin-left: 3px;">Teachers Table </h4>

										</div>

										<a style="margin-left: 5px;" href="<?= base_url('/teachers/input') ?>"><button class="btn btn-box" title="Add new"><i class="ti-plus"></i></button></a>
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
														@php
														$no=1
														@endphp
														@foreach ($teachers as $teacher)
														<tr>
															<th scope="row">{{ $no++ }}</th>
															<td>{{ $teacher->name }}</td>
															<td>{{ $teacher->user->email }}</td>
															<td>{{ $teacher->user->role }}</td>
															<td>{{ $teacher->user->name }}</td>
															<td>
																<a href="<?= base_url('/teachers/edit/{{$teacher->user->id}}') ?>"><button class="btn btn-box" title="Edit" ><i class="ti-pencil-alt"></i></button></a>

																<a href="<?= base_url('/teachers/delete/{{$teacher->user->id}}') ?>"><button class="btn btn-box" title="Delete" ><i class="ti-trash"></i></button></a>
															</td>
														</tr>
														@endforeach
													</tbody>
												</table>
											</div>
										</div>
									</div>

									<!-- <div class="tab-pane  p-20" id="students" role="tabpanel">

										<div class="card-title">
											<h4 style="margin-left: 3px;">Students Table </h4>

										</div>

										<a style="margin-left: 5px;" href="/students/input"><button class="btn btn-box" title="Add new" ><i class="ti-plus"></i></button></a>
										<br>

										<div class="card-body">
											<div class="table-responsive">
												<table class="table">
													<thead>
														<tr>
															<th>#</th>
															<th>Name</th>
															<th>Email</th>
															<th>Username</th>
															<th>Class</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody>
														@php
														$no=1
														@endphp
														@foreach ($students as $student)
														<tr>
															<th scope="row">{{ $no++ }}</th>
															<td>{{ $student->name }}</td>
															<td>{{ $student->user->email }}</td>
															<td>{{ $student->user->name }}</td>
															<td>{{ $student->class->name }}</td>
															<td>
																<a href="/students/edit/{{$student->user_id}}"><button class="btn btn-box" title="Edit" ><i class="ti-pencil-alt"></i></button></a>

																<a href="/students/delete/{{$student->user_id}}"><button class="btn btn-box" title="Delete" ><i class="ti-trash"></i></button></a>
															</td>
														</tr>
														@endforeach
													</tbody>
												</table>
											</div>
										</div>
									</div> -->
									<!-- <div class="tab-pane p-20" id="messages" role="tabpanel">3</div> -->
								</div>
							</div>
						</div>
					

	



			@include('footer')