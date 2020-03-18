<?php 

class Dashboard extends CI_Controller {
    public function index() { //membuat fungsi index yaitu fungsi yang akan diload saat controller diakses
        $data['barang'] = $this->model_barang->tampil_data()->result(); // memanggil model barang dan fungsi tampil data
        $this->load->view('templates/head');
        $this->load->view('templates/sidebar');
        $this->load->view('dashboard', $data); //meload view dashboard
        $this->load->view('templates/footer');
    }
    public function tambah_ke_keranjang($id){ // membuat fungsi 
        $barang = $this->model_barang->find($id); // memanggil model barang dengan method find
        $data = array(
        'id'      => $barang->id_brg,
        'qty'     => 1,
        'price'   => $barang->harga,
        'name'    => $barang->nama_brg
        
        );

$this->cart->insert($data); // memasukkan cart ke variabel data
redirect('dashboard');
    }
    public function detail_keranjang() { // membuat fungsi
        $this->load->view('templates/head');
        $this->load->view('templates/sidebar');
        $this->load->view('keranjang'); // meload view keranjang
        $this->load->view('templates/footer');
    }
    public function hapus_keranjang(){ // membuat fungsi
        $this->cart->destroy(); // menghapus data di cart 
        redirect('dashboard/index');
    }
    public function pembayaran(){ // membuat fungsi
        $this->load->view('templates/head');
        $this->load->view('templates/sidebar');
        $this->load->view('pembayaran'); // meload view pembayaran
        $this->load->view('templates/footer');
    }
    public function proses_pesanan(){ // membuat fungsi
        $this->cart->destroy(); // menghapus
        $this->load->view('templates/head');
        $this->load->view('templates/sidebar');
        $this->load->view('proses_pesanan'); // meload view
        $this->load->view('templates/footer');
    }
}
