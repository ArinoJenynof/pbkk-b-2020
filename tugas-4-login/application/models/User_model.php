<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class User_model extends CI_Model
{
	private $_table = "users";

	public function do_login()
	{
		$post = $this->input->post();
		$this->db->where("email", $post["email"])->or_where("username", $post["email"]);
		$user = $this->db->get($this->_table)->row();

		if ($user)
		{
			$is_pw_true = password_verify($post["password"], $user->password);
			$is_admin = $user->role == "admin";
			if ($is_pw_true && $is_admin)
			{
				$this->session->set_userdata(["user_logged" => $user]);
				$this->_updateLastLogin($user->user_id);
				return true;
			}
		}
		return false;
	}

	public function is_not_login()
	{
		return $this->session->userdata("user_logged") === null;
	}

	public function _updateLastLogin($user_id)
	{
		$sql = "UPDATE {$this->_table} SET last_login = now() WHERE user_id = {$user_id}";
		$this->db->query($sql);
	}
}