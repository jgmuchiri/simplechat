<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File: my_user.php
 * User: jgmuchiri
 * Date: 12/26/2014
 * 
 * http://icoolpix.com
 * info@icoolpix.com
 * Copyright 2014 All Rights Reserved
 */
class my_user extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	/*
	 * enter invitation to db
	 *
	 * @param string
	 * @param int
	 * @return bool
	 */
	function sendInvite($email){
		$code =rand(100000,999999);

		$data=array(
			'email'=>$email,
			'code'=>$code,
			'sender'=>$this->set->sess('user_id'),
			'sent_data'=>time(),
			'has_response'=>0
		);
		if($this->db->insert('invites',$data))//data was entered in db
			if($this->sendInviteEmail($email,$code)) //email was send successfully
				return true;

		return false;
	}

	/*
	 * register inviter as friend
	 *
	 * @param string
	 * @param string
	 * @return bool
	 */
	function acceptInvite($code){
		$this->db->where('code',$code);
		$query = $this->db->get_where('invites');

		if($query->num_rows()>0){//code exists
			foreach($query->result() as $row){ //register user and add to friends
				$data = array(
					'friend_id'=>$row->sender,
					'user_id'=>$this->set->sess('user_id')
				);
				if($this->db->insert('friends',$data)) //user has been added as friend
					return true;
			}
		}
		return false;
	}

	/*
	 * send invite email
	 *
	 * @param string
	 * @param string
	 * @return bool
	 */
	function sendInviteEmail($email,$code){
		return true;
	}

}