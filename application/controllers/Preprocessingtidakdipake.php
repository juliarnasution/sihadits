<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Preprocessing extends CI_Controller {

	public function index()
	{
		
	}

	//fungsi prepocessing menerima teks dan menerapkan beberapa tugas awal
	//fase indexing dokumen teks 
	// parsing, stopword dan stemming
	function preproses($teks){

		//proses parsing proses pertama dari algoritma
		//ubah ke huruf kecil (case folding)
		$teks = strtolower(trim($teks));
		//hilangkan tanda baca
		$teks = str_replace("'", " ", $teks);
		$teks = str_replace("-", " ", $teks);
		$teks = str_replace("(", " ", $teks);
		$teks = str_replace(")", " ", $teks);
		$teks = str_replace("/", " ", $teks);
		$teks = str_replace("\"", " ", $teks);
		$teks = str_replace("=", " ", $teks);
		$teks = str_replace(".", " ", $teks);
		$teks = str_replace(",", " ", $teks);
		$teks = str_replace(":", " ", $teks);
		$teks = str_replace(";", " ", $teks);
		$teks = str_replace("!", " ", $teks);
		$teks = str_replace("?", " ", $teks);

		//hasil proses parsing
		$token = explode(" ", $teks);//


		//hapus stopword , proses kedua dari algoritma
		for ($i=0; $i < count($token); $i++){
			$sql = mysqli_query($koneksi, "SELECT word FROM stopword_list WHERE word='$token[$i]'");
			$numb = mysqli_num_rows($sql);
			if($numb>0){

			}else{
				$kata[$i]=$token[$i];
			}
		}
		$data = array(
			'parsing' =>$token, 
			'stopword'=>$kata
			);
		return $data; // hasil stopword
	}

 	public function prosesstemming($value='')
 	{
 		// stemming proses ketiga dari algoritma
 		$judul = $_POST['artikel'];
		$b = preproses($judul, $koneksi);
	    foreach ($b['stopword'] as $steming) {
	        $a1 = hapuspartikel($koneksi,$steming);
	        $a2 = hapuspp($koneksi,$a1);
	        $a3 = hapusawalan1($koneksi,$a2);
	        $a4 = hapusawalan2($koneksi,$a3);
	        $a5 = hapusakhiran($koneksi,$a4);
	        $a6 = hapusakhiran($koneksi,$a5);

	        $hasil[] =$a6;
	    }
    
    	return $kata_hasil = implode(" ", $hasil); // hasil stemming
 	}
	
	

}

/* End of file Preprocessing.php */
/* Location: ./application/controllers/Preprocessing.php */