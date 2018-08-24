<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bukhari extends CI_Controller {

	public $CI = NULL;

    public function __construct() {
        parent::__construct();
        // $this->CI = & get_instance();
        if ($this->session->userdata('status')!='login') {
			redirect(base_url('Admin/index'));
		}
    }

	public function index()
	{
		$data['query'] = $this->SistemModel->all_data("bukhari","No","ASC");
		$data['data'] = $this->atur_data($data['query']);
		// echo "<pre>";
		// print_r ($data['data']);
		// echo "</pre>";
		// var_dump ($data['data']);
		// die();
		$this->load->view('template/header');
		$this->load->view('bukhari/index',$data);
		$this->load->view('template/footer');
	}

	public function profil()
	{
		$data['data'] = $this->SistemModel->ambildata("bio_bukhari",array('id'=>1));
		$this->load->view('template/header');
		$this->load->view('bukhari/profil',$data);
		$this->load->view('template/footer');
	}

	public function view()
	{
		$id = $this->uri->segment(3);
		$where = array('No'=>$id);
		$data['data'] = $this->SistemModel->ambildata('bukhari',$where);
		$this->load->view('template/header');
		if (!empty($data['data'])) {
			$this->load->view('bukhari/view',$data);
		} else {
			$this->load->view('template/kosong');
		}
		
		// $this->load->view('bukhari/view',$data);
		$this->load->view('template/footer');
	}

	public function editprofil()
	{
		$data['data'] = $this->SistemModel->ambildata("bio_bukhari",array('id'=>1));
		$this->load->view('template/header');
		$this->load->view('bukhari/edit',$data);
		$this->load->view('template/footer');
	}

	public function updateprofil()
	{
		$query = false;
		$data = array('biografi'=>$this->input->post('profil'));
		$jml_data = $this->SistemModel->query_umum("SELECT * FROM bio_bukhari")->num_rows();
		// $jml_data = $this->SistemModel->jumlah_data("bio_bukhari");//menghitung jumlah data dalam database
		// var_dump ($jml_data);
		// die();
		if ($jml_data>0) {
			$query = $this->SistemModel->prosesedit('bio_bukhari',$data,array("id"=>1));
		}else{
			$query = $this->SistemModel->tambah_data('bio_bukhari',$data);
		}

		if ($query==true) {
			$this->session->set_flashdata('notif', notifikasi(TRUE));
			redirect('bukhari/profil','refresh');
		} else {
			$this->session->set_flashdata('notif', notifikasi(FALSE));
			redirect('bukhari/edit','refresh');
		}
	}

	// public function cek_data($tabel)
	// {
	// 	$query= $this->SistemModel->query_umum($tabel);
	// 	return $query->num_rows();
	// }
	
	public function atur_data($data=array())
	{
		foreach ($data as $value) {
			$datanya[] = array($value->No,$value->Kitab,$value->Arab,$this->batas_teks($value->Terjemah));
		}

		return $datanya;
	}
	public function batas_teks($teks, $panjang=200)
	{
	  if(strlen($teks)<=$panjang){
	    return $teks;
	  }
	  else{
	    $singkat=substr($teks,0,$panjang) . '...';
	    return $singkat;
	  }
	}

	public function tambah()
	{
		$this->load->view('template/header');
		$this->load->view('bukhari/tambah');
		$this->load->view('template/footer');
	}

	public function edit()
	{
		$where = array('No'=>$this->uri->segment(3));
		$data['data'] = $this->SistemModel->ambildata("bukhari",$where);
		$this->load->view('template/header');
		$this->load->view('bukhari/edit_hadits',$data);
		$this->load->view('template/footer');
	}

	public function tambah_hadits()
	{

		// var_dump ($this->input->post('terjemahan'));
		// die();
		$this->form_validation->set_rules('nomor','nomor', 'trim|required|xss_clean|is_unique[bukhari.No]',
			array(
                'is_unique'     => '<i class="fa fa-times-circle"></i> Nomor Hadits telah ada...!!!'
	        )
		);

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('notif', 
				'<div class="alert alert-warning alert-dismissible">
			    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			    <h4><i class="icon fa fa-warning"></i> Peringatan !</h4>'.form_error("nomor").'
			</div>'
			);	
			
			redirect('bukhari/tambah');	
		}
		$data = array(
			"No"=>$this->input->post('nomor'),
			"Kitab"=>$this->input->post('kitab'),
			"Arab"=>$this->input->post('arab'),
			"Terjemah"=>$this->input->post('terjemahan')
		);

		$input = $this->SistemModel->tambah_data('bukhari',$data);
		if ($input==true) {
			$this->session->set_flashdata('notif', notifikasi(TRUE));
		} else {
			$this->session->set_flashdata('notif', notifikasi(FALSE));
		}

		redirect('bukhari/index','refresh');
	}

	public function edit_hadits()
	{
		$no = $this->uri->segment(3);
		$where = array('No'=>$no);
		$data = array(
			// "No"=>$this->input->post('nomor'),
			"Kitab"=>$this->input->post('kitab'),
			"Arab"=>$this->input->post('arab'),
			"Terjemah"=>$this->input->post('terjemahan')
		);

		$update = $this->SistemModel->prosesedit('bukhari',$data,$where);
		if ($update) {
			$this->session->set_flashdata('notif', notifikasi(TRUE));
			redirect('bukhari/index','refresh');
		} else {
			$this->session->set_flashdata('notif', notifikasi(FALSE));
			redirect('bukhari/edit/'.$no,'refresh');
		}

		
	}

	public function hapus_hadits()
	{
		$no = $this->uri->segment(3);
		$where = array('No'=>$no);		
		$hapus = $this->SistemModel->hapus('bukhari',$where);
		if ($hapus) {
			$this->session->set_flashdata('notif', notifikasi(TRUE));
		}else{
			$this->session->set_flashdata('notif', notifikasi(FALSE));
		}
		redirect('bukhari/index','refresh');
	}

}

/* End of file Bukhari.php */
/* Location: ./application/controllers/Bukhari.php */