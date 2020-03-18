<?php 
 //ini adalah controller login
class Login extends CI_Controller{
 
	function __construct(){ // fungsi yang pertamakali dijalankan saat kelas dijalankan
		parent::__construct();		
		$this->load->model('m_login');
 
	}
 
	function index(){
		$this->load->view('v_login'); //meload fungsi atau membuat view yang bernama v_login
	}
 
	function aksi_login(){ //menangkap username dan password yang dikirim
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$where = array( //memasukkan hasil dari username dan password yang dikirimkan, kemudian dimasukkan kedalam array
			'username' => $username,
			'password' => $password
			);
		$cek = $this->m_login->cek_login("tb_pelanggan",$where)->num_rows(); //mengirimkan array pada m_login. fungsi num_rows() berfungsi untuk menghitung jumlah record
		if($cek > 0){ // pengecekan, jika username dan password yang dimasukkan benar atau ada, maka dibuat session untuk menampilkan username tadi. Kemudian dikirimkan ke controller admin.
 
			$data_session = array( //membuat sessionnya
				'nama' => $username,
				'status' => "login"
				);
 
			$this->session->set_userdata($data_session);
 
			redirect(base_url('admin/dashboard_admin')); //mengirim kecontroller admin/dashboard admin
 
		}else{ //jika username dan password yang dimasukkan tidak ada atau salah, maka akan ditampilkan
			echo "Username dan password salah !";
		}
	}
 
	function logout(){ // session yang dijalankan jika pada v_admin mengklik logout
		$this->session->sess_destroy(); // menghapus semua session
		redirect(base_url('login')); //mengarahkan pada halaman admin.
	}
}