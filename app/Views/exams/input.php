<?= view('head'); ?>

<?= view('nav'); ?>
<style type="text/css">
    .delete {
        margin-top: 10px;
    }
    .space {
        margin: 5px 0 5px 0;
    }
    .tf {
        margin: 5px 0 5px 5px;
    }
    textarea {
        display: block;
    }
</style>

<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-10">
                    <a onclick="history.back()"><button class="btn btn-primary">
                        Back
                    </button></a>
                    <div class="card">
                        <div class="card-title">
                            <h4>New Class Form</h4>

                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <form action="<?= base_url('/exams/actinput') ?>" method="POST">

                                    <div class="form-group">
                                        <label>Name</label>
                                        <input required type="text" id="name"  name="name" value="" class="form-control" placeholder="Name">
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" value="" name="description" rows="3"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Class</label>
                                        <select required id="class" name="class" class="form-control">
                                            <option>-</option>
                                            <?php foreach($classes as $class) { ?>

                                                <option value="<?= $class->class_id ?>"><?= $class->class_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div> 
                                    <label for="start-time">Start Time:</label>
                                    <input required class="form-control" value="" type="datetime-local" id="start-time" name="start-time">

                                    <label for="end-time">End Time:</label>
                                    <input required class="form-control" value="" type="datetime-local" id="end-time" name="end-time">
                                    <!-- @foreach(old('question', ['']) as $key => $value) -->

                                    <!-- </div> -->
                                    <!-- </div> -->
                                    <!-- </div> -->
                                    <h4>QUESTIONS</h4>
                                    <div id="questions-container">
                                      <div class="question">
                                        <div class="card">
                                            <div class="card-body">
                                                <!-- <div class="basic-form"> -->


                                                    <h4>1:</h4>
                                                    <label>Question:</label>
                                                    <textarea  class="form-control" id="question_0" name="question[0]" value="" placeholder="Question text" ></textarea><br>
                                                    <label>Question Type:</label>
                                                    <select class="form-control space" title="Question Type" name="question_type[]" onchange="showAnswerFields(this.value, event)">
                                                        <option>-</option>
                                                        <option value="essay">Essay</option>
                                                        <option value="SD">Objektif SD</option>
                                                        <option value="SMP">Objektif SMP</option>
                                                        <option value="SMA">Objektif SMA</option>
                                                        <option value="true_false">True/False</option>
                                                    </select>
                                                    <div id="answer-fields-1"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- @endforeach -->
                                <button class="btn btn-primary" style="margin: 10px auto;" type="button" onclick="createNewQuestion()">Add Question</button>

                                <button type="submit" class="btn btn-default">Submit</button>
                            </form>
                            <!-- <div id="questions-count">There are <span id="count"></span> questions</div> -->
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://cdn.tiny.cloud/1/fhqo4q1x8uzqz1m9ujzb4tspbyxvuf1cu3zgbovl29xfhpww/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
            <script>
                function initTinyMCE() {
                  tinymce.init({
                    selector: 'textarea',
                    height: 200,
                    plugins: [
                      'advlist autolink lists link image charmap print preview anchor',
                      'searchreplace visualblocks code fullscreen',
                      'insertdatetime media table paste code help wordcount'
                      ],
                    toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                    content_css: '//www.tiny.cloud/css/codepen.min.css'
                });
              }

// Call the initTinyMCE function when the page first loads
              initTinyMCE();

              let questionCount = document.querySelectorAll('.question').length;
              const countElement = document.getElementById('count');
              const questionsContainer = document.getElementById('questions-container');
              const questionTemplate = questionsContainer.querySelector('.question');

              function getQuestionCount() {
                  return questionsContainer.querySelectorAll('.question').length;
              }

              function cloneQuestion() {
                  questionCount++;
                  const clonedQuestion = questionTemplate.cloneNode(true);
                  const questionNumber = `${getQuestionCount() + 1}:`;
                  clonedQuestion.querySelector('h4').textContent = questionNumber;
                  clonedQuestion.querySelector('textarea').name = `question[${parseInt(questionNumber) - 1}]`;
                  clonedQuestion.querySelector('textarea').id = `question_${parseInt(questionNumber) - 1}`;

                // clonedQuestion.querySelector('textarea').value = '';
                  clonedQuestion.querySelector('textarea').placeholder = 'Question text';
                  clonedQuestion.querySelector('select').selectedIndex = 0;
                  clonedQuestion.querySelector('select').name = 'question_type]';
                  clonedQuestion.querySelector('#answer-fields-1').innerHTML = '';

                // Add delete button
                  const deleteButton = document.createElement('button');
                  deleteButton.type = 'button';
                  deleteButton.className = 'delete btn btn-danger';
                  deleteButton.textContent = 'Delete';
                  deleteButton.onclick = function () {
                    deleteQuestion(clonedQuestion);
                };
                clonedQuestion.querySelector('.card-body').appendChild(deleteButton);

                questionsContainer.appendChild(clonedQuestion);

                // initialize TinyMCE after appending to DOM
                // const clonedTextarea = clonedQuestion.querySelector(`#question_${parseInt(questionNumber) - 1}`);
                tinymce.execCommand('mceRemoveControl', true, `#question_${parseInt(questionNumber) - 1}`);
                tinymce.init({
                    selector: `#question_${parseInt(questionNumber) - 1}`,
                    height: 200,
                    plugins: [
                        'advlist autolink lists link image charmap print preview anchor',
                        'searchreplace visualblocks code fullscreen',
                        'insertdatetime media table paste code help wordcount'
                        ],
                    toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                    content_css: '//www.tiny.cloud/css/codepen.min.css',
                    
                });
            }

            function createNewQuestion() {
              questionCount++;
              const newQuestion = document.createElement('div');
              newQuestion.classList.add('question');
              newQuestion.innerHTML = `
              <div class="card">
              <div class="card-body">
              <h4>${getQuestionCount() + 1}:</h4>
              <label>Question:</label>
              <textarea class="form-control" id="question_${getQuestionCount()}" name="question[${getQuestionCount()}]" value="" placeholder="Question text"></textarea><br>
              <label>Question Type:</label>
              <select class="form-control space" title="Question Type" name="question_type[]" onchange="showAnswerFields(this.value, event)">
              <option>-</option>
              <option value="essay">Essay</option>
              <option value="SD">Objektif SD</option>
              <option value="SMP">Objektif SMP</option>
              <option value="SMA">Objektif SMA</option>
              <option value="true_false">True/False</option>
              </select>
              <div id="answer-fields-1"></div>
              <button type="button" class="delete btn btn-danger" onclick="deleteQuestion(this.parentNode.parentNode.parentNode)">Delete</button>
              </div>
              </div>
              `;

              questionsContainer.appendChild(newQuestion);

  // initialize TinyMCE after appending to DOM
              tinymce.execCommand('mceRemoveControl', true, `#question_${getQuestionCount()}`);
              tinymce.init({
                selector: `textarea`,
                height: 200,
                plugins: [
                  'advlist autolink lists link image charmap print preview anchor',
                  'searchreplace visualblocks code fullscreen',
                  'insertdatetime media table paste code help wordcount'
                  ],
                toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
                content_css: '//www.tiny.cloud/css/codepen.min.css',

          });
          }





          function deleteQuestion(question) {
            const questionNumber = question.querySelector('h4').textContent.split(':')[0];
            question.remove();
            questionCount--;
            // updateQuestionNumbers();
        }


        function showAnswerFields(value, event) {
            const target = event.target.parentElement.parentElement.parentElement.querySelector('#answer-fields-1');
            let answerFields = '';
            if (value === 'SMP') {
                answerFields = `
                <style>
                textarea {
                    display: block;
                }
                </style>

                <div class="form-group">
                <textarea id="question_right_answer_${questionCount - 1 }" style="display: block;"  type="text" class="form-control" name="question_right_answer[${questionCount - 1 }]" placeholder="Right Answer" ></textarea>
                </div>
                <div class="form-group">
                <textarea id="question_answers_${questionCount - 1 }"  type="text" class="form-control" name="question_answers[${questionCount - 1 }][]" placeholder="Other Answer" ></textarea>
                </div>
                <div class="form-group">
                <textarea id="question_answers_${questionCount - 1 }"  type="text" class="form-control" name="question_answers[${questionCount - 1 }][]" placeholder="Other Answer" ></textarea>
                </div>
                <div class="form-group">
                <textarea id="question_answers_${questionCount - 1 }"  type="text" class="form-control" name="question_answers[${questionCount - 1 }][]" placeholder="Other Answer" ></textarea>
                </div>
                `;
            }else if (value === 'SMA') {
                answerFields = `
                <style>
                textarea {
                    display: block;
                }
                </style>

                <div class="form-group">
                <textarea id="question_right_answer_${questionCount - 1 }"  type="text" class="form-control" name="question_right_answer[${questionCount - 1 }]" placeholder="Right Answer" ></textarea>
                </div>
                <div class="form-group">
                <textarea id="question_answers_${questionCount - 1 }"  type="text" class="form-control" name="question_answers[${questionCount - 1 }][]" placeholder="Other Answer" ></textarea>
                </div>
                <div class="form-group">
                <textarea id="question_answers_${questionCount - 1 }"  type="text" class="form-control" name="question_answers[${questionCount - 1 }][]" placeholder="Other Answer" ></textarea>
                </div>
                <div class="form-group">
                <textarea id="question_answers_${questionCount - 1 }"  type="text" class="form-control" name="question_answers[${questionCount - 1 }][]" placeholder="Other Answer" ></textarea>
                </div>
                <div class="form-group">
                <textarea id="question_answers_${questionCount - 1 }"  type="text" class="form-control" name="question_answers[${questionCount - 1 }][]" placeholder="Other Answer" ></textarea>
                </div>
                `;
            }else if (value === 'SD') {
                answerFields = `
                <style>
                textarea {
                    display: block;
                }
                </style>

                <div class="form-group">
                <textarea  id="question_right_answer_${questionCount - 1 }" type="text" class="form-control" name="question_right_answer[${questionCount - 1 }]" placeholder="Right Answer" ></textarea>
                </div>
                <div class="form-group">
                <textarea id="question_answers_${questionCount - 1 }" type="text" class="form-control" name="question_answers[${questionCount - 1 }][]" placeholder="Other Answer" ></textarea>
                </div>
                <div class="form-group">
                <textarea id="question_answers_${questionCount - 1 }"  type="text" class="form-control" name="question_answers[${questionCount - 1 }][]" placeholder="Other Answer" ></textarea>
                </div>

                `;
            }else if (value === 'true_false') {
                answerFields = `
                <div class="form-group tf">
                <div class="form-check form-check-inline">
                <input  class="form-check-input" type="radio" name="question_is_correct[${questionCount - 1}][]" value="Y" >
                <label class="form-check-label">True</label>
                </div>
                <div class="form-check form-check-inline">
                <input  class="form-check-input" type="radio" name="question_is_correct[${questionCount - 1}][]" value="N" >
                <label class="form-check-label">False</label>
                </div>
                </div>
                `;
            }

            target.innerHTML = answerFields;

            tinymce.init({
              selector: `#question_right_answer_${questionCount - 1 },#question_answers_${questionCount - 1 }`,
              height: 200,
              plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
                ],
              toolbar: 'undo redo | formatselect | ' +
              'bold italic backcolor | alignleft aligncenter ' +
              'alignright alignjustify | bullist numlist outdent indent | ' +
              'removeformat | help',
              content_css: '//www.tiny.cloud/css/codepen.min.css'
          });
        }



    </script>
    <?= view('footer'); ?>