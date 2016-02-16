<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Set extends CI_Model {

    /*
     * authenticate user
     *
     * @param none
     * @return bool
     */
    function auth(){
        if($this->is_login()==false){
           // $this->load->view('auth/login');
            //exit();
        }
        return false;
    }

    function is_login(){
       if($this->session->userdata('logged_in'))
            return true;
        return false;
    }

    /*
     * load a page
     * @param string
     * @param array
     */
    function page($page=null, $data=array()){
        $data['page']=$page;
        $this->load->view('home',$data);
    }


    /*
     * set information messages
     *
     * @param string
     * @param string
     * @return void
     */
    function msg($type = "", $msg = "")
    {
        switch ($type) {
            case 'danger':
                $icon = 'exclamation-sign';
                break;
            case 'success':
                $icon = 'ok';
                break;
            case 'info':
                $icon = 'info-sign';
                break;
            case 'warning':
                $icon = 'warning-sign';
                break;
            default:
                $icon = 'info-sign';
                break;
        }

        if(validation_errors() == true && $msg == "") {
            $e = validation_errors('<p class="alert alert-danger alert-dismissable"><span class="glyphicon glyphicon-warning-sign"></span>', '</p>');
            $this->session->set_flashdata('message', '<div class="msg">' . $e . '</div>');
        } else {
            $this->session->set_flashdata('message',
                '<p id="msg" class="msg alert alert-' . $type .
                ' alert-dismissable"><span class="glyphicon glyphicon-' . $icon . '"></span> ' . $msg . '</p>');
        }


    }

    /*
     * retrieve session data
     *
     * @param $string
     * @return string
     */
    function sess($item)
    {
        return $this->session->userdata($item);
    }
}
