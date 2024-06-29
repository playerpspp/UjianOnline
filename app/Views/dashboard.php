<?= view('head'); ?>

<?= view('nav'); ?>
<head>
    <title>Dashboard</title>
</head>

<!-- /# row -->
<section id="main-content">
    <div class="row">

        <!-- /# column -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-title pr">
                    <?php if(session()->get('role') == "admin") { ?>
                        <h4>Upcoming Exams that have been made</h4>
                    <?php }
                    elseif(session()->get('role') == "teacher") { ?>
                        <h4>Upcoming Exams that you made</h4>
                    <?php }elseif(session()->get('role') == "student"){ ?>
                        <h4>Upcoming Exams that you have</h4>
                    <?php } ?>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <?php if(!empty($exams)) { ?>
                            <table class="table student-data-table m-t-20">
                                <thead>
                                    <tr>
                                        <th width="5%">Exam Name</th>
                                        <th width="3%">Class</th>
                                        <th width="5%">teacher</th>
                                        <th width="5%">Start at</th>
                                        <th width="5%">End at</th>
                                        <th width="5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($exams as $exam) { ?>
                                        <tr>
                                            <td><?= $exam->exam_name ?></td>
                                            <td><?= $exam->class_name ?></td>
                                            <td><?= $exam->teacher_name ?></td>
                                            <td><?= $exam->start_time ?></td>
                                            <td><?= $exam->end_time ?></td>
                                            <td>
                                                <?php if(session()->get('role') != 'student') { ?>
                                                    <a href="<?= base_url('/exams/detail/'. $exam->exam_id) ?>"><button class="btn btn-box" title="detail"><i class="ti-clipboard"></i></button></a>
                                                <?php } ?>
                                                <?php if(session()->get('role') == 'student') { ?>
                                                    <a href="<?= base_url('/exams/ready/'. $exam->exam_id) ?>"><button class="btn btn-box" title="work"><i class="ti-pencil"></i></button></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php }elseif(empty($classes) && session()->get('role') == 'student') { ?>
                            <label>You haven't joined any class</label>
                        <?php }elseif(empty($exams)){ ?>
                            <label>there's no upcoming exams</label>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /# column -->
    </div>
    <!-- /# row -->
</div>
<!-- /# column -->


<?= view('footer'); ?>