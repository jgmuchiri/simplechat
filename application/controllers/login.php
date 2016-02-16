<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
    function __construct()
    {
        parent::__construct();

    }
    function index()
    {
        $this->page("auth/login");
    }

    function page($page,$data=array()){
        $this->load->view($page,$data);
    }
    function register(){
        $this->load->view("auth/register");
    }
    function password(){
        $this->load->view("auth/password");
    }

    /*
     * login
     */
    function doLogin(){
        $this->form_validation->set_rules('email', 'Email', 'required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean');
        if($this->form_validation->run() == true) {

            $email = $this->input->post('email');
            $pass = $this->input->post('password');

            if(!$this->auth->login($email, $pass)) {
                $this->set->msg('danger','Unable to login');
            }
        }else{
            validation_errors();
            $this->set->msg('danger');
        }
        redirect('/','refresh');
    }

    /*
     * register with ajax call
     */
    function doRegister(){
        $username = urldecode($_POST['username']);
        $email = urldecode($_POST['email']);
        $pass = urldecode($_POST['pass']);
        if($this->auth->create($username,$email,$pass)){
            $this->set->msg('success','Welcome!');
            $data['success']=1;
        }else{
            $data['error'] =1;
        }
        echo json_encode($data);
    }
    /*
     * register with codeigniter validation
     */
    function doReg(){
        $this->form_validation->set_rules('email', 'Email', 'required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|trim|xss_clean');
        if($this->form_validation->run() == true) {
            $email=$this->input->post('email');
            $pass=$this->input->post('password');

            if($this->auth->create($email,$pass)){
                $this->set->msg('success','Account created!');
            }
        }

    }

    /*
     * logout
     */

    function logout(){
        $this->auth->logout();
        redirect('/','refresh');
    }

}
