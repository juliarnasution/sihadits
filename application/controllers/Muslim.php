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

	public function simpan_stopword_stemming($jenis_hadits='muslim')
	{
		$this->load->library('preprocessing');
        $this->load->library('stemming');
		$hadits = $this->dataHadits($jenis_hadits,"No");
		$token = $this->tokenisasi($hadits);
		$haditsbersih = $this->bersihkan_token($token);//mengahpus array yang kosong
		$hasilStopword = $this->stopwords_stemming($haditsbersih);//stopword dan stemming
		$bersihLagi = $this->bersihkan_token($hasilStopword);

		for ($i=0; $i <count($bersihLagi) ; $i++) { 
			$text = implode(",",$bersihLagi[$i][1]);
			$data = array('nomor'=>$bersihLagi[$i][0],'teks_stemming'=>$text);
			try {
				$input = $this->SistemModel->tambah_data('stemming_muslim',$data);
			} catch (Exception $e) {
				continue;
			}
		}
		
		if ($input) {
			echo "berhasil";
		}else{
			echo "gagal";
		}

	}

	public function cari_tf()
	{
		$this->load->library('preprocessing');
		$hasil = array();
		$data = $this->SistemModel->all_data("stemming_muslim","nomor","DESC");
		foreach ($data as $value) {
			$hasil[] = array($value->nomor,explode(",", $value->teks_stemming));
		}
		
		$data_tf = $this->preprocessing->mencari_tf($hasil);//dokumen per term

		for ($i=0; $i <count($data_tf) ; $i++) { 
			$j=0;			
			foreach ($data_tf[$i] as $nilai_tf) {
				$hasil_tf[$i][$j] = $nilai_tf['nilai_tf'];
				$j++; 
			}

			$data = array('nomor_dokumen'=>$hasil[$i][0],'nilai_tf'=>implode(',', $hasil_tf[$i]));

			try {
				$input = $this->SistemModel->tambah_data('tabel_tf_muslim',$data);// memasukkan nilai tf kedalam tabel
			} catch (Exception $e) {
				continue;
			}
		}

		if ($input) {
			echo "berhasil";
		}else{
			echo "gagal";
		}
		// echo "<pre>";
		// print_r ($hasil);
		// echo "</pre>";
		// die();
	}

	public function dataHadits($tabel=null,$rowId)
	{
		$hadits = $this->SistemModel->all_data($tabel,$rowId);
		for ($i=0; $i <count($hadits) ; $i++) { 
			$hasil[$i]=array($hadits[$i]->No,$hadits[$i]->Terjemah,$hadits[$i]->Kitab,$hadits[$i]->Arab);
		}
		return $hasil;
	}
	public function tokenisasi($gabung= array())
	{
		for ($i=0; $i <count($gabung) ; $i++) { 
			$tokenhadits[] = array(
				$gabung[$i][0],
				$this->preprocessing->preproses($gabung[$i][1]) 
			);
		}//tokenisasi pertama dokumen. membersihkan teks dari tanda titik koma dan simbol lainnya
		return $tokenhadits;
	}

	public function bersihkan_token($tokenhadits)
	{
		for ($j=0; $j <count($tokenhadits); $j++) { 
			for ($m=0; $m <count($tokenhadits[$j][1]) ; $m++) { 
				$tokenhadits2[$j][1] = $this->hapus_array_kosong($tokenhadits[$j][1]);
			}
			$haditsbersih[] = array($tokenhadits[$j][0],$tokenhadits2[$j][1]);
		}//tokenisasi kedua dokumen, menghilangkan array kosong
		return $haditsbersih;
	}

	//proses stopwords
	public function stopwords_stemming($haditsbersih)
	{ 
		$kata = array();
		for ($i=0; $i <count($haditsbersih) ; $i++) { 
			for ($j=0; $j<count($haditsbersih[$i][1]) ; $j++) { 
				// echo $haditsbersih[$i][1][$j];
				$query = $this->SistemModel->get_data('daftar_stopword',array('word'=>$haditsbersih[$i][1][$j]))->result();
				$jumlah = count($query);
				// return $jumlah;
				if($jumlah>0){
					continue;
				}else{
					$hasilStemming = $this->stemming($haditsbersih[$i][1][$j],$this->cari_stemming($haditsbersih[$i][1][$j]));//proses stemming
					// $kata[]= $haditsbersih[$i][1][$j];
				}
				$kata[$i][1][]= $hasilStemming;
			}
			$kata2[]= array($haditsbersih[$i][0],$kata[$i][1]);
		}

		return $kata2; // hasil stopword
	}

	public function stemming($dataStemming,$jumlah)
	{

		$a1 = $this->stemming->hapuspartikel($dataStemming,$jumlah);
        $a2 = $this->stemming->hapuspp($a1,$jumlah);
        $a3 = $this->stemming->hapusawalan1($a2,$jumlah);
        $a4 = $this->stemming->hapusawalan2($a3,$jumlah);
        $a5 = $this->stemming->hapusakhiran($a4,$jumlah);
        $a6 = $this->stemming->hapusakhiran($a5,$jumlah);
		// var_dump ($a6);
		// var_dump($jumlah);
		// die();
        return $a6;
	}

	public function cari_stemming($kata=''){
		
		$jumlah_array = $this->SistemModel->stemming($kata);
		// $a1 = $this->stemming->hapuspartikel($kata,$jumlah_array);
		// echo $a1;
		// die();
		return $jumlah_array;
	}

	public function hapus_array_kosong($array, $remove_null_number = true) {
		$new_array = array();
		$null_exceptions = array();
		foreach ($array as $key=>$value) {
			$value = trim($value);
		 	if($remove_null_number) {
		 		$null_exceptions[] = '0';
		 	}
		 	if(!in_array($value, $null_exceptions) && $value != "") {
		 		$new_array[] = $value;
		 	}
		}
		return $new_array;
	}

}

/* End of file Muslim.php */
/* Location: ./application/controllers/Muslim.php */