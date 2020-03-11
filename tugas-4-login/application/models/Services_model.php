<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Services_model extends CI_Model
{
	private $_table = "services";
	public $product_id, $name, $price, $image = "default.jpg", $description;

	public function rules()
	{
		return [
			[
				"field" => "name",
				"label" => "Name",
				"rules" => "required"
			],
			[
				"field" => "price",
				"label" => "Price",
				"rules" => "numeric"
			],
			[
				"field" => "description",
				"label" => "Description",
				"rules" => "required"
			]
		];
	}

	public function get_all()
	{
		return $this->db->get($this->_table)->result();
	}

	public function get_by_id($id)
	{
		return $this->db->get_where($this->_table, ["service_id" => $id])->row();
	}

	public function save()
	{
		$post = $this->input->post();
		$this->service_id = uniqid();
		$this->name = $post["name"];
		$this->price = $post["price"];
		$this->description = $post["description"];
		return $this->db->insert($this->_table, $this);
	}

	public function update()
	{
		$post = $this->input->post();
		$this->service_id = $post["id"];
		$this->name = $post["name"];
		$this->price = $post["price"];
		$this->description = $post["description"];
		return $this->db->update($this->_table, $this, ["service_id" => $post["id"]]);
	}

	public function delete($id)
	{
		return $this->db->delete($this->_table, ["service_id" => $id]);
	}
	
}
