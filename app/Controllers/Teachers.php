<?php

namespace App\Controllers;

use App\Models\M_model;
use CodeIgniter\Controller;


class Teachers extends BaseController
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
        $on = 'users.id_user=teachers.user_id';
        $user['teachers'] = $model->fusion('users','teachers',$on);

        // echo view('head');
        // echo view('nav');
        echo view('users/teachers/teachers',$user);
        // echo view('footer');

    }

    public function input()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/home'));
        }

        echo view('users/teachers/input');
    }

    public function actinput()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/home'));
        }

        $username= $this->request->getPost('username');
        $name= $this->request->getPost('name');
        $password= $this->request->getPost('password');
        $email= $this->request->getPost('email');
        $role= $this->request->getPost('role');

        $user=array(
            'username'=>$username,
            'password'=>md5($password),
            'email'=>$email,
            'role'=>$role,
        );
        // print_r($this->request->getPost());
        $model=new M_model();
        $model->simpan('users', $user);
        $where=array('email'=>$email);
        $id=$model->getarray('users', $where);
        $iduser = $id['id_user'];

    // //Yang ditambah ke karyawan
        $teacher=array(
            'teacher_name'=>$name,
            'user_id'=>$iduser
        );
        $model->simpan('teachers', $teacher);
        return redirect()->to(base_url('/teachers'));
    }

    public function edit($id)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/home'));
        }
        $model = new M_model();
        $on = 'users.id_user=teachers.user_id';
        $where =array('id_user'=>$id);
        $user['teacher'] = $model->fusionRow('users','teachers',$on,$where);

        // echo view('head');
        // echo view('nav');
        echo view('users/teachers/edit',$user);
        // echo view('footer');

    }

    public function actedit()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/home'));
        }

        $username= $this->request->getPost('username');
        $name= $this->request->getPost('name');
        $email= $this->request->getPost('email');
        $role= $this->request->getPost('role');
        $id= $this->request->getPost('id');
        $where=array('id_user'=>$id);
        $where2=array('user_id'=>$id);
        $user=array(
            'username'=>$username,
            'email'=>$email,
            'role'=>$role,
        );
        // print_r($this->request->getPost());
        $model=new M_model();
        $model->edit('users', $user, $where);

    // //Yang ditambah ke karyawan
        $teacher=array(
            'teacher_name'=>$name,
        );
        $model->edit('teachers', $teacher, $where2);
        return redirect()->to(base_url('/teachers'));
    }

    public function delete($id)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/home'));
        }
        $model=new M_model();
        $where=array('id_user'=>$id);
        $where2=array('user_id'=>$id);
        $model->hapus('teachers',$where2);
        $model->hapus('users',$where);
        return redirect()->to(base_url('/teachers'));
    }




}
