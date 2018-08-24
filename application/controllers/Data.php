<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {

	public function __construct() {
		parent::__construct();
        if ($this->session->userdata('status')!='login') {
			redirect(base_url('Admin/index'));
		}
    }

	public function stemming()
	{
		$data['data'] = $this->SistemModel->all_data("daftar_stemming","id_stemming","ASC");
		$this->load->view('template/header');
		$this->load->view('data/stemming',$data);
		$this->load->view('template/footer');
	}

	public function stopword()
	{
		$data['data'] = $this->SistemModel->all_data("daftar_stopword","","ASC");
		$this->load->view('template/header');
		$this->load->view('data/stopword',$data);
		$this->load->view('template/footer');
	}

	// public function hapusstemming()
	// {
	// 	# code...
	// }

}

/* End of file Data.php */
/* Location: ./application/controllers/Data.php */