<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct() {
		parent::__construct();
        if ($this->session->userdata('status')!='login') {
			redirect(base_url('Admin/index'));
		}
    }

	public function index()
	{	
		$data['data'] = $this->SistemModel->all_data("users");
		$this->load->view('template/header');
		$this->load->view('admin/user',$data);
		$this->load->view('template/footer');
	}

	public function edit_user()
	{	$where = array('id'=>$this->uri->segment(3));
		$data['data'] = $this->SistemModel->ambildata("users",$where);
		$this->load->view('template/header');
		$this->load->view('admin/edit_user',$data);
		$this->load->view('template/footer');
	}

	public function profil()
	{
		$where = array('id'=>$this->session->userdata('id'));
		$data['data'] = $this->SistemModel->ambildata('users',$where);
		$this->load->view('template/header');
		$this->load->view('admin/profil',$data);
		$this->load->view('template/footer');
	}

	public function password()
	{
		$this->load->view('template/header');
		$this->load->view('admin/password');
		$this->load->view('template/footer');
	}

	public function update_password()
	{
		$id = $this->session->userdata('id');
		$where = array('id'=>$id);
		$data = array(
    		'password' => password_hash($this->input->post('password'),PASSWORD_BCRYPT)
    	);

		$update = $this->SistemModel->prosesedit('users',$data,$where);
		if ($update) {
			$this->session->set_flashdata('notif', notifikasi(TRUE));
		}else{
			$this->session->set_flashdata('notif', notifikasi(FALSE));
		}
		redirect('user/password');
	}

	public function update_profil()
	{
		$id = $this->session->userdata('id');
		$where = array('id'=>$id);
		$query = "SELECT username FROM users WHERE id != '$id' ";
		$hasil = $this->SistemModel->query_umum($query)->result();
		$array = $this->username_array($hasil);
		$username = $this->input->post('username');

		if (in_array($username, $array)) {
			$this->session->set_flashdata('notif', 
				'<div class="alert alert-warning alert-dismissible">
				    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				    <h4><i class="icon fa fa-warning"></i> Peringatan !</h4> Username telah digunakan...!!!
				</div>'
			);	
			redirect('user/profil');
		}
		$data = array(
    		'nama' => $this->input->post('nama'),
    		'username' => $username
    	);

		$update = $this->SistemModel->prosesedit('users',$data,$where);
		// echo "<pre>";
  //   	print_r ($update);
  //   	echo "</pre>";
  //   	die();

		if ($update) {
			$this->session->set_userdata($data);
			$this->session->set_flashdata('notif', notifikasi(TRUE));
		}else{
			$this->session->set_flashdata('notif', notifikasi(FALSE));
		}
		redirect('user/profil');
	}

	public function tambahuser()
	{
		$data = array(
			'nama'=>$this->input->post('nama'),
			'username'=>$this->input->post('username'),
			'password'=>password_hash($this->input->post('password'),PASSWORD_BCRYPT)
		);

		$input = $this->SistemModel->tambah_data('users',$data);
		if ($input==true) {
			$this->session->set_flashdata('notif', notifikasi(TRUE));
		} else {
			$this->session->set_flashdata('notif', notifikasi(FALSE));
		}

		redirect('user/index','refresh');
		
	}

	public function prosesedit_user()
	{
		$id = $this->uri->segment(3);
		$where = array('id'=>$id);
		$query = "SELECT username FROM users WHERE id != '$id' ";
		$hasil = $this->SistemModel->query_umum($query)->result();
		$array = $this->username_array($hasil);
		$username = $this->input->post('username');

		if (in_array($username, $array)) {
			$this->session->set_flashdata('notif', 
				'<div class="alert alert-warning alert-dismissible">
				    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				    <h4><i class="icon fa fa-warning"></i> Peringatan !</h4> Username telah digunakan...!!!
				</div>'
			);	
			redirect('user/edit_user/'.$id);
		}
		// $datauser = $this->input->post(array('nama','username','password','level'));
		$data = array(
    		'nama' => $this->input->post('nama'),
    		'username' => $username,
    		'password' => password_hash($this->input->post('password'),PASSWORD_BCRYPT)
    		// 'level' => $this->input->post('level')
    	);

		$update = $this->SistemModel->prosesedit('users',$data,$where);
		if ($update) {
			$this->session->set_flashdata('notif', notifikasi(TRUE));
			redirect('user/index','refresh');
		}else{
			$this->session->set_flashdata('notif', notifikasi(FALSE));
			redirect('user/edit_user/'.$id);
		}
	}

	public function username_array($array)
	{
		foreach ($array as $data) {
			$datanya[]= $data->username;
		}

		return $datanya;
	}

	public function hapus_user()
	{
		$id = $this->uri->segment(3);
		$where = array('id'=>$id);		
		$hapus = $this->SistemModel->hapus('users',$where);
		if ($hapus) {
			$this->session->set_flashdata('notif', notifikasi(TRUE));
		}else{
			$this->session->set_flashdata('notif', notifikasi(FALSE));
		}
		redirect('user/index','refresh');
	}

}

/* End of file User.php */
/* Location: ./application/controllers/User.php */