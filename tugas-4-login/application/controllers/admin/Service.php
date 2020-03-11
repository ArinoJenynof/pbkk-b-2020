<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Service extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Services_model");
		$this->load->library("form_validation");
		$this->load->model("user_model");
		if ($this->user_model->is_not_login())
			redirect(site_url("admin/login"));
	}

	public function index()
	{
		$data["services"] = $this->Services_model->get_all();
		$this->load->view("services/list", $data);
	}

	public function add()
	{
		$service = $this->Services_model;
		$validation = $this->form_validation;
		$validation->set_rules($service->rules());

		if ($validation->run())
		{
			$service->save();
			$this->session->set_flashdata("success", "Berhasil disimpan");
		}

		$this->load->view("services/new-form");
	}

	public function edit($id = null)
	{
		if (!isset($id))
			redirect("services");

			$service = $this->Services_model;
			$validation = $this->form_validation;
			$validation->set_rules($service->rules());
	
			if ($validation->run())
			{
				$service->update();
				$this->session->set_flashdata("success", "Berhasil diperbarui");
			}

			$data["service"] = $service->get_by_id($id);
			if (!$data["service"])
				show_404();
	
			$this->load->view("services/edit-form", $data);
	}

	public function delete($id = null)
	{
		if (!isset($id))
			show_404();

		if ($this->Services_model->delete($id))
		{
			redirect(site_url("services"));
		}
	}
}