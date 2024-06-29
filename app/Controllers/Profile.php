<?php

namespace App\Controllers;

use App\Models\M_model;
use CodeIgniter\Controller;


class Profile extends BaseController
{

    protected function checkAuth()
    {
        $id_user = session()->get('id_user');
        $role = session()->get('role');
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
        $role = session()->get('role');
        if($role == 'student'){
            $on = 'users.id_user=students.user_id';
            $where =array('id_user'=> session()->get('id_user'));
            $user['user'] = $model->fusionRow('users','students',$on,$where);
        }elseif($role != 'student') {
            $on = 'users.id_user=teachers.user_id';
            $where =array('id_user'=> session()->get('id_user'));
            $user['user'] = $model->fusionRow('users','teachers',$on,$where);
        }

        echo view('users/profile',$user);

    }

    public function password()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/home'));
        }

        echo view('users/password');

    }

    public function actprofile()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/home'));
        }
        $id = session()->get('id_user');
        $username= $this->request->getPost('username');
        $email= $this->request->getPost('email');
        $where=array('id_user'=>$id);
        $where2=array('user_id'=>$id);
        if (session()->get('role') == 'student'){
            $user=array(
                'email'=>$email,
            );
        }else{
            $user=array(
                'username'=>$username,
                'email'=>$email,
            );
        }
        // print_r($this->request->getPost());
        $model=new M_model();
        $model->edit('users', $user, $where);

        if (session()->get('role') == 'student'){
            $student=array(
                'student_name'=>$username,
            );
            $model->edit('students', $student, $where2);
        }
        return redirect()->to(base_url('/home/Logout'));
    }

    public function actpassword()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/home'));
        }

        $id = session()->get('id_user');
        $password= $this->request->getPost('password');
        $confirm= $this->request->getPost('password_confirmation');
        $where=array('id_user'=>$id);
        $where2=array('user_id'=>$id);
        if($password === $confirm) {
            $pass = md5($password);
            $user=array(
                'password'=> $pass
            );
        // print_r($this->request->getPost());
            $model=new M_model();
            $model->edit('users', $user, $where);
        }else{
// Load the session library
            $session = session();

// Set the error message
            $session->setFlashdata('error', 'password does not match');

            return redirect()->back()->withInput();

        }


        return redirect()->to(base_url('/home/Logout'));
    }




}
