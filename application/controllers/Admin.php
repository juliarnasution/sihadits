<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	// public	$data = array();

	public function index()
	{
		$this->load->view('admin/index');
	}

	public function cek_login()
	{
		// $this->load->model('UserModel');
		// $this->form_validation->set_rules('username', 'username', 'required|trim|xss_clean');
  //   	$this->form_validation->set_rules('password', 'password', 'required|trim|xss_clean');
	 //    if ($this->form_validation->run() == FALSE) {
	 //      $this->load->view('admin/index');
	 //    } else {
	      $usr = $this->input->post('username');
	      $psw = $this->input->post('password');
	      // $pass = password_verify($psw);
	      $cek = $this->SistemModel->login_proses($usr);
	      $data = $cek->row();
	      $verifpass = password_verify($psw,$data->password);
	      if ($verifpass==true) {
		      	$datasession= array(
		      		'id' =>$data->id,
		      		'nama'=> $data->nama,
		      		'username' => $data->username,
		      		// 'level' => $data->level,
		      		'status' => 'login'
		      	);
		      	
		      	$this->session->set_userdata($datasession);
	        // }
	//         $this->session->set_flashdata('success', 'Login Berhasil !');
	        	redirect(base_url('home/index'));
	        
	       } else {
	        $this->session->set_flashdata('result_login', '<div class="alert alert-danger alert-dismissible">
							    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							    <p><i class="icon fa fa-ban"></i>Username atau Password yang anda masukkan salah. !!!!</p>
							</div>');
	        redirect(base_url('admin/index'));
	      }
	    // }
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('admin/index'));
		
	}

	// =====================yang diatas, proses login===============================

	

}

/* End of file User.php */
/* Location: ./application/controllers/User.php */