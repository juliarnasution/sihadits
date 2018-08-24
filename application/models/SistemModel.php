<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SistemModel extends CI_Model {

	
	public function login_proses($username)
	{
		$where = array('username' => $username);
		$this->db->where($where);
		$query = $this->db->get('users');
  		return $query; //menangani proses login, serta mengambil data user
	}

	public function all_data($tabel,$id='id',$order='DESC'){
		$query = $this->db->order_by($id, $order)->get($tabel);
		return $query->result(); // mengambil data secara keseluruhan dalam satu tabel. di keluarkan dalam bentuk array
    }

    public function data_join($tabel1, $tabel2, $fieldtb, $id='id', $pilih='*',$order='DESC')
    {
        $this->db->select($pilih);
        $this->db->from($tabel1);
        $this->db->join($tabel2, $fieldtb);
        $query = $this->db->order_by($id,$order)->get();

        return $query; //mengambil data dari dua tabel berbeda
    }

    public function query_umum($syntaks)
    {
        $query = $this->db->query($syntaks);
        return $query; //fungsi untuk melakukan perintah query secara umum atau keseluruhan, tergantung query apa yang di tuliskan
    }

    public function tambah_data($tabel,$data)
    {
    	
    	$query = $this->db->insert($tabel, $data);
        return $query; //untuk menambahkan data dalam satu tabel
    }

    public function ambildata($tabel,$where)
    {
        $this->db->where($where);
        $data  = $this->db->get($tabel);
        return $data->row();//mengembalikan data dalam bentuk row
    }

    public function get_data($tabel,$where)
    {
        $this->db->where($where);
        $data  = $this->db->get($tabel);
        return $data; //mengembalikan data dalam bentuk umum
    }

    public function prosesedit($tabel,$data, $where)
    {
        $this->db->where($where);
    	$edit = $this->db->update($tabel, $data);
    	return $edit; // untuk mengedit data berdasakan id data.
    }

    public function hapus($tabel,$where)
    {
        $this->db->trans_start();
        $this->db->delete($tabel,$where);
        $hasil = $this->db->affected_rows();
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $hasil = FALSE;
        }
    	return $hasil; // fungsi untuk menghapus data berdasarkan idnya
    }

    public function uploadfoto($data)
    {
        // fungsi untuk mengupload foto.
        $config['upload_path'] = './upload/gambar/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        // $config['max_size']  = '100';
        // $config['max_width']  = '1024';
        // $config['max_height']  = '768';
        $config['remove_space'] = TRUE;
        
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload($data)){
            $error = array('result'=>FALSE,'file'=>'','error' => $this->upload->display_errors());
            return $error;
        }
        else{
            $data = array('result'=>TRUE,'file'=>$this->upload->data(),'upload_data' => $this->upload->data());
            return $data;
        }
    }

    public function ambil_maks($tabel, $data)
    {
        $this->db->select_max($data);
        $query = $this->db->get($tabel);
        $hasil = $query->row();
        return $hasil->$data; // untuk mengambil data maksimal dari suatu tabel
    }

    public function jumlah_data($tabel,$id='id',$order='DESC')
    {
        $this->db->order_by($id, $order)->get($tabel);
        // return $query->result();
        // $this->db->get($tabel);
        $num = $this->db->count_all_results();
        // $query = $this->db->get($tabel)->result();
        return $num;
    }

    public function data_terbatas($tabel,$limit=null,$offset=null)
    {
        return $this->db->get($tabel, $limit, $offset)->result();
    }

    public function stemming($value)
    {
        $this->db->where( array('katadasar'=>$value));
        $data  = $this->db->get('daftar_stemming');
        $hasil = $data->result();//mengembalikan data dalam bentuk row
        $jumlah = count($hasil);
        return $jumlah;
    }

}

/* End of file User.php */
/* Location: ./application/models/User.php */