<?= view('head'); ?>

<?= view('nav'); ?>
<head>
    <title>Exams Table</title>
    <link href="/css/lib/jsgrid/jsgrid-theme.min.css" rel="stylesheet" />
    <link href="/css/lib/jsgrid/jsgrid.min.css" type="text/css" rel="stylesheet" />
</head>


</div>
<!-- /# row -->
<div class="row">

    <!-- /# column -->
    <div class="col-md-12">
        <a onclick="history.back()"><button class="btn btn-primary">
            Back
        </button></a>
        <div class="card">
            <div class="card-title">
                <h4>Exams that have been made for class: <?= $class->class_name ?> </h4>
            </div>
            <div class="card-body">
             <?php if(session()->get('teacher_id') == $class->teacher_id) { ?>
                <a style="margin-left: 5px;" href="<?= base_url('/exams/input') ?>"><button class="btn btn-box" title="Add new"><i class="ti-plus"></i></button></a>

            <?php } ?>
            <div class="table-responsive">
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

                                    <a href="<?= base_url('/exams/detail/'. $exam->exam_id) ?>"><button class="btn btn-box" title="detail"><i class="ti-clipboard"></i></button></a>
                                    <a href="<?= base_url('/exams/list/'. $exam->exam_id) ?>"><button class="btn btn-box" title="Students List"><i class="ti-list"></i></button></a>
                                    
                                </td>
                            <?php } ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /# column -->
</div>
<!-- /# row -->

<!-- /# column -->
</div>


<?= view('footer'); ?>