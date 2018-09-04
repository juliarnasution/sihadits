<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {

	public function __construct() {
		parent::__construct();
        if ($this->session->userdata('status')!='login') {
			redirect(base_url('Admin/index'));
		}
    }

	public function stemming_view()
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



	public function generate_term()
	{
		$this->load->view('template/header');
		$this->load->view('data/generate_term');
		$this->load->view('template/footer');
	}

	public function generate_tf()
	{
		$this->load->view('template/header');
		$this->load->view('data/generate_tf');
		$this->load->view('template/footer');
	}

	public function proses_generate_term()
	{
		$jenis_hadits ="";
		$tabel_stemming= "";

		$hadits = $this->input->post('jenis_hadits');

		if ($hadits=='muslim') {
			$jenis_hadits ="muslim";
			$tabel_stemming= "stemming_muslim";
		}else{
			$jenis_hadits ="bukhari";
			$tabel_stemming= "stemming_bukhari";
		}
		//hapus data sebelum di tambah
		$this->SistemModel->hapus_semua_data($tabel_stemming);
		$simpan = $this->simpan_stopword_stemming($jenis_hadits,$tabel_stemming);
		if ($simpan==TRUE) {
			$this->session->set_flashdata('notif', notifikasi(TRUE));
		} else {
			$this->session->set_flashdata('notif', notifikasi(FALSE));
		}
		redirect('data/generate_term','refresh');
	}

	public function proses_generate_tf()
	{
		$tabel_stemming= "";
		$tabel_tf = "";

		$hadits = $this->input->post('jenis_hadits');

		if ($hadits=='muslim') {
			$tabel_stemming= "stemming_muslim";
			$tabel_tf = "tabel_tf_muslim";
		}else{
			$tabel_stemming= "stemming_bukhari";
			$tabel_tf = "tabel_tf_bukhari";
		}
		//hapus data sebelum di tambah
		$this->SistemModel->hapus_semua_data($tabel_tf);
		$simpan = $this->cari_tf($tabel_stemming,$tabel_tf);
		
		if ($simpan==TRUE) {
			$this->session->set_flashdata('notif', notifikasi(TRUE));
		} else {
			$this->session->set_flashdata('notif', notifikasi(FALSE));
		}
		redirect('data/generate_tf','refresh');

	}

	public function simpan_stopword_stemming($jenis_hadits,$tabel_stemming)
	{
		$this->load->library('preprocessing');
        $this->load->library('stemming');
        $input = FALSE;
        $hadits = NULL;
		$hadits = $this->dataHadits($jenis_hadits,"No");
		$token = $this->tokenisasi($hadits);
		$haditsbersih = $this->bersihkan_token($token);//mengahpus array yang kosong
		$hasilStopword = $this->stopwords_stemming($haditsbersih);//stopword dan stemming
		$bersihLagi = $this->bersihkan_token($hasilStopword);
		if ($hadits != NULL) {
			for ($i=0; $i <count($bersihLagi) ; $i++) { 
				$text = implode(",",$bersihLagi[$i][1]);
				$data = array('nomor'=>$bersihLagi[$i][0],'teks_stemming'=>$text);
				try {
					$input = $this->SistemModel->tambah_data($tabel_stemming,$data);
				} catch (Exception $e) {
					continue;
				}
			}
		}
		
		
		if ($input) {
			return TRUE;
		}else{
			return FALSE;
		}

	}

	public function cari_tf($tabel_stemming,$tabel_tf)
	{
		$this->load->library('preprocessing');
		$hasil = array();
		$input = FALSE;
		$data  = NULL;
		$data = $this->SistemModel->all_data($tabel_stemming,"nomor","DESC");
		if ($data != NULL) {
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
					$input = $this->SistemModel->tambah_data($tabel_tf,$data);// memasukkan nilai tf kedalam tabel
				} catch (Exception $e) {
					continue;
				}
			}
		}
		

		if ($input) {
			return TRUE;
		}else{
			return FALSE;
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


	// public function hapusstemming()
	// {
	// 	# code...
	// }

}

/* End of file Data.php */
/* Location: ./application/controllers/Data.php */