<?php
class Data_barang extends CI_Controller{
    // function __construct(){
    //     parent::__construct();
    //     $this->load->model('m_login');
    //     $this->load->helper('url');
    // }
    
    public function index() // membuat fungsi index yang akan diakses saat controller dijalankan
    {
        $data['barang']= $this->model_barang->tampil_data()->result(); // memanggil model barang dan fungsi tampil data
        $this->load->view('templates_admin/head');
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/data_barang', $data); // meload tampilan admin/data barang
        $this->load->view('templates_admin/footer');
    }
    public function tambah_aksi() // membuat fungsi
    {
        $nama_brg       =$this->input->post('nama_brg'); // menangkap hasil inputan dari form
        $keterangan       =$this->input->post('keterangan'); // menangkap hasil inputan dari form
        $kategori       =$this->input->post('kategori'); // menangkap hasil inputan dari form
        $harga       =$this->input->post('harga'); // menangkap hasil inputan dari form
        $stok       =$this->input->post('stok'); // menangkap hasil inputan dari form
        $gambar     =$_FILES['gambar']['name']; // menangkap hasil inputan dari form
        if ($gambar=''){}else {
            $config ['upload_path']='./uploads';
            $config ['allowed_types']='jpg|jpeg|png|gift';

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('gambar')){
                echo "Gambar Gagal!";
            }else {
                $gambar=$this->upload->data('file_name');
            }
        }
        $data=array( // memasukkan data inputan kedalam array
            'nama_brg'          =>$nama_brg, 
            'keterangan'          =>$keterangan,
            'kategori'          =>$kategori,
            'harga'          =>$harga,
            'stok'          =>$stok,
            'gambar'          =>$gambar
        );
        $this->model_barang->tambah_barang($data, 'tb_brg'); // memanggil model barang dengan fungsi tambah barang , memasukkan array ke dalam tabel tb_barang
        redirect('admin/data_barang/index');
        }
        function edit($id){ // method untuk mengedit data
            $where = array('id_brg' => $id); // menangkap data berdasarkan id yang dikirim dari link edit  kemudian dijadikan array
            $data['barang'] = $this->model_barang->edit_barang($where,'tb_brg')->result(); //function edit_data digunakan untuk menangkap data dari model barang. result() untuk me-regenerate hasil query menjadi array
            $this->load->view('templates_admin/head');
            $this->load->view('templates_admin/sidebar');
            $this->load->view('admin/edit_barang', $data);
            $this->load->view('templates_admin/footer');
        }
        public function update(){ //membuat fungsi update
            $id         = $this->input->post('id_brg'); // menangkap hasil inputan dari form
            $nama_brg         = $this->input->post('nama_brg'); // menangkap hasil inputan dari form
            $keterangan         = $this->input->post('keterangan'); // menangkap hasil inputan dari form
            $kategori         = $this->input->post('kategori'); // menangkap hasil inputan dari form
            $harga         = $this->input->post('harga'); // menangkap hasil inputan dari form
            $stok         = $this->input->post('stok'); // menangkap hasil inputan dari form

            $data=array( // memasukkan data inputan kedalam array
            'nama_brg'          =>$nama_brg,
            'keterangan'          =>$keterangan,
            'kategori'          =>$kategori,
            'harga'              =>$harga,
            'stok'              =>$stok
            
            );
            $where =array(
                'id_brg'              =>$id
            );
            $this->model_barang->update_data($where,$data,'tb_brg'); // memanggil model barang dengan fungsi update data , memasukkan array ke dalam tabel tb_barang
            redirect('admin/data_barang/index');
        }
        function hapus($id){ // menghapus data dengan menyeleksi query untuk menghapus record
           $where=array('id_brg'=>$id);
           $this->model_barang->hapus_data($where, 'tb_brg'); // memanggil mode barang dengan fungsi hapus data berdasarkan id pada tb_barang
           redirect('admin/data_barang/index');
        }
}
