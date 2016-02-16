<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File: users.php
 * User: jgmuchiri
 * Date: 12/25/2014
 * 
 * http://icoolpix.com
 * info@icoolpix.com
 * Copyright 2014 All Rights Reserved
 */
class users extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->set->auth(); //authenticate
    }

    function index(){
        $data['users']=$this->db->get('users')->result();
        $this->load->view('auth/users',$data);
    }

    /*
     * display password change form
     */
    function password(){
        $this->load->view("auth/change_password");
    }

    /*
     * submit change password data
     */
    function changePassword(){
        $this->form_validation->set_rules('password', 'Password', 'xss_clean|trim');
        if($this->form_validation->run() == true) {
            $email=$this->input->post('email');
            $pass=$this->input->post('password');

            if($this->auth->create($email,$pass)){
                $this->set->msg('success','Account created!');
            }
        }
    }


}