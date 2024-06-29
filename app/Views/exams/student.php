<?= view('head'); ?>

<?= view('nav'); ?>
<head>
  <title>Exam: <?= $exam->exam_name?></title>
</head>

<div class="content-wrap">
  <div class="main">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-13">
          <div class="basic-form">
           <a onclick="history.back()"><button class="btn btn-primary">
            Back
          </button></a>
          <h4>Student Name: <?= $student->student_name ?></h4>
          <?php if($examStudent->status == "graded") { ?>
            <h4>grade: <?= $examStudent->result ?>/100</h4>
          <?php }
          elseif($examStudent->status == "ungraded"){ ?>
            <h4>grade: Ungraded</h4>

          <?php } 
          $no=0;
          $quest=1;
          foreach ($questions as $question) {
            // $examStudent = $exam->examStudent->firstWhere('student_id', $studentID);
            // $studentAnswers = $exam->examStudent[0]->examAnswer[$no];
            ?>

            <div class="card">
              <div class="card-title">
                <h4>
                 <?= $quest ?>:
                 <?= $question->text ?>
               </h4>
             </div><br>
             <div class="card-body">
              <input type="hidden" id="question_id" name="question_id[]" value="{{ $question->id }}">
              <?php
              $id = $question->question_id;
              if($question->type === 'abcd'||$question->type === 'true_false'){
                foreach($answers[$id] as $answer){ ?>

                  <?php if($answer->is_correct == "N" && isset($studentAnswers[$no]->answer_id) && $studentAnswers[$no]->answer_id == $answer->answer_id) { ?>
                    <span style="background-color: rgba(155, 0, 0, .2);">
                      <input checked type="radio" name="question_answer[<?= $no ?>]" value="{{$answer->id}}" id="question_answer_<?= $no ?>_{{$answer->id}}" onclick="saveValue(this);" readonly>
                      <label><?= $answer->text ?></label>
                    </span><br>
                  <?php }
                  elseif($answer->is_correct == "Y" && isset($studentAnswers[$no]->answer_id) && $studentAnswers[$no]->answer_id == $answer->answer_id) { ?>
                    <span style="background-color: rgba(0, 155, 0, .2);">
                      <input checked type="radio" name="question_answer[<?= $no ?>]" value="{{$answer->id}}" id="question_answer_<?= $no ?>_{{$answer->id}}" onclick="saveValue(this);" readonly >
                      <label style="color: black"><?= $answer->text ?></label>
                    </span>
                    <br>
                  <?php }
                  elseif($answer->is_correct == "Y" && (!isset($studentAnswers[$no]) || $studentAnswers[$no] != $answer->answer_id)) { ?>
                    <span style="background-color: rgba(0, 155, 0, .2);">
                      <input  type="radio" name="question_answer[<?= $no ?>]" value="{{$answer->id}}" id="question_answer_<?= $no ?>_{{$answer->id}}" onclick="saveValue(this);" readonly>
                      <label style="color: black"><?= $answer->text ?></label>
                    </span>
                    <br>
                  <?php }
                  elseif($answer->is_correct == "N" && (!isset($studentAnswers[$no]) || $studentAnswers[$no] != $answer->answer_id)){ ?>
                    <input type="radio" name="question_answer[<?= $no ?>]" value="{{$answer->id}}" id="question_answer_<?= $no ?>_{{$answer->id}}" onclick="saveValue(this);" readonly>
                    <label><?= $answer->text ?></label><br>
                  <?php }
                }
              }
              ?>

              <?php if($question->type == 'essay' && isset($studentAnswers[$no])) { ?>
                <input disabled class="form-control" id="question_answer_<?= $no ?>" value="<?= $studentAnswers[$no]->answer_text ?>" name="question_answer[<?= $no ?>]" rows="3" onchange="saveValue(this);"></input>
              <?php } ?>
            </div>
          </div>
          <?php
          $quest++;
          $no++;
        } ?>


        <?php if($examStudent->status == "ungraded" || $examStudent->status == "graded") { 
          $id = $examStudent->examStudent_id;
          ?>
          <div class="card">
            <div class="card-title">
              <?php if($examStudent->status == "ungraded") { ?>
                <h5>The Student is not graded want to grade it?</h5>
              <?php }
              if($examStudent->status == "graded") { ?>
                <h5>The Student is already graded want to change it?</h5>
              <?php } ?>
            </div>

            <div class="basic-form">
              <form action="<?= base_url('/exams/nilai/'.$id) ?>" method="POST">
                <input required class="form-control" type="number" step="0.01" max="100" id="nilai" value="" name="nilai" rows="3" ></input><br>
                <button class="btn btn-success" type="submit">Submit</button>
              </form>
            </div>
          </div>
        <?php } ?>
        <br>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<?= view('footer'); ?>