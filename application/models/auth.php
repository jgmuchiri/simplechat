<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File: auth.php
 * User: jgmuchiri
 * Date: 12/25/2014
 *
 * http://icoolpix.com
 * info@icoolpix.com
 * Copyright 2014 All Rights Reserved
 */
/*
 *
// create a new user
$this->auth->create('user@example.com', 'uS$rpass!');

// login
if($this->auth->login('user@example.com', 'uS$rpass!')) {
    // success
}

// check if logged in
if($this->session->userdata('logged_in')) {
    // logged in
}

// logout
$this->auth->logout();

// delete by user ID
$this->auth->delete($user_id);

// Update user Email
$this->auth->update($user_id, $user_email, $auto_login);

// Update Password
$this->auth->edit_password($user_email, $old_pass, $new_pass)
 */

require_once(APPPATH.'libraries/phpass-0.3/PasswordHash.php');

define('PHPASS_HASH_STRENGTH', 8);
define('PHPASS_HASH_PORTABLE', false);

class Auth extends CI_Model
{
    var $user_table = 'users';

    /**
     * Create a user account
     *
     * @access	public
     * @param	string
     * @param	string
     * @param	bool
     * @return	bool
     */
    function create($username='',$user_email = '', $user_pass = '', $auto_login = true)
    {
        //Make sure account info was sent
        if($username=='' OR $user_email == '' OR $user_pass == '') {
            return false;
        }

        //Check against user table
        $this->db->where('user_email', $user_email);
        $query = $this->db->get_where($this->user_table);

        if ($query->num_rows() > 0) //user_email already exists
            return false;

        $this->db->where('username',$username);
        if($this->db->get_where($this->user_table)->num_rows > 0)
            return false;

        //Hash user_pass using phpass
        $hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
        $user_pass_hashed = $hasher->HashPassword($user_pass);

        //Insert account into the database
        $data = array(
            'username'=>$username,
            'user_email' => $user_email,
            'user_pass' => $user_pass_hashed,
            'user_date' => date('c'),
            'user_modified' => date('c'),
        );

        $this->db->set($data);

        if(!$this->db->insert($this->user_table)) //There was a problem!
            return false;

        if($auto_login)
            $this->login($user_email, $user_pass);

        return true;
    }

    /**
     * Update a user account
     *
     * Only updates the email, just here for you can
     * extend / use it in your own class.
     *
     * @access	public
     * @param integer
     * @param	string
     * @param	bool
     * @return	bool
     */
    function update($user_id = null, $user_email = '', $auto_login = true)
    {
        //Make sure account info was sent
        if($user_id == null OR $user_email == '') {
            return false;
        }

        //Check against user table
        $this->db->where('user_id', $user_id);
        $query = $this->db->get_where($this->user_table);

        if ($query->num_rows() == 0){ // user don't exists
            return false;
        }

        //Update account into the database
        $data = array(
            'user_email' => $user_email,
            'user_modified' => date('c'),
        );

        $this->db->where('user_id', $user_id);

        if(!$this->db->update($this->user_table, $data)) //There was a problem!
            return false;

        if($auto_login){
            $user_data['user_email'] = $user_email;
            $user_data['user'] = $user_data['user_email']; // for compatibility with Simplelogin

            $this->session->set_userdata($user_data);
        }
        return true;
    }

    /**
     * Login and sets session variables
     *
     * @access	public
     * @param	string
     * @param	string
     * @return	bool
     */
    function login($user_email = '', $user_pass = '')
    {

        if($user_email == '' OR $user_pass == '')
            return false;


        //Check if already logged in
        if($this->session->userdata('user_email') == $user_email)
            return true;


        //Check against user table
        $this->db->where('user_email', $user_email);
        $query = $this->db->get_where($this->user_table);


        if ($query->num_rows() > 0)
        {
            $user_data = $query->row_array();

            $hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);

            if(!$hasher->CheckPassword($user_pass, $user_data['user_pass']))
                return false;

            //Destroy old session
            $this->session->sess_destroy();

            //Create a fresh, brand new session
            $this->session->sess_create();

            $this->db->simple_query('UPDATE ' . $this->user_table  . ' SET user_last_login = "' . date('c') . '" WHERE user_id = ' . $user_data['user_id']);

            //Set session data
            unset($user_data['user_pass']);
            $user_data['user'] = $user_data['user_email']; // for compatibility with Simplelogin
            $user_data['logged_in'] = true;
            $this->session->set_userdata($user_data);

            return true;
        }
        else
        {
            return false;
        }

    }

    /**
     * Logout user
     *
     * @access	public
     * @return	void
     */
    function logout() {

        $this->session->sess_destroy();
    }

    /**
     * Delete user
     *
     * @access	public
     * @param integer
     * @return	bool
     */
    function delete($user_id)
    {

        if(!is_numeric($user_id))
            return false;

        return $this->db->delete($this->user_table, array('user_id' => $user_id));
    }


    /**
     * Edit a user password
     * @author    Stéphane Bourzeix, Pixelmio <stephane[at]bourzeix.com>
     * @author    Diego Castro <castroc.diego[at]gmail.com>
     *
     * @access  public
     * @param  string
     * @param  string
     * @param  string
     * @return  bool
     */
    function edit_password($user_email = '', $old_pass = '', $new_pass = '')
    {
        // Check if the password is the same as the old one
        $this->db->select('user_pass');
        $query = $this->db->get_where($this->user_table, array('user_email' => $user_email));
        $user_data = $query->row_array();

        $hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
        if (!$hasher->CheckPassword($old_pass, $user_data['user_pass'])){ //old_pass is the same
            return FALSE;
        }

        // Hash new_pass using phpass
        $user_pass_hashed = $hasher->HashPassword($new_pass);
        // Insert new password into the database
        $data = array(
            'user_pass' => $user_pass_hashed,
            'user_modified' => date('c')
        );

        $this->db->set($data);
        $this->db->where('user_email', $user_email);
        if(!$this->db->update($this->user_table, $data)){ // There was a problem!
            return FALSE;
        } else {
            return TRUE;
        }
    }

}