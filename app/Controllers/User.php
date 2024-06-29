<?php

namespace App\Controllers;

use App\Models\M_model;
use CodeIgniter\Controller;


class User extends BaseController
{

    protected function checkAuth()
    {
        $id_user = session()->get('id_user');
        if ($id_user > 0) {
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
    $on = 'exams.class_id=classes.class_id';
    $on2 = 'exams.teacher_id=teachers.teacher_id';

    if (session()->get('role') == 'admin') 
        {
            $id = session()->get('teacher_id');
            // print_r($where);
            $where =array('exams.end_time >' => date('Y-m-d H:i:s'));        
            // print_r($where);
            $data['exams']= $model->super_w('exams','classes','teachers',$on,$on2,$where);

        }
        elseif (session()->get('role') == 'teacher') 
        {
            $id = session()->get('teacher_id');
            $where =array('exams.teacher_id'=>$id, 'exams.end_time >' => date('Y-m-d H:i:s'), 'classes.teacher_id'=>$id);        
            // print_r($where);
            $data['exams']= $model->super_w('exams','classes','teachers',$on,$on2,$where);

        

    }elseif (session()->get('role') == 'student') {

        $where = array('student_id' => session()->get('student_id'));
        $classes = $model->getwhere('student_class_bridge', $where);
        $where2_array = [];
        foreach ($classes as $class) {
            $where2_array[] = $class->class_id;
        }
        $where2 = array('exams.end_time >' => date('Y-m-d H:i:s'));

        if (!empty($where2_array)) {
            $data['exams']= $model->super_whereIn2('exams','classes','teachers',$on,$on2,'exams.class_id',$where2_array,$where2);
        }

        $data['classes'] = $classes;
        
    }
    // print_r($where); 
    echo view('dashboard',$data);
}

public function user()
{
    $model = new M_model();
    $user = $model->tampil('users');
    echo json_encode($user);

}

public function teachers()
{
    $model = new M_model();
    $on = 'users.id_user=teachers.user_id';
    $user['teachers'] = $model->fusion('users','teachers',$on);

        // echo view('head');
        // echo view('nav');
    echo view('users/teachers/teachers',$user);
        // echo view('footer');

}
}
