<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use CodeIgniter\I18n\Time;

class Auth extends Controller
{
    private $session;
    public function __construct()
    {
        $this->session = \Config\Services::session();
    }
    public function indexregister()
    {
        helper(['form']);
        $data = [];

        return view('auth/register', $data);
    }


    public function saveRegister()
    {
    helper(['form']);
    //set rules validation form
    $rules = [
        'username'     => 'required|min_length[3]|max_length[20]',
        'email'        => 'required|min_length[6]|max_length[50]|valid_email|is_unique[pengguna.user_email]',
        'password'     => 'required|min_length[6]|max_length[200]',
        'pass_confirm' => 'matches[password]'
    ];
    // dd($rules);
    // $validation = \Config\Services::validation();

    if ($this->validate($rules)) 
    {
        $model = new UserModel();
        $data  =
        [
            'user_name'       => $this->request->getVar('username'),
            'user_email'      => $this->request->getVar('email'),
            'user_password'   => password_hash($this->request->getVar('password'),PASSWORD_DEFAULT),
            'user_created_at' => Time::now('America/Chicago', 'en_US'),
        ];
        $model->save($data);
        return redirect()->to('/login');
    } else {
        $data['validation'] = $this->validator;
        echo view('auth/register', $data);
    }
    
    }
   
    
   public function auth()
   {
        // $session = session();
        $model   = new UserModel();
        $email   = $this->request->getVar('email');
        // $username = $this->request->getVar('email');
        // dd($email);
        $password = $this->request->getVar('password');
        $data = $model->where('user_email', $email)->orwhere('user_name', $email)->first();
        // ($data);
        if($data)
        {
            $pass = $data['user_password'];
            $verify_pass = password_verify($password, $pass);
            if ($verify_pass)
            {
                $ses_data =
                [
                    'user_id'   => $data['id'],
                    'user_name' => $data['user_name'],
                    'user_email'=> $data['user_email'],
                    'role'      => $data['role'],
                    'logged_in' => TRUE
                ];
                $this->session->set($ses_data);
                //print_r($this->session);exit;
                return redirect()->to('/');
            } else {
                $this->session->setFlashdata('msg', 'Password Anda Salah');
                return redirect()->to('/login')->withInput();
            }
        } else {
            $this->session->setFlashdata('msg', 'Email atau Username Tidak ada');
            return redirect()->to('/login')->withInput();
        }
   } 

   public function indexlogin()
   {
       helper(['form']);
         if (session()->get('isLoggedIn'))
          {
        return redirect()->to('home');
         }
       echo view('auth/login');
    }

   public function logout()
   {
        // $this->session = session();
        //var_dump($this->session);exit;
        // session_destroy();
        
        $this->session->destroy();
        return redirect()->to('/login');
   }



}
