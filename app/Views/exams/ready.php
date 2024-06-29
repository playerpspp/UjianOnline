<?= view('head'); ?>

<?= view('nav'); ?>
<head>
    <title>Exam: <?=$exam->exam_name?></title>
</head>

<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-13">
                    <a onclick="history.back()"><button class="btn btn-primary">
                        Back
                    </button></a>
                    <div class="card">
                        <div class="card-title">
                            <?php if($time <= $exam->start_time) { ?>
                             <h4>HAVEN'T START YET</h4>
                         <?php } 
                         elseif($time >= $exam->start_time && $time <= $exam->end_time){ 
                            if($check == null || $check->status== "in_progress"){ ?>
                                <h4>READY?</h4>
                            <?php }  
                            elseif($check && ($check->status == "graded" || $check->status == "ungraded")){ ?>
                                <h4>COMPLETED</h4>
                            <?php }
                        } 
                        elseif($time >= $exam->end_time){ ?>
                            <h4>ENDED</h4>
                        <?php } ?>
                    </div><br>
                    <div class="card-body">

                        <?php if($time <= $exam->start_time){ ?>
                            <p>The exam is going to start at <?= $exam->start_time ?></p>
                        <?php } ?>

                        <?php if($time >= $exam->start_time && $time <= $exam->end_time){ ?>
                            <?php if($check == null || $check->status== "in_progress"){ ?>
                                <p>The exam has started from <?= $exam->start_time ?></p>
                                <p>Hurry up the exam is going to end at <?= $exam->end_time ?></p>
                                <a href="<?= base_url('/exams/work/'.$exam->exam_id) ?>"><button class="btn btn-box" title="work"><i class="ti-pencil"></i></button></a>
                            <?php } ?>
                        <?php } ?>

                        <?php if($check && ($check->status == "graded" || $check->status == "ungraded")){ ?>
                            <p>You have completed the Exam. Good Job!</p>
                        <?php } ?>

                        <?php if($time > $exam->end_time){ ?>
                            <p>The exam ended at <?= $exam->end_time ?> <?=$time ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?= view('footer'); ?>