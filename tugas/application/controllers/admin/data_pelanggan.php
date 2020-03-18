<?php
class Data_pelanggan extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model('model_pelanggan'); //mengakses model pelanggan
        $this->load->helper('url'); //memanggil helper
    }


    public function index() // membuat fungsi index yang akan diakses saat controller dijalankan
    {
        $data['pelanggan']= $this->model_pelanggan->tampil_data()->result(); // memanggil model pelanggan dan fungsi tampil data
        $this->load->view('templates_admin/head');
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/vdata_pelanggan', $data); // meload tampilan admin/vdata pelanggan
        $this->load->view('templates_admin/footer');
    }
    public function tambah_aksi() // membuat fungsi
    {
        $nama_plg       =$this->input->post('nama_plg'); // menangkap hasil inputan dari form
        $alamat       =$this->input->post('alamat'); // menangkap hasil inputan dari form
        $username       =$this->input->post('username'); // menangkap hasil inputan dari form
        $password       =$this->input->post('password'); // menangkap hasil inputan dari form
       
        $data=array( // memasukkan data inputan kedalam array
            'nama_plg'          =>$nama_plg,
            'alamat'          =>$alamat,
            'username'          =>$username,
            'password'          =>$password
            
        );
        $this->model_pelanggan->tambah_pelanggan($data, 'tb_pelanggan'); // memanggil model pelanggan dengan fungsi tambah pelanggan , memasukkan array ke dalam tabel tb_pelanggan
        redirect('admin/data_pelanggan/index');
        }
        function edit($id){ // method untuk mengedit data
            $where = array('id_plg' => $id); // menangkap data berdasarkan id yang dikirim dari link edit  kemudian dijadikan array
            $data['pelanggan'] = $this->model_pelanggan->edit_pelanggan($where,'tb_pelanggan')->result(); //function edit_data digunakan untuk menangkap data dari model pelanggan. result() untuk me-regenerate hasil query menjadi array
            $this->load->view('templates_admin/head');
            $this->load->view('templates_admin/sidebar');
            $this->load->view('admin/edit_pelanggan', $data);
            $this->load->view('templates_admin/footer');
        }
        public function update(){ // membuat fungsi update
            $id         = $this->input->post('id_plg'); // menangkap hasil inputan dari form
            $nama_plg         = $this->input->post('nama_plg'); // menangkap hasil inputan dari form
            $alamat         = $this->input->post('alamat'); // menangkap hasil inputan dari form
            $username         = $this->input->post('username'); // menangkap hasil inputan dari form
            $password         = $this->input->post('password'); // menangkap hasil inputan dari form
            

            $data=array( // memasukkan data inputan kedalam array
            'nama_plg'          =>$nama_plg,
            'keterangan'          =>$alamat,
            'username'          =>$username,
            'password'              =>$password
            
            );
            $where =array(
                'id_plg'              =>$id
            );
            $this->model_barang->update_data($where,$data,'tb_pelanggan'); // memanggil model pelanggan dengan fungsi update data , memasukkan array ke dalam tabel tb_pelanggan
            redirect('admin/data_pelanggan/index');
        }
        function hapus($id){ // menghapus data dengan menyeleksi query untuk menghapus record
           $where=array('id_plg'=>$id);
           $this->model_barang->hapus_data($where, 'tb_pelanggan'); // memanggil model pelanggan dengan fungsi hapus data berdasarkan id pada tb_pelanggan
           redirect('admin/data_pelanggan/index');
        }
}
