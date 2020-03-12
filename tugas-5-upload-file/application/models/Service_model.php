<?php defined('BASEPATH') or exit('No direct script access allowed');

class Service_model extends CI_Model
{
	private $_table = "services";

	public $service_id;
	public $name;
	public $price;
	public $image = "default.jpg";
	public $description;

	public function rules()
	{
		return [
			[
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'required'
			],

			[
				'field' => 'price',
				'label' => 'Price',
				'rules' => 'numeric'
			],

			[
				'field' => 'description',
				'label' => 'Description',
				'rules' => 'required'
			]
		];
	}

	public function getAll()
	{
		return $this->db->get($this->_table)->result();
	}

	public function getById($id)
	{
		return $this->db->get_where($this->_table, ["service_id" => $id])->row();
	}

	public function save()
	{
		$post = $this->input->post();
		$this->service_id = uniqid();
		$this->name = $post["name"];
		$this->price = $post["price"];
		$this->image = $this->_uploadImage();
		$this->description = $post["description"];
		$this->db->insert($this->_table, $this);
	}

	public function update()
	{
		$post = $this->input->post();
		$this->service_id = $post["id"];
		$this->name = $post["name"];
		$this->price = $post["price"];


		if (!empty($_FILES["image"]["name"])) {
			$this->image = $this->_uploadImage();
		} else {
			$this->image = $post["old_image"];
		}

		$this->description = $post["description"];
		$this->db->update($this->_table, $this, array('service_id' => $post['id']));
	}

	public function delete($id)
	{
		$this->_deleteImage($id);
		return $this->db->delete($this->_table, array("service_id" => $id));
	}

	private function _uploadImage()
	{
		$config['upload_path']          = './upload/service/';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['file_name']            = $this->service_id;
		$config['overwrite']			= true;
		$config['max_size']             = 1024; // 1MB
		// $config['max_width']            = 1024;
		// $config['max_height']           = 768;

		$this->load->library('upload', $config);

		if ($this->upload->do_upload('image')) {
			return $this->upload->data("file_name");
		}

		return "default.jpg";
	}

	private function _deleteImage($id)
	{
		$service = $this->getById($id);
		if ($service->image != "default.jpg") {
			$filename = explode(".", $service->image)[0];
			return array_map('unlink', glob(FCPATH . "upload/service/$filename.*"));
		}
	}
}
