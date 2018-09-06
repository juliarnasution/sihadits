<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Muslim extends CI_Controller {

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
		$data['query'] = $this->SistemModel->all_data("muslim","No","ASC");
		$data['data'] = $this->atur_data($data['query']);
		// echo "<pre>";
		// print_r ($data['data']);
		// echo "</pre>";
		// // var_dump ($data['data']);
		// die();
		$this->load->view('template/header');
		$this->load->view('muslim/index',$data);
		$this->load->view('template/footer');
	}

	public function profil()
	{
		$data['data'] = $this->SistemModel->ambildata("bio_muslim",array('id'=>1));
		$this->load->view('template/header');
		$this->load->view('muslim/profil',$data);
		$this->load->view('template/footer');
	}

	public function view()
	{
		$id = $this->uri->segment(3);
		$where = array('No'=>$id);
		$data['data'] = $this->SistemModel->ambildata('muslim',$where);
		$this->load->view('template/header');
		if (!empty($data['data'])) {
			$this->load->view('muslim/view',$data);
		} else {
			$this->load->view('template/kosong');
		}
		
		$this->load->view('template/footer');
	}

	public function editprofil()
	{
		$data['data'] = $this->SistemModel->ambildata("bio_muslim",array('id'=>1));
		$this->load->view('template/header');
		$this->load->view('muslim/edit',$data);
		$this->load->view('template/footer');
	}

	public function tambah()
	{
		$this->load->view('template/header');
		$this->load->view('muslim/tambah');
		$this->load->view('template/footer');
	}

	public function edit()
	{
		$where = array('No'=>$this->uri->segment(3));
		$data['data'] = $this->SistemModel->ambildata("muslim",$where);
		$this->load->view('template/header');
		$this->load->view('muslim/edit_hadits',$data);
		$this->load->view('template/footer');
	}

	public function tambah_hadits()
	{

		// var_dump ($this->input->post('terjemahan'));
		// die();
		$this->form_validation->set_rules('nomor','nomor', 'trim|required|xss_clean|is_unique[muslim.No]',
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
			
			redirect('muslim/tambah');	
		}
		$data = array(
			"No"=>$this->input->post('nomor'),
			"Kitab"=>$this->input->post('kitab'),
			"Arab"=>$this->input->post('arab'),
			"Terjemah"=>$this->input->post('terjemahan')
		);

		$input = $this->SistemModel->tambah_data('muslim',$data);
		if ($input==true) {
			$this->session->set_flashdata('notif', notifikasi(TRUE));
		} else {
			$this->session->set_flashdata('notif', notifikasi(FALSE));
		}

		redirect('muslim/index','refresh');
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

		$update = $this->SistemModel->prosesedit('muslim',$data,$where);
		if ($update) {
			$this->session->set_flashdata('notif', notifikasi(TRUE));
			redirect('muslim/index','refresh');
		} else {
			$this->session->set_flashdata('notif', notifikasi(FALSE));
			redirect('muslim/edit/'.$no,'refresh');
		}

		
	}

	public function updateprofil()
	{
		$query = false;
		$data = array('biografi'=>$this->input->post('profil'));
		$jml_data = $this->SistemModel->query_umum("SELECT * FROM bio_muslim")->num_rows();
		// $jml_data = $this->SistemModel->jumlah_data("bio_bukhari");//menghitung jumlah data dalam database
		// var_dump ($jml_data);
		// die();
		if ($jml_data>0) {
			$query = $this->SistemModel->prosesedit('bio_muslim',$data,array("id"=>1));
		}else{
			$query = $this->SistemModel->tambah_data('bio_muslim',$data);
		}

		if ($query==true) {
			$this->session->set_flashdata('notif', notifikasi(TRUE));
			redirect('muslim/profil','refresh');
		} else {
			$this->session->set_flashdata('notif', notifikasi(FALSE));
			redirect('muslim/edit','refresh');
		}
	}

	// public function field_unique($nomor, $data,$field)
	// {
	// 	$query 	= "SELECT * FROM jabatans WHERE No != '$nomor' AND $field='$data'";
	// 	$cek	= $this->SistemModel->query_umum($query);
	// 	$hasil 	= $cek->num_rows();
	// 	if ($hasil>=1) {
	// 		return true;
	// 	} else {
	// 		return false;
	// 	}
		
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

	public function hapus_hadits()
	{
		$no = $this->uri->segment(3);
		$where = array('No'=>$no);		
		$hapus = $this->SistemModel->hapus('muslim',$where);
		if ($hapus) {
			$this->session->set_flashdata('notif', notifikasi(TRUE));
		}else{
			$this->session->set_flashdata('notif', notifikasi(FALSE));
		}
		redirect('muslim/index','refresh');
	}

	
}

/* End of file Muslim.php */
/* Location: ./application/controllers/Muslim.php */