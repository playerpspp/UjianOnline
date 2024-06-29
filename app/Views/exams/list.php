<?= view('head'); ?>

<?= view('nav'); ?>
<head>
    <title>Exam List: <?= $exam->exam_name ?></title>
</head>

<section id="main-content">
    <div class="row">

        <!-- /# column -->
        <div class="col-lg-12">
            <a onclick="history.back()"><button class="btn btn-primary">
                Back
            </button></a>
            <div class="card">
                <div class="card-title pr">

                    <h4>Students that have work on this exam</h4>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <?php if(!empty($result)) { ?>
                        <a href="<?= base_url('/exams/excel/'. $exam->exam_id) ?>"><button class="btn btn-success" title="Export Student Result">Export</button></a>
                    <?php } ?>
                        <table class="table student-data-table m-t-20">
                            <thead>
                                <tr>
                                    <th width="5%">Student Name</th>
                                    <th width="5%">Start at</th>
                                    <th width="5%">Finished at</th>
                                    <th width="5%">Result</th>
                                    <th width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($students as $student) { ?>
                                    <tr>
                                        <td><?= $student->student_name ?></td>
                                        <?php if(isset($result[$student->student_id]) ) { 
                                            $studentExam = $result[$student->student_id];
                                            ?>
                                            <td><?= $studentExam->started_at ?></td>
                                            <?php if(isset($studentExam->finished_at) ) { ?>
                                                <td><?= $studentExam->finished_at ?></td>
                                            <?php } 
                                            else{ ?>
                                                <span class="badge badge-danger">Not Finish</span>
                                            <?php } ?>
                                            <td>
                                                <?php if($studentExam->status== "graded") { ?>
                                                    <span class="badge badge-primary"><?= $studentExam->result ?>/100</span>
                                                <?php } 
                                                elseif($studentExam->status== "ungraded") { ?>
                                                    <span class="badge badge-warning">Ungraded</span>
                                                <?php } 
                                                elseif($studentExam->status== "in_progress") { ?>
                                                    <span class="badge badge-danger">Not Finish</span>
                                                <?php } ?>
                                            </td> 

                                            <td>
                                               <a href="<?= base_url('/exams/student/'. $studentExam->examStudent_id) ?>"><button class="btn btn-box" title="answers"><i class="ti-eye"></i></button></a>
                                           <?php }else{ ?>
                                            <td><span class="badge badge-danger">No work</span></td>
                                            <td><span class="badge badge-danger">No work</span></td>
                                            <td><span class="badge badge-danger">No Work</span></td>
                                            <td><span class="badge badge-danger">No Work</span></td>
                                        <?php }  ?>
                                    </td>                                   
                                </tr>
                            <?php } ?>
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