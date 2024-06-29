<?= view('head'); ?>

<?= view('nav'); ?>
<head>
    <title>Class List: <?= $class->class_name ?></title>
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

                    <h4>Students that is in this class</h4>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table m-t-10">
                            <thead>
                                <tr>
                                    <th width="10%">Student Name</th>
                                    <th width="5%">NISN</th>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($students as $student) { ?>
                                    <tr>
                                        <td><?= $student->student_name ?></td>
                                        <td><?= $student->NISN ?></td>
                                        <td>
                                            <a href="<?= base_url('/classes/remove/'. $student->student_id .'/' . $class->class_id) ?>"><button class="btn btn-danger" title="detail"><i class="ti-trash"></i></button></a>
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