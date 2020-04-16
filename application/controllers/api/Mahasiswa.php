<?php
use chriskacerguis\RestServer\RestController;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

class Mahasiswa extends RestController {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Mahasiswa_model', 'mahasiswa');

		// Limit Request Method Per Hour
		$this->methods['index_get']['limit'] = 10;
	}


	public function index_get()
	{
		$id = $this->get('id');

		if ($id === null) 
		{
			$mahasiswa 	= $this->mahasiswa->getData();
		}
		else
		{
			$mahasiswa 	= $this->mahasiswa->getData($id);
		}


		if ($mahasiswa) 
		{
			$this->response($mahasiswa, RestController::HTTP_OK);
		}
		else
		{
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Data mahasiswa tidak ditemukan' 
			], RestController::HTTP_NOT_FOUND);
		}
	}


	public function index_delete()
	{
		$id = $this->delete('id');

		if ($id === null) 
		{
			$this->response([
				'status' 	=> false,
				'message' 	=> 'ID mahasiswa tidak boleh kosong' 
			], RestController::HTTP_BAD_REQUEST);
		}
		else
		{
			if ($this->mahasiswa->deleteData($id) > 0) 
			{
				$this->response([
					'status' 	=> true,
					'id' 		=> $id,
					'message' 	=> 'Data mahasiswa berhasil dihapus' 
				], RestController::HTTP_OK);
			}
			else
			{
				$this->response([
					'status' 	=> false,
					'message' 	=> 'ID mahasiswa salah' 
				], RestController::HTTP_BAD_REQUEST);
			}
		}
	}


	public function index_post()
	{
		$data = $this->input->post();

		if ($this->mahasiswa->createData($data) > 0) 
		{
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Data mahasiswa berhasil ditambahkan' 
			], RestController::HTTP_CREATED);
		}
		else
		{
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Data mahasiswa gagal ditambahkan' 
			], RestController::HTTP_NOT_MODIFIED);
		}
	}


	public function index_put()
	{
		$id 	= $this->put('id');
		$data 	= $this->put();

		if ($this->mahasiswa->updateData($data, $id) > 0) 
		{
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Data mahasiswa berhasil diupdate' 
			], RestController::HTTP_OK);
		}
		else
		{
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Data mahasiswa gagal diupdate' 
			], RestController::HTTP_NOT_MODIFIED);
		}
	}
}