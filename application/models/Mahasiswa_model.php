<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa_model extends CI_Model {

	public function getData($id = null)
	{
		if ($id === NULL) 
		{
			return $this->db->get('mahasiswa')->result();
		}
		else
		{
			return $this->db->get_where('mahasiswa', compact('id'))->result();
		}
	}


	public function deleteData($id)
	{
		$this->db->delete('mahasiswa', compact('id'));
		return $this->db->affected_rows();
	}


	public function createData($data)
	{
		$this->db->insert('mahasiswa', $data);
		return $this->db->affected_rows();
	}


	public function updateData($data, $id)
	{
		$this->db->update('mahasiswa', $data, compact('id'));
		return $this->db->affected_rows();
	}
}