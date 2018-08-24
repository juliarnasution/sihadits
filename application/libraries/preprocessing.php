<?php 
// defined('BASEPATH') OR exit('No direct script access allowed');
class Preprocessing {


	function preproses($teks){
		// proses tokenisasi
		//ubah ke huruf kecil (case folding)
		$teks = strtolower(trim($teks));
		//hilangkan tanda baca
		$teks = str_replace("[", " ", $teks);
		$teks = str_replace("]", " ", $teks);
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
		$teks = str_replace("  ", " ", $teks);
		$teks = str_replace("   ", " ", $teks);



		$token = explode(" ", $teks);

		return $token;

	}

	public function tokenisasi($params = array(), $conn){
		for ($i=0; $i < count($params); $i++){
			$sql = mysqli_query($conn, "SELECT word FROM stopword_list WHERE word='{$params[$i]}'");
			$numb = mysqli_num_rows($sql);
			if($numb>0){

			}else{
				$kata[$i]=$params[$i];
			}
		}

		$data = array(
			'parsing' =>$params, 
			'stopword'=>$kata
			);

		return $data;
	}

public function stemming($data = array(), $conn) {
	foreach ($data as $steming) {
        $a1 = hapuspartikel($conn,$steming);
        $a2 = hapuspp($conn,$a1);
        $a3 = hapusawalan1($conn,$a2);
        $a4 = hapusawalan2($conn,$a3);
        $a5 = hapusakhiran($conn,$a4);
        $a6 = hapusakhiran($conn,$a5);

        $hasil[] =$a6;
    }

    return $hasil;
}

public function mencari_tf($data=array())
{
	for ($i=0; $i <count($data) ; $i++) { 

		if ($i==0) {
			$term_query = array_unique($data[$i][1]);//menghilangkan data kembar dari data query form
		}
	}

	$j=0;
	foreach ($term_query as $value) {
		$query[$j] = $value;
		$j++;
	}
	//batas term

	//mencari tf
	for ($m=0; $m <count($data) ; $m++) { 
		for ($n=0; $n <count($query) ; $n++) { 
		// foreach ($term_query as $kunci => $isi) {
				$angka = (in_array($query[$n], $data[$m][1])) ? 1 : 0 ;
				$tf[$m][$n]=array("index_term"=>$n,"nilai_tf"=>$angka);
			// }
		}		
	}//batas mencari tf
	return $tf;
}


public function mencari_df($tf=array())
{
//mencari df
	foreach ($tf as $key1 => $tf1) {
		$i=0;
		foreach ($tf1 as $key2 => $tf2) {
			$tfhasil[$key1][$i]=$tf2['nilai_tf'];
			$i++;
		}
	}

	$sumArray = array();

	$jumlah_array = $this->jumlah_array($tfhasil);
	for ($j=0; $j <$jumlah_array ; $j++) { 
		$sumArray[] = array_sum(array_column($tfhasil, $j));//nilai df
	}
	//batas mencari df
	return $sumArray;//hasil berupa array, index array adalah index term
}

public function mencari_idf($df=array(),$document = array())
{
	$idf= array();
	$angka =0;
	for ($j=0; $j <count($document) ; $j++) { 
		$angka +=1;
	}
	$jumlah_doc = $angka;
	for ($k=0; $k <count($df) ; $k++) { 
		$bagi= $jumlah_doc/$df[$k];
		$idf[$k] = log10($bagi);
	}
	return $idf;
}


public function tf_kali_idf($tf=array(), $idf=array())
{
	for ($i=0; $i <count($tf) ; $i++) { 
		for ($j=0; $j <count($idf) ; $j++) { 
			$hasil_kali[$i][$j]=$tf[$i][$j]['nilai_tf']*$idf[$j];//$i adalah index dokumen, $j index term dan index idf.
		}
	}
	return $hasil_kali;
}

public function query_kali_dokumen($tfkaliidf= array())
{//perkalian antara IDF query dengan dokumen
	$jmlharray = count($tfkaliidf)-1;
	for ($i=1; $i <=$jmlharray ; $i++) { 
		for ($j=0; $j <count($tfkaliidf[0]) ; $j++) { 
			$hasil_kali[$i-1][$j]=$tfkaliidf[0][$j]*$tfkaliidf[$i][$j];
		}
	}
	return $hasil_kali;
}

public function penjumlahan_hasil_kali($hasil_kali = array())
{ 
	for ($i=0; $i <count($hasil_kali) ; $i++) { 
		$jumlah[$i]= 0;
		for ($j=0; $j <count($hasil_kali[$i]) ; $j++) { 
			$jumlah[$i] +=$hasil_kali[$i][$j];
		}
	}
	return $jumlah;
}

public function mencari_panjang_vektor($tfkaliidf =array())
{
	for ($i=0; $i <count($tfkaliidf) ; $i++) { 
		for ($j=0; $j <count($tfkaliidf[$i]) ; $j++) { 
			$panjang_vektor[$i][$j] = sqrt($tfkaliidf[$i][$j]);
		}
	}
	return $panjang_vektor;
}

public function penjumlahan_panjang_vektor($panjang_vektor=array())
{
	for ($i=0; $i <count($panjang_vektor) ; $i++) { 
		$jumlah[$i]= 0;
		for ($j=0; $j <count($panjang_vektor[$i]) ; $j++) { 
			$jumlah[$i] +=$panjang_vektor[$i][$j];
		}
	}
	return $jumlah;
}

public function vektor_query_tambah_vektor_dok($jumlah_vektor=array())
{
	$jmlharray = count($jumlah_vektor)-1;
	for ($i=1; $i <=$jmlharray ; $i++) { 
			$hasil_jumlah[$i-1]=$jumlah_vektor[0]+$jumlah_vektor[$i];
	}
	return $hasil_jumlah;
}

public function mencari_dice($jml_idf=array(),$jml_vektor)
{
	for ($i=0; $i <count($jml_vektor) ; $i++) { 
		$dice[$i+1] = (2*$jml_idf[$i])/$jml_vektor[$i];
	}
	
	return $dice;
}

public function jumlah_array($array=array())
{ 
	for ($i=0; $i <count($array) ; $i++) { 
		$angka =0;
		for ($j=0; $j <count($array[$i]) ; $j++) { 
			$angka +=1;
		}
	}
	return $angka;
}

/*batas fungsi yg dipakai,
	yang dibawah nda dipakai
*/
/*
		$dataset data dari database
		$datalatih data dari form
	*/

public function searchWord($dataset = array(), $datalatih = array()){

	$data = array();
	$term = array_unique($datalatih);// menghilangkan array yg duplikat

	for($i=0; $i<count($dataset); $i++){
		$key[$i] = 0;
		foreach($dataset[$i]['stopword'] AS $keys => $value){
			$data[$i][$key[$i]] = array($key[$i] => $value);
			$key[$i] ++;
		}
	}

	foreach ($term as $keys => $val) {
		for($x = 0; $x < count($data); $x++) {
			$sum[$x] = 0;
			for($y = 0; $y < count($data[$x]); $y++) {
				foreach ($data[$x][$y] as $key => $value) {
					if($val == $value) {
						$nilai = 1;
					}
					else{
					 	$nilai = 0; 
					}
					$sum[$x] += $nilai;
				} 
			}

			$params[$x] = array($val, $sum[$x]);
		}

		$df[$keys] = $params;

	}

	return $df;

} // end func...

public function term($datauji = array(), $dataset = array()) {
	$arr = array_unique($datauji);
	
	var_dump($dataset);
		for($m = 0; $m < count($dataset); $m++) {
			for($n = 0; $n < count($dataset[$m]); $n++) {
			}

		} // end for m ..
}

public function tfQ($params = array()) {
	$jenis[] = null;
	$j = 0;
	for($i = 0; $i < count($params); $i++ ) {

		$index = array_search($params[$i], $jenis);

		if($index == "" ){
			$jenis[$j] = $params[$i];

			$j++;
		}

	}


	$uji = array_unique($params);

		for($g = 0; $g < count($uji); $g++) {
	for($k = 0; $k < count($jenis); $k++) {

		$cari[$k] = $this->cari($params, $jenis[$k]);
		
			if($uji[$g] == $jenis[$k]) {

				$data[$g] = array($jenis[$k], $cari[$k]);

			}
		}
	}

    return $data;

} // end func...

public function cari($data = array(), $data2 = array()) {
	$nb = 0;
		foreach($data as $key => $val) {
        	if ($val==$data2) {
        	
        		$nb++;	

        	}
		
		}
        	return $nb;
}

public function Idf($df = array(), $q = array()) {
	$arr = array();
	for($m = 0; $m < count($df); $m++) {
		$doc[$m] = 0;
		$sum_q[$m] = $q[$m][1];
		for($n = 0; $n < count($df[$m]); $n++){
			$doc[$m] += $df[$m][$n][1];
			// echo $df[$m][$n][1];
		}
		// var_dump($df[$m]);
		$total[$m] = $doc[$m] + $sum_q[$m];
		$idf[$m] = log(count($df[$m]) / $total[$m]);
		// echo "<br>" . $q[$m][0] . " = " . $idf[$m] . "<br>";

		$arr[$m] = array($q[$m][0], $idf[$m]);

	}

return $arr;
} // end func...

public function weightDoc($df = array(), $q = array(), $Idf = array()) {
	// var_dump($q);
	$hasil_QDn = array();
	$sumVectorQ = 0;
	for($m = 0; $m < count($df); $m++) {
		$weightQ[$m] = $q[$m][1] * $Idf[$m][1];
		$vectorQ[$m] = $weightQ[$m] * $weightQ[$m];

		$sumVectorQ += $vectorQ[$m];
		// echo $weightQ[$m] . "=> ". $vectorQ[$m];
		
		for($n = 0; $n < count($df[$m]); $n++){

			$weightDn[$m][$n] = $df[$m][$n][1] * $Idf[$m][1];
			$weightQDn[$m][$n] = $weightQ[$m] * $weightDn[$m][$n];
			// echo $weightQDn[$m][$n] . ", ";

			$vectorDn[$m][$n] = $weightDn[$m][$n] * $weightDn[$m][$n];


		}
		// echo "Q = {$weightQ[$m]}<br>";
		$hasil_QDn[$m] = $weightQDn[$m];
	}


	for($n = 0; $n < count($df[0]); $n++) {
		$sum[$n] = 0;
		$sumVektor[$n] = 0;

		for($m = 0; $m < count($df); $m++) {
			// echo  . ", ";
			$sum[$n] += $weightQDn[$m][$n];
			$sumVektor[$n] += $vectorDn[$m][$n];
		}
		$dice[$n] = 2 * $sum[$n];
	}

	for($n = 0; $n < count($df[0]); $n++) {
			$vectorQDn[$n] = $sumVektor[$n] + $sumVectorQ;

			$similariti[$n] = $dice[$n] / $vectorQDn[$n];
	} 

return $similariti;

} // end func...

public function sortData($params = array()) {
	
	for($c = 0; $c < count($params); $c++){
		for($d = $c; $d < count($params); $d++){
			if($params[$c]['judul_artikel'] < $params[$d]['judul_artikel']) {
			$save = $params[$c];
			$params[$c] = $params[$d];
			$params[$d] = $save;
				
			}
		}
	}
	
	$param = array();

	for($k = 0; $k < 3; $k++){

		$param[$k] = $params[$k];
		// var_dump($params[$k]); //  . "<br>";
	}

	return $param;
	
} // end func..

public function dominan($params = array()) {
	//echo count($params);
	for($a = 0; $a < count($params); $a++) {
	$arr_rumpun[$a] = $params[$a]['rumpun_id'];
	$arr_sub[$a] = $params[$a]['sub_id'];
	$arr_ilmu[$a] = $params[$a]['bidang_id'];

		// echo $params[$a]['rumpun_id'] . ", " . $params[$a]['sub_id'];		
	}

	$send_id = array();

	$array_rumpun = array_count_values($arr_rumpun);
	$array_sub = array_count_values($arr_sub);
	$min_nilai = array_count_values($arr_ilmu);

	$val_nilai = array_values($arr_ilmu);

	// var_dump();
	$minimum = null;
	foreach ($min_nilai as $key => $val) {
    	if($val==min($min_nilai)){
    		$minimum = $key;
    	}

	}

	foreach ($val_nilai as $key => $val) { 
    	if($minimum != $val) {
    		$send_id[0][$key] = $val;
    	}

	}

	foreach ($array_rumpun as $key => $val) {
    	if($val==max($array_rumpun)){
    		if($val >= 2 ) {
    			// echo "rumpun id =  [ $key ]<br/>";
    			$send_id[1] = $key;

    		}
    	}
	}

	foreach ($array_sub as $key => $val) {
    	if($val==max($array_sub)){
    		if($val >= 2) {
    			$send_id[2] = $key;
    			// echo "sub = [ $key ]; <br/>";
    			
    		}
    	}
	}
	return $send_id;
}

} // end class

