<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("user_model");
		$this->load->library("form_validation");
	}

	public function index()
	{
		if ($this->input->post())
		{
			if ($this->user_model->do_login())
				redirect(site_url("admin"));
		}
		$this->load->view("admin/login_page.php");
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(site_url("admin/login"));
	}
}