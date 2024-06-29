<?= view('head'); ?>

<?= view('nav'); ?>
<head>
    <title>Exam: <?= $exam->exam_name?></title>
    <style type="text/css">
        p {
            display: inline-block;
        }
    </style>
</head>

<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="basic-form">
                        <a onclick="history.back()"><button class="btn btn-primary">
                            Back
                        </button></a>
                        <?php
                        $no=0;
                        $quest=1;
                        foreach ($questions as $question) { ?>
                            <div class="card">
                                <div class="card-title">
                                    <h4>
                                        <?= $quest ?>: <br>
                                        <?= $question->text ?>
                                    </h4>
                                </div><br>
                                <div class="card-body">
                                    <input type="hidden" id="question_id" name="question_id[]" value="<?= $question->question_id ?>">
                                    <?php
                                    $id = $question->question_id;
                                    if($question->type === 'abcd'||$question->type === 'true_false'){
                                        foreach($answers[$id] as $answer){

                                            if($answer->is_correct == "N") { ?>
                                                <input type="radio" name="question_answer[<?= $no ?>]" value="<?= $answer->answer_id ?>" id="question_answer_<?= $no ?>_<?=$answer->answer_id?>" onclick="saveValue(this);" disabled>
                                                <label for="question_answer_<?= $no ?>_<?=$answer->answer_id?>">
                                                    <?php if ($question->type =='abcd' ){ ?>
                                                        <?= $answer->option ?>. 
                                                    <?php } ?>
                                                    <?= $answer->text ?></label><br>
                                                <?php }
                                                elseif($answer->is_correct == "Y") { ?>
                                                    <span style="background-color: rgba(0, 155, 0, .2);">
                                                        <input type="radio" name="question_answer[<?= $no ?>]" value="<?=$answer->answer_id?>" id="question_answer_<?= $no ?>_<?=$answer->answer_id?>" onclick="saveValue(this);" disabled checked>
                                                        <label style=" color: black" for="question_answer_<?= $no ?>_{{<?= $id ?>}}">
                                                            <?php if ($question->type =='abcd' ){ ?>
                                                                <?= $answer->option ?>. 
                                                            <?php } ?>                                                        <?= $answer->text ?></label>
                                                        </span>
                                                        <br>
                                                        <?php 
                                                    }
                                                }
                                            }

                                            elseif($question->type == 'essay') { ?> 
                                                <textarea disabled class="form-control" id="question_answer_<?= $no ?>" value="" name="question_answer[<?= $no ?>]" rows="3" onchange="saveValue(this);"></textarea>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php
                                    $quest++;
                                    $no++;

                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= view('footer'); ?>