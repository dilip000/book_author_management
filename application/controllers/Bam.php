<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bam extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('bam_model');
	}

	function index()
	{
		$this->load->view('bam_table');
	}

	function load_data()
	{
		$data = $this->bam_model->load_data();
		echo json_encode($data);
	}

	function insert()
	{
		$data = array(
			'author_name'	=> $this->input->post('author_name'),
			'book_name'		=>	$this->input->post('book_name')
		);

		$this->bam_model->insert($data);
	}

	function update()
	{
		$data = array(
			$this->input->post('table_column')	=>	$this->input->post('value')
		);

		$this->bam_model->update($data, $this->input->post('id'));
	}

	function delete()
	{
		$this->bam_model->delete($this->input->post('id'));
	}

	function search()
	{
		$data=$this->bam_model->search($this->input->post('search_keyword'));
		echo json_encode($data);

	}
	

}
