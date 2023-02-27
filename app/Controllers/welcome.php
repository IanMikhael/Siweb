<?php
defined('BASEPATH') OR exit('No direct script acces allowed');

class welcome extends contr
{
    public function index()
    {
        $this->load->view('welcome_message');
    }

    public function about ()
    {
        $this->load->view('about.php');
    }

    public function contact()
    {
        $this->load->view('contact.php');
    }  

}