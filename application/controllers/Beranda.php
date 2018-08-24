<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda extends CI_Controller {
	// public $CI = NULL;

 //    public function __construct() {
 //        parent::__construct();
 //        $this->load->library('preprocessing');
 //        $this->load->library('stemming');
 // //        $this->CI = & get_instance();
 // //  //       if ($this->session->userdata('status')!='login') {
	// // 	// 	redirect(base_url('Admin/index'));
	// // 	// }
 //    }

	public function index()
	{
		$data = null;
		$data['data']=null;
		$data['query'] = $this->input->post('hadits');
		$jenis_hadits	= $this->input->post('jenis_hadits');
		// var_dump ($data);
		// die();
		if (!is_null($data['query']) || !empty($data['query'])) {
			$data['data'] = $this->prosesdata($data['query'],$jenis_hadits);
		}
		$this->load->view('template/headerberanda');
		$this->load->view('index',$data);
		$this->load->view('template/footerberanda');
	}

	public function bukhari()
	{
		// $CI = NULL;
		// $this->CI = & get_instance();
		$data['query'] = $this->SistemModel->all_data("bukhari","No","ASC");
		$data['data'] = $this->atur_data($data['query']);
		$this->load->view('template/headerberanda');
		$this->load->view('bukhari/index',$data);
		$this->load->view('template/footerberanda');
	}

	public function profilbukhari()
	{
		$data['data'] = $this->SistemModel->ambildata("bio_bukhari",array('id'=>1));
		$this->load->view('template/headerberanda');
		$this->load->view('bukhari/profil',$data);
		$this->load->view('template/footerberanda');
	}

	public function bukhariview()
	{
		$id = $this->uri->segment(3);
		$where = array('No'=>$id);
		$data['data'] = $this->SistemModel->ambildata('bukhari',$where);
		$this->load->view('template/headerberanda');
		if (!empty($data['data'])) {
			$this->load->view('bukhari/view',$data);
		} else {
			$this->load->view('template/kosong');
		}
		
		// $this->load->view('bukhari/view',$data);
		$this->load->view('template/footerberanda');
	}

	public function muslim()
	{
		$data['query'] = $this->SistemModel->all_data("muslim","No","ASC");
		$data['data'] = $this->atur_data($data['query']);
		$this->load->view('template/headerberanda');
		$this->load->view('muslim/index',$data);
		$this->load->view('template/footerberanda');
	}

	public function profilmuslim()
	{
		$data['data'] = $this->SistemModel->ambildata("bio_muslim",array('id'=>1));
		$this->load->view('template/headerberanda');
		$this->load->view('muslim/profil',$data);
		$this->load->view('template/footerberanda');
	}

	public function muslimview()
	{
		$id = $this->uri->segment(3);
		$where = array('No'=>$id);
		$data['data'] = $this->SistemModel->ambildata('muslim',$where);
		$this->load->view('template/headerberanda');
		if (!empty($data['data'])) {
			$this->load->view('muslim/view',$data);
		} else {
			$this->load->view('template/kosong');
		}
		
		$this->load->view('template/footerberanda');
	}

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

	public function prosesdata($query_form="",$jenis_hadits)
	{
		$this->load->library('preprocessing');
        $this->load->library('stemming');
		$query = array(
			0=>array(
				0=>"query",
				1=>$query_form
			)
		);

		// $tokenisasi = $this->preprocessing->preproses($data); //tokenisasi query
		// $stopword = $this->stopwords($tokenisasi);//menghilangkan kata sambung pada query atau proses stopword
		$hadits = $this->dataHadits($jenis_hadits,"No");
		$gabung = $this->menggabungkan_array($query,$hadits);//menggabungkan query dan hadits kedalam array
		$token = $this->tokenisasi($gabung);
		$haditsbersih = $this->bersihkan_token($token);//mengahpus array yang kosong
		$hasilStopword = $this->stopwords_stemming($haditsbersih);//stopword dan stemming
		$bersihLagi = $this->bersihkan_token($hasilStopword);

		$data_tf = $this->preprocessing->mencari_tf($bersihLagi);//dokumen per term
		// echo "<pre>";
		// print_r($data_tf);//df sudah ditemukan, selanjutnya mencari idf
		// echo "</pre>";
		// die();
		$data_df = $this->preprocessing->mencari_df($data_tf);//df per term
		$data_idf = $this->preprocessing->mencari_idf($data_df,$gabung);//mencari idf dengan menginputkan kumpulan nilai df dan jumlah dokumen
		$data_tf_kali_idf = $this->preprocessing->tf_kali_idf($data_tf,$data_idf); //mengalikan tf dan idf, dilaporan sudah sampai tahap 5.
		$data_idfQuerykaliIdfDoc = $this->preprocessing->query_kali_dokumen($data_tf_kali_idf);// tahap 6
		$data_jumlah_hasilKaliIdf = $this->preprocessing->penjumlahan_hasil_kali($data_idfQuerykaliIdfDoc);//jumlah total keseluruhan dari hasil kali antara idf query dengan idf tiap dokumen tahap 7
		$panjang_vektor_dok = $this->preprocessing->mencari_panjang_vektor($data_tf_kali_idf); //akar dari tiap term yg nilainya telah didapat dari tf kali IDf tahap 8
		$data_jumlah_panjangVektor = $this->preprocessing->penjumlahan_panjang_vektor($panjang_vektor_dok);//jumlah keseluruhan dari panjang vektor query dan tiap dokumen.  tahap 9
		$vektor_query_tambah_vektor_dok = $this->preprocessing->vektor_query_tambah_vektor_dok($data_jumlah_panjangVektor); // vektor query ditambah vektor tiap dokumen tahap 10.
		$nilai_dice = $this->preprocessing->mencari_dice($data_jumlah_hasilKaliIdf,$vektor_query_tambah_vektor_dok); //2 dikali jumlah hasil kali idf dan idf dok (tahap 7) dibagi hasil vektor query tambah vektor dok.  2 kali tahap 7 di bagi tahap 10.. ini adalah tahap 11.

		/*selanjutnya mengurutkan data*/
		$hadits_dan_dice = $this->menggabungkan_dice_data_data($hadits,$nilai_dice);//menggabungkan data hadits dengan nilai dicenya
		$dice_terurut = $this->urutkan_array($hadits_dan_dice);//mengurutkan data dengan nilai dice paling besar

		//selanjutnya menampilkan data ke web.

		return $dice_terurut;

		// echo "<pre>";
		// print_r($bersihLagi);//df sudah ditemukan, selanjutnya mencari idf
		// echo "</pre>";
		// var_dump() ;

	}

	//preproses, menghilangkan simbol simbol
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

	public function cari_stemming($kata){
		
		$jumlah_array = $this->SistemModel->stemming($kata);
		// $a1 = $this->stemming->hapuspartikel($kata,$jumlah_array);
		// echo $a1;
		// die();
		return $jumlah_array;
	}

	//mengambil data hadits
	public function dataHadits($tabel=null,$rowId)
	{
		$hadits = $this->SistemModel->all_data($tabel,$rowId);
		for ($i=0; $i <count($hadits) ; $i++) { 
			$hasil[$i+1]=array($hadits[$i]->No,$hadits[$i]->Terjemah,$hadits[$i]->Kitab,$hadits[$i]->Arab);
		}
		return $hasil;
	}

//menghapus data array dengang nilai null atau kosong
	function hapus_array_kosong($array, $remove_null_number = true) {
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

//menggabungan data query dengan hadits, menggabungkan 2 array
	public function menggabungkan_array($array1= array(),$array2= array())
	{
		$gabung = array_merge($array1,$array2);
		return $gabung;
	}

	public function urutkan_array($array)
	{
		arsort($array);
		return $array;
	}

	public function menggabungkan_dice_data_data($hadits=array(),$nilai_dice=array())
	{
		for ($i=1; $i <=count($hadits) ; $i++) { 
			array_unshift($hadits[$i], $nilai_dice[$i]);
		}
		return $hadits;
	}





	// ==========Masih blueprint, belum di pake===========

}

/* End of file Beranda.php */
/* Location: ./application/controllers/Beranda.php */