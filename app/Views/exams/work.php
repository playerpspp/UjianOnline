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
                    <form action="<?= base_url('/exams/actwork/'. $exam->exam_id) ?>" method="POST"> 
                        <!-- <input type="hidden" id="id" name="id[]" value="{{ $id }}"> -->
                        <div class="basic-form">
                           <?php
                           $no=0;
                           $quest=1;
                           foreach ($questions as $question) { ?>
                            <div class="card">
                                <div class="card-title">
                                    <h4>
                                       <?= $quest ?>:
                                       <?= $question->text ?>
                                   </h4>
                               </div><br>
                               <div class="card-body">
                                <input type="hidden" id="question_id" name="question_id[]" value="<?= $question->question_id ?>">
                                <?php
                                $id = $question->question_id;
                                if($question->type === 'abcd'){
                                    $option=['A','B','C','D','E'];
                                    foreach($answers[$id] as $answer) { ?>

                                        <input type="radio" name="question_answer[<?= $no ?>]" value="<?= $answer->answer_id ?>" id="question_answer_<?= $no ?>_<?=$answer->answer_id?>" onclick="saveValue(this);" required>
                                        <label for="question_answer_<?= $no ?>_<?=$answer->answer_id?>"><?= array_shift($option)?>. <?= $answer->text ?></label><br>
                                        <?php 
                                    } 
                                }

                                elseif($question->type == 'true_false') { 
                                    foreach($answers[$id] as $answer) { ?>

                                        <input type="radio" name="question_answer[<?= $no ?>]" value="<?= $answer->answer_id ?>" id="question_answer_<?= $no ?>_<?=$answer->answer_id?>" onclick="saveValue(this);" required>
                                        <label for="question_answer_<?= $no ?>_<?=$answer->answer_id?>"><?= $answer->text ?></label><br>
                                        <?php 
                                    } 
                                }

                                elseif($question->type == 'essay') { ?> 
                                    <textarea required class="form-control" id="question_answer_<?= $no ?>" value="{{ old('description') }}" name="question_answer[<?= $no ?>]" rows="3" onchange="saveValue(this);"></textarea>
                                <?php } ?>
                            </div>
                        </div>
                        <?php
                        $quest++;
                        $no++;
                    } ?>
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
            <!-- <div id="questions-count">There are <span id="count"></span> questions</div> -->
        </div>
    </div>
</div>
</div>
</div>
<?= view('footer'); ?>
<script type="text/javascript">
                                /*          timer          */

                                /*
  // Set the date/time for the exam start and end
 // Get the start and end times for the exam
                                var startTime = new Date("{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->start_time)->getTimestamp() }}" * 1000);
                                var endTime = new Date("{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->end_time)->getTimestamp() }}" * 1000);


  // Get the HTML elements for displaying the timer
                                var timerDiv = document.getElementById('timer');
                                var submitForm = document.getElementById('exam-form');

  // Update the timer every second
                                var timerInterval = setInterval(function() {
    // Get the current date/time
                                    var now = new Date();

    // Calculate the time remaining
                                    var timeRemaining = endTime - now;

    // If the time has already elapsed, submit the form and stop the timer
                                    if (timeRemaining <= 0) {
                                      clearInterval(timerInterval);
                                      submitForm.submit();
                                      } else {
      // Convert the time remaining to minutes and seconds
                                          var minutesRemaining = Math.floor(timeRemaining / 60000);
                                          var secondsRemaining = Math.floor((timeRemaining % 60000) / 1000);

      // Display the time remaining
                                          timerDiv.innerHTML = 'Time remaining: ' + minutesRemaining + ' minutes, ' + secondsRemaining + ' seconds';
                                      }
                                      }, 1000);

  */

                                      /*          penyimpan jawaban          */


    // // Set the value of input elements from localStorage if available
    // function setSavedValues() {
    //     for (let i = 0; i < localStorage.length; i++) {
    //         let key = localStorage.key(i);
    //         let value = localStorage.getItem(key);
    //         let element = document.getElementById(key);
    //         if (element) {
    //             if (element.type === "radio") {
    //                 if (element.value === value) {
    //                     element.checked = true;
    //                 }
    //             } else {
    //                 element.value = value;
    //             }
    //         }
    //     }
    // }

    // // Save the value of input elements to localStorage when changed
    // function saveValue(element) {
    //     let id = element.id;
    //     let value = element.value;
    //     localStorage.setItem(id, value);
    // }

    // // Call setSavedValues function when the page is loaded
    // window.onload = setSavedValues;
</script>
