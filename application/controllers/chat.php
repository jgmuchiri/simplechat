<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * File: chat.php
 * User: jgmuchiri
 * Date: 10/22/14
 *
 * http://icoolpix.com
 * info@icoolpix.com
 * Copyright 2014 All Rights Reserved
 */

class Chat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('auth');
        $this->load->model('my_user','user');

        $this->set->auth();
    }

    function index()
    {
        $this->load->view('home');

    }
    function landing(){
        $this->load->view('chat/landing');
    }
    function chatBox(){
        $this->load->view('chat/chatbox');
    }
    //todo display single conversation
    function chatWithUser(){

    }
    //todo list all users for this account
    function listUsers(){

    }
    //todo list online users
    function onlineUsers(){

    }
    //todo
    function settings(){
        $this->load->view('chat/settings');
    }
    //todo
    function logout(){
        redirect('/','refresh');
    }

    //todo purge chat
    function purge(){

    }

    /*
     * accept invite
     */
    function acceptInvite(){
        $code = urldecode($_POST['code']);

        if($this->user->acceptInvite($code)){
            $data['success']=1;
        }else{
            $data['error'] =1;
        }
        echo json_encode($data);
    }

    /*
     * send invite
     */
    function sendInvite(){
        $email = urldecode($_POST['email']);

        if($this->user->sendInvite($email)){
            $data['success']=1;
        }else{
            $data['error'] =1;
        }
        echo json_encode($data);
    }

}
