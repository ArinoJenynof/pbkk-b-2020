<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Services extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("service_model");
		$this->load->library('form_validation');
		$this->load->model("user_model");
		if ($this->user_model->isNotLogin()) redirect(site_url('admin/login'));
	}

	public function index()
	{
		$data["services"] = $this->service_model->getAll();
		$this->load->view("admin/service/list", $data);
	}

	public function add()
	{
		$service = $this->service_model;
		$validation = $this->form_validation;
		$validation->set_rules($service->rules());

		if ($validation->run()) {
			$service->save();
			$this->session->set_flashdata('success', 'Berhasil disimpan');
		}

		$this->load->view("admin/service/new_form");
	}

	public function edit($id = null)
	{
		if (!isset($id)) redirect('admin/services');

		$service = $this->service_model;
		$validation = $this->form_validation;
		$validation->set_rules($service->rules());

		if ($validation->run()) {
			$service->update();
			$this->session->set_flashdata('success', 'Berhasil disimpan');
		}

		$data["service"] = $service->getById($id);
		if (!$data["service"]) show_404();

		$this->load->view("admin/service/edit_form", $data);
	}

	public function delete($id = null)
	{
		if (!isset($id)) show_404();

		if ($this->service_model->delete($id)) {
			redirect(site_url('admin/services'));
		}
	}
}
