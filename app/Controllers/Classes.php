<?php

namespace App\Controllers;

use App\Models\M_model;
use CodeIgniter\Controller;


class Classes extends BaseController
{

    protected function checkAuth()
    {
        $id_user = session()->get('id_user');
        $role = session()->get('role');
        if ($id_user > 0 && $role == 'admin') {
            return true;
        } else {
            return false;
        }
    }


    public function index()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/home'));
        }
        $model = new M_model();
        $on ='classes.teacher_id=teachers.teacher_id';
        $class['classes'] = $model->fusionleft('classes','teachers',$on);
        $class['count'] = $model->countStudentsPerClass();
        // print_r($class['count']);

        echo view('users/classes/classes',$class);

    }

    public function list($id)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/home'));
        }
        $model = new M_model();
        $where = array('class_id' => $id);
        $on ='classes.teacher_id=teachers.teacher_id';
        $class['class'] = $model->fusionRow('classes','teachers',$on, $where);

        $on2 ='student_class_bridge.student_id=students.student_id';
        $class['students'] = $model->fusion_where('student_class_bridge','students',$on2,$where);
        // print_r($class['count']);

        echo view('users/classes/list',$class);

    }

    public function exams($id)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/home'));
        }
        $model = new M_model();
        

            // print_r($where);
        $where = array('class_id' => $id);
        $on ='classes.teacher_id=teachers.teacher_id';
        $exams['class'] = $model->fusionRow('classes','teachers',$on, $where);

        $on2 = 'exams.class_id=classes.class_id';
        $on3 = 'exams.teacher_id=teachers.teacher_id';
        $where2 =array('exams.class_id'=>$id); 
        $exams['exams']= $model->super_w('exams','classes','teachers',$on2,$on3,$where2);

        // print_r($exams['exams']);

        // echo view('head');
        // echo view('nav');
        echo view('users/classes/exams',$exams);
        // echo view('footer');

    }

    public function input()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/home'));
        }
        $model = new M_model();
        // $data['classes'] = $model->tampil('classes');
        $data['teachers'] = $model->tampil('teachers');
        echo view('users/classes/input', $data);
    }

    public function actinput()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/home'));
        }
        $model = new M_model();

        $name = $this->request->getPost('name');
        $teacher = $this->request->getPost('teacher');
        $student = $this->request->getPost('student');

        $class=array(
            'class_name'=>$name,
            'teacher_id'=>$teacher,
        );
        $classID = $model->simpanID('classes', $class);
        $where = array('student_name' => $student);
        $data = $model->like('students', $where);
        foreach($data as $student) {
            $student_data = array(
                'student_id' => $student->student_id,
                'class_id' => $classID
            );
            $model->simpan('student_class_bridge', $student_data);
        }
        // print_r($data);
        return redirect()->to(base_url('/classes'));
    }

    public function edit($id)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/home'));
        }
        $model = new M_model();
        $where =array('class_id'=>$id);
        $user['class'] = $model->getRow('classes',$where);

        // echo view('head');
        // echo view('nav');
        echo view('users/classes/edit',$user);
        // echo view('footer');

    }

    public function actedit()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/home'));
        }
        $model=new M_model();

        $name= $this->request->getPost('name');
        $student = $this->request->getPost('student');
        $id= $this->request->getPost('id');

        $where=array('class_id'=>$id);
        $class=array(
            'class_name'=>$name,
        );
        // print_r($this->request->getPost());
        $model->edit('classes', $class, $where);

        $where = array('student_name' => $student);
        $data = $model->like_row('students', $where);
            $student_data = array(
                'student_id' => $student->student_id,
                'class_id' => $id
            );
            $model->simpan('student_class_bridge', $student_data);

        return redirect()->to(base_url('/classes'));
    }

    public function delete($id)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/home'));
        }
        $model=new M_model();
        $where=array('id_user'=>$id);
        $where2=array('user_id'=>$id);
        $model->hapus('students',$where2);
        $model->hapus('users',$where);
        return redirect()->to(base_url('/students)'));
    }

    public function remove($studentID, $classID)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/home'));
        }

        $model=new M_model();
        $where=array('student_id'=>$studentID , 'class_id' => $classID);
        $model->hapus('student_class_bridge',$where);
        return redirect()->back();
    }




}
