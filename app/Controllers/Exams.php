<?php

namespace App\Controllers;

use App\Models\M_model;
use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Exams extends BaseController
{

    protected function checkAuth($check)
    {
        $id_user = session()->get('id_user');
        $role = session()->get('role');
        if ($check == 'true') {
            if ($id_user > 0) {
                return true;
            } else {
                return false;
            }
        }else{
            if ($id_user > 0 && $role != 'student') {
                return true;
            } else {
                return false;
            }
        }
    }


    public function index()
    {
        if (!$this->checkAuth('true')) {
            return redirect()->to(base_url('/home'));
        }
        $model = new M_model();
        $on = 'exams.class_id=classes.class_id';
        $on2 = 'exams.teacher_id=teachers.teacher_id';

        if (session()->get('role') == 'admin') 
        {
            $id = session()->get('teacher_id');
            // print_r($where);
            $exams['exams']= $model->super('exams','classes','teachers',$on,$on2);

        }
        elseif (session()->get('role') == 'teacher') 
        {
            $id = session()->get('teacher_id');
            $where =array('exams.teacher_id'=>$id, 'classes.teacher_id'=>$id);        
            // print_r($where);
            $exams['exams']= $model->super_w('exams','classes','teachers',$on,$on2,$where);

        }
        elseif (session()->get('role') == 'student') 
        {
            $studentID = session()->get('student_id');

            $where =array('student_id' =>$studentID );
            $exams['student'] = $model->getWhereKey('exam_students',$where,'exam_id');

            $where2 = array('student_id' => session()->get('student_id'));
            $classes = $model->getwhere('student_class_bridge', $where2);

            $where2_array = [];
            foreach ($classes as $class) {
                $where2_array[] = $class->class_id;
            }


            $exams['exams']= $model->super_whereInKey('exams','classes','teachers',$on,$on2, 'exams.class_id',$where2_array,'exam_id');
        }
        // print_r($exams['exams']);

        // echo view('head');
        // echo view('nav');
        echo view('exams/exams',$exams);
        // echo view('footer');

    }

    public function list($id)
    {
        if (!$this->checkAuth('false')) {
            return redirect()->to(base_url('/home'));
        }
        $model = new M_model();

        $on = 'exams.class_id=classes.class_id';
        $on2 = 'exams.teacher_id=teachers.teacher_id';

        $where =array('exams.exam_id' => $id);        
            // print_r($where);
        $data['exam']= $model->super_row('exams','classes','teachers',$on,$on2,$where); 


        $where2 =array('class_id' => $data['exam']->class_id);
        $studentIDs= $model->getWhereKey('student_class_bridge', $where2,'student_id');
        foreach ($studentIDs as $studentID){
            $array_student[] = ['student_id' => $studentID->student_id];
        }
        $where3 =array('exam_id' => $id);
        $data['students']= $model->getwhereInKey('students', $array_student, 'student_id');
        $data['result']= $model->getwhereInKey_where('exam_students', $array_student, 'student_id', $where3);



        // print_r($data['result']);
        // echo view('head');
        // echo view('nav');
        echo view('exams/list',$data);
        // echo view('footer');

    }

    public function input()
    {
        if (!$this->checkAuth('false')) {
            return redirect()->to(base_url('/home'));
        }
        $model = new M_model();
        
        $class['classes'] = $model->tampil('classes');
        
        $id = session()->get('teacher_id');
        $where =array('classes.teacher_id'=>$id);        
            // print_r($where);
        $class['classes'] = $model->getwhere('classes', $where);

        echo view('exams/input',$class);
    }

    
    public function actinput()
    {
        if (!$this->checkAuth('false')) {
            return redirect()->to(base_url('/home'));
        }

        // print_r($this->request->getPost());

        $name= $this->request->getPost('name');
        $description= $this->request->getPost('description');
        $start= $this->request->getPost('start-time');
        $end= $this->request->getPost('end-time');
        $class = $this->request->getPost('class');
        $teacher= session()->get('teacher_id');

        $exam=array(
            'exam_name'=>$name,
            'description'=>$description,
            'start_time'=>$start,
            'end_time'=>$end,
            'class_id'=>$class,
            'teacher_id'=>$teacher,
            'created_at'=> date('Y-m-d H:i:s'),
        );
        // print_r($this->request->getPost());
        $model=new M_model();
        $examID = $model->simpanID('exams', $exam);
        // echo $examID;
        $where=array('teacher_id'=>$teacher);
        $id=$model->getarray('exams', $where);
        $idexam = $id['exam_id'];

        $questions = $this->request->getPost('question');
        $question_types = $this->request->getPost('question_type');
        // print_r($questions);

        $questionid = array();
        $questiontype = array();

        foreach ($questions as $key => $question) {
            // $quest = Question::create([
            //     'exam_id' => $exam->id,
            //     'text' => $question,
            //     'type' => $question_types[$key],
            // ]);

            if($question_types[$key] === 'SD' || $question_types[$key] === 'SMP' || $question_types[$key] === 'SMA') {

                $type[$key]= 'abcd';
            }elseif ($question_types[$key] === 'essay') {
                $type[$key]= 'essay';
            }elseif ($question_types[$key] === 'true_false') {
                $type[$key]= 'true_false';
            }

            if($question_types[$key] === 'SD') {
                $option = ['A','B','C'];
                shuffle($option);
            }elseif($question_types[$key] === 'SMP') {
                $option = ['A','B','C','D'];
                shuffle($option);
            }elseif($question_types[$key] === 'SMA') {
                $option = ['A','B','C','D','E'];
                shuffle($option);
            }
            $quest=array(
                'exam_id' => $examID,
                'text' => $question,
                'type' => $type[$key],
            );
            $questID = $model->simpanID('questions', $quest);
            $where = array('question_id'=>$questID);
            $q = $model->getarray('questions',$where);
            $questionid[$key] = $q['question_id'];
            $questiontype[$key] = $q['type'];

    // dd($questionid[$key]);


            if ($questiontype[$key] === 'abcd') {
                $answers = $this->request->getPost('question_answers')[$key];
                $right = $this->request->getPost('question_right_answer')[$key];
                $ans=array(
                    'text' => $right,
                    'question_id' => $questionid[$key],
                    'option' => array_shift($option),
                    'is_correct' => 'Y',
                );
                $model->simpan('answers', $ans);

                foreach ($answers as $answerKey => $answerText) {
            // dd($answerKey);
                    $answ=array(
                        'text' => $answerText,
                        'question_id' => $questionid[$key],
                        'option' => array_shift($option),
                        'is_correct' => 'N',
                    );
                    $model->simpan('answers', $answ);
                }
            } elseif ($questiontype[$key] === 'true_false') {
                $question_is_correct = $this->request->getPost('question_is_correct');

                $true=array(
                    'text' => 'True',
                    'question_id' => $questionid[$key],
                    'option' => 'true',
                    'is_correct' => $question_is_correct[$key][0] === 'Y' ? 'Y' : 'N',
                );

                $false=array(
                    'text' => 'False',
                    'question_id' => $questionid[$key],
                    'option' => 'false',
                    'is_correct' => $question_is_correct[$key][0] === 'N' ? 'Y' : 'N',
                );
                $model->simpan('answers', $true);
                $model->simpan('answers', $false);

            }

//         // $questionIds[] = $questionid;
        }

        // $model->simpan('teachers', $teacher);
        return redirect()->to(base_url('/exams'));
    }

    public function detail($id)
    {
        if (!$this->checkAuth('false')) {
            return redirect()->to(base_url('/home'));
        }
        $model = new M_model();
        $where=array('exam_id'=>$id);
        $exam['exam'] = $model->getRow('exams',$where);
        $exam['questions'] = $model->getwhereKey('questions', $where, 'question_id');
        $where2_array = [];

        foreach ($exam['questions'] as $question) {
            $where2_array[] = ['question_id' => $question->question_id];
        }

        $exam['answers'] = $model->getwhereInKey4('answers',$where2_array,'question_id');
        // echo json_encode($exam['answers'], JSON_PRETTY_PRINT);
        echo view('exams/detail',$exam);
    }

    public function student($id)
    {
        if (!$this->checkAuth('false')) {
            return redirect()->to(base_url('/home'));
        }
        $model = new M_model();
        $where=array('examStudent_id'=>$id);
        $exam['examStudent'] = $model->getRow('exam_students',$where);

        $where2=array('student_id'=>$exam['examStudent']->student_id);
        $exam['student'] = $model->getRow('students',$where2);

        $where3=array('exam_id'=>$exam['examStudent']->exam_id);
        $exam['exam'] = $model->getRow('exams',$where3);

        $exam['questions'] = $model->getwhereKey('questions', $where3, 'question_id');
        $where3_array = [];

        foreach ($exam['questions'] as $question) {
            $where3_array[] = ['question_id' => $question->question_id];
        }
        $exam['answers'] = $model->getwhereInKey4('answers',$where3_array,'question_id');

        $where4=array('exam_student_id'=>$id);
        $exam['studentAnswers'] = $model->getwhere('exam_student_answers',$where4);
        // echo json_encode($exam['answers'], JSON_PRETTY_PRINT);

        echo view('exams/student',$exam);
    }

    public function ready($id)
    {
        if (!$this->checkAuth('true')) {
            return redirect()->to(base_url('/home'));
        }
        $model = new M_model();

        $where=array('exam_id'=>$id);
        $ready['exam'] = $model->getRow('exams', $where);
        $ready['time'] = date('Y-m-d H:i:s');

        $where2=array('exam_id'=>$id, 'student_id'=> session()->get('student_id'));
        $ready['check'] = $model->getRow('exam_students', $where2);

        return view('exams/ready',$ready);

    }

    public function work($id)
    {
        if (!$this->checkAuth('true')) {
            return redirect()->to(base_url('/home'));
        }
        $model = new M_model();
        $studentID = session()->get('student_id');
        $where =array('exam_id'=>$id);
        $time = $model->getRow('exams', $where);
        if($time->start_time >=  date('Y-m-d H:i:s') || $time->end_time <=  date('Y-m-d H:i:s')){
            return redirect(base_url('/exam/ready/'.$id));
        }

        $where2=array('exam_id'=>$id, 'student_id'=> $studentID);
        $check = $model->getRow('exam_students', $where2);
        // print_r($check);
        if ($check == null){

            $exam_student=array(
                'exam_id' => $id,
                'student_id' => $studentID,
                'started_at' => date('Y-m-d H:i:s'),
                'status' => 'in_progress'
            );
            $model->simpan('exam_students', $exam_student);
        }

        // $model = new M_model();
        $where=array('exam_id'=>$id);
        $exam['exam'] = $model->getRow('exams',$where);
        $exam['questions'] = $model->getwhereKey('questions', $where, 'question_id');
        $where2_array = [];

        foreach ($exam['questions'] as $question) {
            $where2_array[] = ['question_id' => $question->question_id];
        }

        $exam['answers'] = $model->getwhereInKey3('answers',$where2_array,'question_id');
        // echo json_encode($exam['answers'], JSON_PRETTY_PRINT);
        echo view('exams/work',$exam);
    }

    public function actwork($id)
    {
        if (!$this->checkAuth('true')) {
            return redirect()->to(base_url('/home'));
        }
        $model = new M_model();

        $where=array('exam_id'=>$id, 'student_id'=> session()->get('student_id'));
        $student = $model->getRow('exam_students', $where);

        $examStudentID = $student->examStudent_id;
        $question_id = $this->request->getPost('question_id');
        $answers = $this->request->getPost('question_answer');
        $essays = 0;

        foreach ($question_id as $key => $question) {
            $where2 =array('question_id'=> $question);
            $quest = $model->getRow('questions', $where2);
            // $answer = new ExamAnswer;
            // $answer->exam_student_id = $examStudentID;

            if ($quest->type == 'abcd' || $quest->type == "true_false") {
                $exam_student=array(
                    'exam_student_id' => $examStudentID,
                    'answer_id' => $answers[$key],
                );

            } elseif ($quest->type == 'essay') {
                $exam_student=array(
                    'exam_student_id' => $examStudentID,
                    'answers_text' => $answers[$key],
                );
            }
            $model->simpan('exam_student_answers', $exam_student);
        }

        $where3= array('type' => 'essay');
        $essay = $model->getwhereIn2('questions', 'question_id', $question_id, $where3);
        $essays = count($essay); 
        // print_r($essays);


        if ($essays == '0') {

            $where4=array('is_correct'=> 'Y');
            $right_ans = $model->getwhereIn2('answers','answer_id',$answers,$where4);

            $number = count($answers);
            $divided = 100 / $number;


            $result = $divided * count($right_ans);
        // dd($result);
            $grade= array(
                'finished_at' => date('Y-m-d H:i:s'),
                'status' => 'graded',
                'result' => $result,
            );
        // dd($result);
        } elseif ($essays > 0) {
            $grade=array(
                'finished_at' => date('Y-m-d H:i:s'),
                'status' => 'ungraded',
            );
        }

        $model->edit('exam_students',$grade,$where);

        return redirect()->to(base_url('/exams'));
    }

    public function nilai($id)
    {
        if (!$this->checkAuth('false')) {
            return redirect()->to(base_url('/home'));
        }
        $model = new M_model();
        $nilai = $this->request->getPost('nilai');
    // dd($nilai);
        $where = array('examStudent_id' => $id);
        $student = $model->getRow('exam_students',$where);
        $data = array(
            'status' => 'graded',
            'result' => $nilai,
        );
        $model->edit('exam_students', $data, $where);
        $exam_id = $student->exam_id;
    // dd($exam_id);
        return redirect()->to(base_url('/exams/list/'.$exam_id));
    }

    public function excel($id)
    {
        if (!$this->checkAuth('false')) {
            return redirect()->to(base_url('/home'));
        }
        $model = new M_model();
        $on = 'exams.class_id=classes.class_id';
        $on2 = 'exams.teacher_id=teachers.teacher_id';

        $where =array('exams.exam_id' => $id);        
            // print_r($where);
        $data['exam']= $model->super_row('exams','classes','teachers',$on,$on2,$where); 


        $where2 =array('class_id' => $data['exam']->class_id);
        $studentIDs= $model->getWhereKey('student_class_bridge', $where2,'student_id');

        foreach ($studentIDs as $studentID){
            $array_student[] = ['student_id' => $studentID->student_id];
        }

        $where3 =array('exam_id' => $id);
        $data['students']= $model->getwhereInKey_student('students', $array_student, 'student_id');

        $result= $model->getwhereInKey_where('exam_students', $array_student, 'student_id', $where3);

        foreach ($result as $examStudentID){
            $array_examStudent[] = $examStudentID->examStudent_id;

        }
        $data['questions']= $model->getwhere('questions',$where3); 
        $on3 = 'exam_student_answers.answer_id=answers.answer_id';
        $students_answers= $model->fusion_whereIn('exam_student_answers', 'answers', $on3, 'exam_student_id', $array_examStudent);
        $key =0;
        
        if (count($data['questions']) == 1 ) {
            foreach ($students_answers as $answers) {
                $answer[$answers->exam_student_id][$data['questions'][$key]->question_id] = $answers ;
            }

        }else{

            foreach ($students_answers as $answers) {
                $answer[$answers->exam_student_id][$data['questions'][$key]->question_id] = $answers ;
                $key++;
            }
        }

        foreach ($data['questions'] as $question) {
            $array_question[] =$question->question_id;
        }
        $where4 = ['is_correct' => 'Y'];
        $right_ans = $model->getwhereIn2('answers', 'question_id',$array_question,$where4);
        foreach ($right_ans as $ans) {
            $right_answers[$ans->question_id] = $ans;
        }

        // print_r($right_answers);
        $spreadsheet = new Spreadsheet();
        $worksheet = $spreadsheet->getActiveSheet();
        $worksheet->setCellValueByColumnAndRow(1, 1, "No");
        $worksheet->setCellValueByColumnAndRow(2, 1, "Student Name");
        
        $row = 2;
        $num=1;
        foreach ($data['students'] as $student) {
            $worksheet->setCellValueByColumnAndRow(1, $row, $num++);
            $worksheet->setCellValueByColumnAndRow(2, $row, $student->student_name);
            $row++;
        }
        $worksheet->setCellValueByColumnAndRow(2, $row, "Right Answer");
        $column=3;
        $No=1;
        foreach ($data['questions'] as $question) {
            if ($question->type != 'essay') {

                $worksheet->setCellValueByColumnAndRow($column, 1, "Q".$No);
                $ans_row = 2;
                foreach ($data['students'] as $id) {
                    if (!empty($result[$id->student_id] ) ) {
                        if (!empty($answer[$result[$id->student_id]->examStudent_id] ) ) { 
                            $worksheet->setCellValueByColumnAndRow($column, $ans_row, $answer[$result[$id->student_id]->examStudent_id][$question->question_id]->option);
                            if ($answer[$result[$id->student_id]->examStudent_id][$question->question_id]->is_correct == 'N') {
                                $cell = $worksheet->getCellByColumnAndRow($column, $ans_row);
                                
                                $cell->getStyle()->getFont()->getColor()->setRGB('FF0000');

                            }
                        }} else {
                            $worksheet->setCellValueByColumnAndRow($column, $ans_row, "N/A");
                            $cell = $worksheet->getCellByColumnAndRow($column, $ans_row);
                            
                            $cell->getStyle()->getFont()->getColor()->setRGB('FF0000');
                        }

                        $ans_row++;
                    }
                    $worksheet->setCellValueByColumnAndRow($column, $row, $right_answers[$question->question_id]->option);
                    $column++;
                    $No++;
                }
            }

            $result_row = 2;
            $worksheet->setCellValueByColumnAndRow($column, 1, "Result");


            foreach ($data['students'] as $id) {
                if (!empty($result[$id->student_id] ) ) {
                    $worksheet->setCellValueByColumnAndRow($column, $result_row, $result[$id->student_id]->result);
                }else{
                    $worksheet->setCellValueByColumnAndRow($column, $result_row, "N/A");
                    $cell = $worksheet->getCellByColumnAndRow($column, $result_row);
                    
                    $cell->getStyle()->getFont()->getColor()->setRGB('FF0000');
                }
                $result_row++;
            }




            $worksheet->getColumnDimension('B')->setWidth(30);

            $writer = new Xlsx($spreadsheet);
            $fileName = "Hasil Ujian ".$data['exam']->exam_name;

        // Redirect hasil xlsx ke web client
            header('Content-type:vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition:attachment;filename='.$fileName.'.xlsx');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');

        }

        // public function tes()
        // {
        //     $option = ['A','B','C','D'];
        //     shuffle($option);
        //     $a = array_shift($option);
        //     $b = array_shift($option);
        //     $c = array_shift($option);
        //     print_r($option);
        //     print_r($a);
        //     print_r($b);
        //     print_r($c);
        // // echo view('exams/tes');
        // }

        // public function acttest()
        // {

        //     print_r($this->request->getPost('tes'));
        // }

    }

