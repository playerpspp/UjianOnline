<?php

namespace App\Controllers;

use App\Models\M_model;
use CodeIgniter\Controller;


class Students extends BaseController
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
        $on = 'users.id_user=students.user_id';
        $on2 ='students.class_id=classes.class_id';
        $user['students'] = $model->fusion('users','students',$on);

        // echo view('head');
        // echo view('nav');
        echo view('users/students/students',$user);
        // echo view('footer');

    }

    public function input()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/home'));
        }
        $model = new M_model();
        $user['classes'] = $model->tampil('classes');
        echo view('users/students/input', $user);
    }

    public function actinput()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/home'));
        }

        $username= $this->request->getPost('username');
        $name= $this->request->getPost('name');
        $nisn= $this->request->getPost('nisn');
        $password= $this->request->getPost('password');
        $email= $this->request->getPost('email');

        $user=array(
            'username'=>$username,
            'password'=>md5($password),
            'email'=>$email,
            'role'=>'student',
        );
        // print_r($this->request->getPost());
        $model=new M_model();
        $model->simpan('users', $user);
        $where=array('email'=>$email);
        $id=$model->getarray('users', $where);
        $iduser = $id['id_user'];

    // //Yang ditambah ke karyawan
        $student=array(
            'student_name'=>$name,
            'NISN'=>$nisn,
            'user_id'=>$iduser,
        );
        $model->simpan('students', $student);
        return redirect()->to(base_url('/students'));
    }

    public function edit($id)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/home'));
        }
        $model = new M_model();
        $on = 'users.id_user=students.user_id';
        $where =array('id_user'=>$id);
        $user['student'] = $model->fusionRow('users','students',$on,$where);
        // $user['classes'] = $model->tampil('classes');

        // echo view('head');
        // echo view('nav');
        echo view('users/students/edit',$user);
        // echo view('footer');

    }

    public function actedit()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/home'));
        }

        $username= $this->request->getPost('username');
        $name= $this->request->getPost('name');
        $nisn= $this->request->getPost('nisn');
        $email= $this->request->getPost('email');
        $class= $this->request->getPost('class');
        $id= $this->request->getPost('id');
        $where=array('id_user'=>$id);
        $where2=array('user_id'=>$id);
        $user=array(
            'username'=>$username,
            'email'=>$email,
        );
        // print_r($this->request->getPost());
        $model=new M_model();
        $model->edit('users', $user, $where);

    // //Yang ditambah ke karyawan
        $student=array(
            'student_name'=>$name,
            'NISN'=>$nisn,
            'class_id'=>$class
        );
        $model->edit('students', $student, $where2);
        return redirect()->to(base_url('/students'));
    }

    public function delete($id)
    {
        if (!$this->checkAuth()) {
            return redirect()->to('/home');
        }
        $model=new M_model();
        $where=array('id_user'=>$id);
        $where2=array('user_id'=>$id);
        $model->hapus('students',$where2);
        $model->hapus('users',$where);
        return redirect()->to(base_url('/students'));
    }




}
