# E41182007-Adi-Irawan-tugas-si-sederhana
# Persiapan
1. Visual Studio Code
2. Xampp dapat didowanload di https://www.apachefriends.org/download.html 
3. CodeIgniter 3.1.11+ , yang bisa diperoleh pada link https://codeigniter.com/ . Cara menggunakannya dapat dilihat di link https://www.malasngoding.com/pengertian-dan-cara-menggunakan-codeigniter/ .
4. Template Admin bootstrap yang bisa di download langsung pada web bootstrap. Kali ini saya memakai SB Admin 2
5. Database
# Pelaksanaan
1. Buat Project Baru sesuai yang dibutuhkan,
2. Ekstrak Tempalate, kemudian masukkan folder css, js, scss dan vendor kedalam sebuah folder assest pada project yang telah dibuat di nomor 1. Folder assets dibuat dengan cara manual, kemudian masukkan folder-foldernya.
3. Buka halaman index pada folder hasil ekstrak templatenya, kemudian pisahkan setiap bagian bagian agar lebih mudah dipanggil. Buat menjadi 3 bagian head, sidebar dan footer yang disimpan dalam satu folder template.
Ambil bagian head pada index tadi kemudian masukkan ke head.php , kemudian masukkan bagian body sampai bagian yang dibutuhkan pada sidebar.php , dan masukkan template bootstrap pada footer.php di bagian bawah sendiri. Simpan forder di view.
4. Atur Autoload pada config/autoload.php kemudian aktifkan library database dan helper nya
```php
<?php 
$autoload['libraries'] = array('database', 'cart'); 
$autoload['helper'] = array('url'); ?> 
```
5. Atur juga base url nya di config/config 
```php
<?php 
$config['base_url'] = 'http://localhost/tugas';
 ?>
 ```
 6. Atur koneksi ke databasenya 
 ```php 
 <?php 
 'hostname' => 'localhost',
	'username' => 'root',
	'password' => '',
    'database' => 'tugas_kuliah',
?>
```
7. Untuk Dashboard admin, kita buat tamplate yang berisi sidebar, head dan footer . simpan dengan nama template_admin pada view.
8. Buat Controller untuk admin, yaitu dengan membuat folder dengan nama admin pada controller. Kemudian buat controller dashboard_admin.php, data_barang.php, data_pelanggan.php . Isi dengan script dibawah ini,
```php
<?php 
//Untuk dashboard_admin.php


class Dashboard_admin extends CI_Controller{
    function __construct() // fngsi yg diakses pertama kali
    {
        parent:: __construct(); 
        if($this->session->userdata('status') != "login"){
            redirect(base_url("login")); 
        }
    }
    public function index() // membuat fungsi
    {
        $this->load->view('templates_admin/head');
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/dashboard');
        $this->load->view('templates_admin/footer');
    }
} 

//Untuk data_barang.php
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

 //Untuk data_pelanggan.php
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

?>
```
9. Untuk dashboard peserta buat controller pada folder controller(tanpa membuat folder baru) dengan nama dashboard.php, kemudian isi dengan script dibawah ini,
```php
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


?>
```
10. Buat controller login untuk admin dengan nama login.php, isi denganscript dibawah ini,
```php
<?php 
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
?>
```
11. Selanjunya membuat modelnya. Buat model dengan nama data_barang.php , data_pelanggan.php dab m_login.php . Isi dengan script dibawah ini,
```php
<?php 
// untuk model barang
class Model_barang extends CI_Model{
    public function tampil_data(){
          return $this->db->get('tb_brg'); // memanggil dari database tabel tb_barang
    }
    public function tambah_barang($data, $table){ // menjalankan fungsi tambah barang
        $this->db->insert($table, $data); // memasukkan ke database
  }
  function edit_barang($where,$table){ // mengedit data dengan menyeleksi query untuk mengedit data		
      return $this->db->get_where($table,$where);
  }
  function update_data($where,$data,$table){ // mengedit data dengan menyeleksi query untuk mengedit data		
      $this->db->where($where);
      $this->db->update($table,$data);
  }
  function hapus_data($where,$table){ // mengedit data dengan menyeleksi query untuk mengedit data		
      $this->db->where($where);
      $this->db->delete($table);
  }
  public function find($id){ // fungsi untuk menangkap id barang kemudian menampilkan di cart
      $result = $this->db->where('id_brg', $id)
                        ->limit(1)
                        ->get('tb_brg');
    if($result->num_rows() > 0) {
        return $result->row();
    }else{
        return array();
    }
  }
}

// untuk model pelanggan
class Model_pelanggan extends CI_Model{
    public function tampil_data(){
          return $this->db->get('tb_pelanggan'); // memanggil tb_pelanggan dari database
    }
    public function tambah_pelanggan($data, $table){ // menjalankan fungsi tambah pelanggan
        $this->db->insert($table, $data); // memasukkan ke database
  }
  function edit_pelanggan($where,$table){ // mengedit data dengan menyeleksi query untuk mengedit data		
      return $this->db->get_where($table,$where);
  }
  function update_pelanggan($where,$data,$table){ // mengedit data dengan menyeleksi query untuk mengedit data		
      $this->db->where($where);
      $this->db->update($table,$data);
  }
  function hapus_data($where,$table){ // mengedit data dengan menyeleksi query untuk mengedit data		
      $this->db->where($where);
      $this->db->delete($table);
  }
}

//untuk model m_login
class M_login extends CI_Model{	
	function cek_login($table,$where){		// memanggil fungsi cek login
		return $this->db->get_where($table,$where);
	}	
}

?>
```
12. Selanjutnya membuat view untuk admin. Buat folder admin pada view kemudian buat file didalamnya dengan nama dashboard.php, data_barang.php, vdata_pelanggan.php, edit_barang.php dan edit_pelanggan.php .Isi dengan script dibawah ini,
```php
<?php 
//untuk dashboard.php
```
<div class = "container-fluid">
     <!-- Content Row -->
     <div class="row">

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
  <div class="card border-left-primary shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings (Monthly)</div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
        </div>
        <div class="col-auto">
          <i class="fas fa-calendar fa-2x text-gray-300"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
  <div class="card border-left-success shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Earnings (Annual)</div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
        </div>
        <div class="col-auto">
          <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
  <div class="card border-left-info shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks</div>
          <div class="row no-gutters align-items-center">
            <div class="col-auto">
              <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
            </div>
            <div class="col">
              <div class="progress progress-sm mr-2">
                <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-auto">
          <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Pending Requests Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
  <div class="card border-left-warning shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Requests</div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
        </div>
        <div class="col-auto">
          <i class="fas fa-comments fa-2x text-gray-300"></i>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<!-- Content Row -->

</div>
```
```php
//untuk data_barang.php
<div class = "container-fluid">
    <button class ="btn btn-sm btn-primary mb-3" data-toggle="modal" data-target="#tambahbarang"><i class="fas da-plus fa-sm"></i>Tambah Barang</button>
    <table class="table table-bordered">
        <tr>
            <th>NO</th>
            <th>NAMA BARANG</th>
            <th>KETERANGAN</th>
            <th>KATEGORI</th>
            <th>HARGA</th>
            <th>STOK</th>
            <th colspan="3">AKSI</th>
        </tr>
        <?php 
        $no=1;
        foreach($barang as $brg): ?> <!--menginisialisasi barang ke variabel brg-->
        <tr>
            <td><?php echo $no++ ?></td>
            <td><?php echo $brg->nama_brg ?></td> <!--menampilkan data barang-->
            <td><?php echo $brg->keterangan ?></td>
            <td><?php echo $brg->kategori ?></td>
            <td><?php echo $brg->harga ?></td>
            <td><?php echo $brg->stok ?></td>
            <!-- <td><?php //echo anchor('admin/data_barang/read/'.$brg->id_brg, '<div class="btn btn-success btn-sm"> <i class ="fas fa-search-plus"></i> </div>') ?></td> -->
            <td><?php echo anchor('admin/data_barang/edit/'.$brg->id_brg, '<div class="btn btn-primary btn-sm"> <i class ="fa fa-edit"></i> </div>') ?></td>  <!--memanggil controller admin/data_barang dengan fungsi edit berdasarkan id-->
            <td><?php echo anchor('admin/data_barang/hapus/'.$brg->id_brg,'<div class="btn btn-danger btn-sm"> <i class ="fa fa-trash"></i> </div>')?></td>  <!--memanggil controller admin_data_barang dengan fungsi hapus berdasarkan id-->
        </tr>

        <?php endforeach;?>
    </table>
</div>
<!-- Modal -->
<div class="modal fade" id="tambahbarang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Form Input Produk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url(). 'admin/data_barang/tambah_aksi' ?>" method="post" enctype="multipart/form-data"> <!--memanggil controller admin_data_barang dengan fungsi tambah aksi-->
           <div class="form-group">
               <label>Nama Barang</label>
               <input type="text" name="nama_brg" class="form-control">
''
           </div>
           <div class="form-group">
               <label>Keterangan</label>
               <input type="text" name="keterangan" class="form-control">
''
           </div>
           <div class="form-group">
               <label>Kategori</label>
               <input type="text" name="kategori" class="form-control">
''
           </div>
           <div class="form-group">
               <label>Harga</label>
               <input type="text" name="harga" class="form-control">
''
           </div>
           <div class="form-group">
               <label>Stok</label>
               <input type="text" name="stok" class="form-control">
''
           </div>
           <div class="form-group">
               <label>Gambar Produk</label><br>
               <input type="file" name="gambar" class="form-control">
''
           </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>

//untuk vdata_pelanggan.php
<div class = "container-fluid">
    <button class ="btn btn-sm btn-primary mb-3" data-toggle="modal" data-target="#tambahpelanggan"><i class="fas da-plus fa-sm"></i>Tambah Pelanggan</button>
    <table class="table table-bordered">
        <tr>
            <th>NO</th>
            <th>NAMA PELANGGAN</th>
            <th>ALAMAT</th>
            <th>USERNAME</th>
            <th>PASSWORD</th>
            <th colspan="3">AKSI</th>
        </tr>
        ''
        <?php 
        $no=1;
        foreach($pelanggan as $plg): ?> <!--menginisialisasi data ke variabel plg-->
        <tr>
            <td><?php echo $no++ ?></td>
            <td><?php echo $plg->nama_plg ?></td> <!--menampilkan data-->
            <td><?php echo $plg->alamat ?></td>
            <td><?php echo $plg->username ?></td>
            <td><?php echo $plg->password ?></td>
            ''
            <!-- <td><?php //echo anchor('admin/data_pelanggan/read/'.$plg->id_plg, '<div class="btn btn-success btn-sm"> <i class ="fas fa-search-plus"></i> </div>') ?></td> -->
            <td><?php echo anchor('admin/data_pelanggan/edit/'.$plg->id_plg, '<div class="btn btn-primary btn-sm"> <i class ="fa fa-edit"></i> </div>') ?></td> <!--memanggil controller admin/data_pelanggan dengan fungsi edit berdasarkan id-->
            <td><?php echo anchor('admin/data_pelanggan/hapus/'.$plg->id_plg,'<div class="btn btn-danger btn-sm"> <i class ="fa fa-trash"></i> </div>')?></td> <!--memanggil controller admin/data_pelanggan dengan fungsi edit berdasarkan id-->
        </tr>

        <?php endforeach;?>
    </table>
</div>
<!-- Modal -->
<div class="modal fade" id="tambahpelanggan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Form Input Pelanggan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url(). 'admin/data_pelanggan/tambah_aksi' ?>" method="post" enctype="multipart/form-data"> <!--memanggil controller admin/data_pelanggan dengan fungsi tambah aksi-->
           <div class="form-group">
               <label>Nama Pelanggan</label>
               <input type="text" name="nama_plg" class="form-control">
''
           </div>
           <div class="form-group">
               <label>Alamat</label>
               <input type="text" name="alamat" class="form-control">
''
           </div>
           <div class="form-group">
               <label>Username</label>
               <input type="text" name="username" class="form-control">
''
           </div>
           <div class="form-group">
               <label>Password</label>
               <input type="text" name="password" class="form-control">
''
           </div>
''          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>

//untuk edit_barang.php
<div class = "container-fluid">
    <h3><i class="fas fa-edit"></i>EDIT DATA BARANG</h3>
```
    <?php foreach($barang as $brg): ?>
        <form method="post"action="<?php echo base_url().'admin/data_barang/update' ?>"> <!--memanggil controller admin/data_barang dengan fungsi update-->
''
        <div class="for-group"> <!--echo $brg ->(nama field) untuk menampilkan datanya-->
                <label>Nama Barang</label>
               <input type="hidden" name="id_brg" class="form-control" value="<?php echo $brg->id_brg ?>">
               <label>Nama Barang</label>
               <input type="text" name="nama_brg" class="form-control" value="<?php echo $brg->nama_brg ?>">
''
           </div>
           <div class="for-group">
               <label>Keterangan</label>
               <input type="text" name="keterangan" class="form-control" value="<?php echo $brg->keterangan ?>">
''
           </div>
           <div class="for-group">
               <label>Kategori</label>
               <input type="text" name="kategori" class="form-control" value="<?php echo $brg->kategori ?>">
''
           </div>
           <div class="for-group">
               <label>Harga</label>
               <input type="text" name="harga" class="form-control" value="<?php echo $brg->harga ?>">
''
           </div>
           <div class="for-group">
               <label>Stok</label>
               <input type="text" name="stok" class="form-control" value="<?php echo $brg->stok ?>">
''
           </div>
           <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
''
        </form>


        <?php endforeach;?>
</div>

//untuk edit_pelanggan.php
<div class = "container-fluid">
    <h3><i class="fas fa-edit"></i>EDIT DATA BARANG</h3>
''
    <?php foreach($pelanggan as $plg): ?>
        <form method="post"action="<?php echo base_url().'admin/data_pelanggan/update' ?>"> <!--memanggil controller admin/data_pelanggans dengan fungsi update-->
''
        <div class="for-group"> <!--echo $brg ->(nama field) untuk menampilkan datanya-->
                <label>Nama Pelanggan</label>
               <input type="hidden" name="id_plg" class="form-control" value="<?php echo $plg->id_plg ?>">
               <label>Nama Pelanggan</label>
               <input type="text" name="nama_plg" class="form-control" value="<?php echo $plg->nama_plg ?>">
''
           </div>
           <div class="for-group">
               <label>Alamat</label>
               <input type="text" name="alamat" class="form-control" value="<?php echo $plg->alamat ?>">
''
           </div>
           <div class="for-group">
               <label>Username</label>
               <input type="text" name="username" class="form-control" value="<?php echo $plg->username ?>">
''
           </div>
           <div class="for-group">
               <label>Password</label>
               <input type="text" name="password" class="form-control" value="<?php echo $plg->password ?>">
''
           </div>
''           
           <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
''
        </form>


        <?php endforeach;?>
</div>
?>
```
13. Untuk dashboard peserta buat tampilan di view (tanpa membuat folder lagi), dengan nama dashboard.php, keranjang.php, pembayaran.php, proses_pesanan.php. Isi dengan script dibawah ini,
```php
<?php 
//untuk dashboard.php
<div class = "container-fluid">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
        <div class="carousel-inner"> <!--membuat carousel atau gambar berslider-->
            <div class="carousel-item active">
            <img src="<?php echo base_url('assets/img/slider1.png') ?>" class="d-block w-100" alt="..."> <!--memanggil gambarnya-->
            </div> 
            <div class="carousel-item">
            <img src="<?php echo base_url('assets/img/slider2.jpg') ?>" class="d-block w-100" alt="...">
            </div>
''            
        </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    <div class="row text-center mt-4 ">
        <?php foreach ($barang as $brg) : ?>
            <div class="card ml-3" style="width: 18rem;"> <!-- Membuat card untuk menampilkan produk-->
                <img src="<?php echo base_url().'uploads/'.$brg->gambar ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title mb-1"><?php echo $brg->nama_brg ?></h5>
                    <small> <?php echo $brg->keterangan ?> </small> <br>
                    <span class="badge badge-success mb-3">Rp.<?php echo number_format($brg->harga), 0,',','.'  ?></span> <br>
                    <?php echo anchor ('dashboard/tambah_ke_keranjang/'.$brg->id_brg, '<div class ="btn btn-sm btn-primary">Tambah Ke Keranjang</div>') ?> <!--memanggil controller tambah_ke_keranjang-->
                    <a href="#" class="btn btn-sm btn-success">Detail</a>
                </div>
            </div>

        <?php endforeach; ?>
''
    </div>
</div>

// untuk keranjang.php
<div class="container-fluid">
    <h4>Keranjang Belanja</h4>
''
    <table class = "table table-bordered table-striped table-hover">
        <tr>
            <th> No </th>
            <th> Nama Produk </th>
            <th> Jumlah </th>
            <th> Harga </th>
            <th> Sub-Total </th>
''
        </tr>
''
        <?php 
        $no=1;
        foreach($this->cart->contents() as $items) : ?> <!--memasukkan cart ke items-->
            <tr>
                <td><?php echo $no++ ?></td>
                <td><?php echo $items['name'] ?></td> <!--menampilkan items name-->
                <td><?php echo $items['qty'] ?></td> <!--menampilkan items qty-->
                <td align="right">Rp. <?php echo number_format($items['price'], 0,',','.') ?></td> <!--menampilkan items price-->
                <td align="right">Rp. <?php echo number_format( $items['subtotal'], 0,',','.') ?></td> <!--menampilkan items subtotal-->
            </tr>
            <?php endforeach; ?>
 ''           
            <tr>
                <td colspan="4"></td>
                <td align="right">Rp. <?php echo number_format($this->cart->total(), 0,',','.' ) ?></td>
            </tr>

        
''
    </table>
    <div align="right">
        <a href="<?php echo base_url('dashboard/hapus_keranjang') ?>"><div class="btn btn-sm btn-danger">Hapus Keranjang</div></a>
        <a href="<?php echo base_url('dashboard/index') ?>"><div class="btn btn-sm btn-primary">Lanjutkan Belanja</div></a>
        <a href="<?php echo base_url('dashboard/pembayaran') ?>"><div class="btn btn-sm btn-success">Pembayaran</div></a>
    </div>

</div>

//untuk pembayaran.php
``
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="btn btn-sm btn-success">
               ```php
                <?php $grand_total = 0;
                if ($keranjang = $this->cart->contents())
                {
                    foreach($keranjang as $items)
                    {
                        $grand_total = $grand_total + $items['subtotal'];
                    }
                echo " <h4>Total Belanja Anda: Rp. ".number_format($grand_total,0,',','.'); // menampilkan grandtotal 
                 ?>
                 ```
            </div> <br></br>
            <h3>Input Alamat Pengiriman dan Pembayaran</h3>
            <form method="post" action="<?php echo base_url('dashboard/proses_pesanan') ?> "> <!--memanggil fungsi proses_pesanan-->
''
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" placeholder="Nama Lengkap Anda" class="form-control">
                </div>
                <div class="form-group">
                    <label>Alamat Lengkap</label>
                    <input type="text" name="alamat" placeholder="Alamat Lengkap Anda" class="form-control" >
                </div>
                <div class="form-group">
                    <label>No Telepon</label>
                    <input type="text" name="no_telp" placeholder="No Telepon" class="form-control">
                </div>
                <div class="form-group">
                    <label>Jasa Pengiriman</label>
                    <select class="form-control">
                        <option>JNE</option>
                        <option>tiki</option>
                        <option>POS INDONESIA</option>
                        <option>GOJEK</option>
                        <option>GRAB</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Pilih Bank</label>
                    <select class="form-control">
                        <option>BCA- XXX</option>
                        <option>BNI- XXX</option>
                        <option>BRI- XXX</option>
                        <option>MANDIRI- XXX</option>
                    </select>
                </div>
                <button type = "submit" class="btn btn-sm btn-primary mb-3">PESAN</button>
''
            </form>
            <?php 
            }else
            {
                echo " <h4> Keranjang Belanja Anda Kosong"; // menampilkan pesan
            }
            ?>
        </div><br></br>
''        
        <div class="col-md-2"></div>
    </div>

</div>

//untuk proses_pesanan.php
``
<div class="container-fluid">
    <div class="alert alert-success"> <!--menampilkan alert-->
    <p class="text-center align-middle">Selamat, Pesanan Anda telah berhasil diproses !</p>
    </div>
</div>

?>
```
14. Kemudian buat tampilan login dengan nama v_login.php, isi dengan script
```
<!DOCTYPE html>
<html lang="en">
    
<head>
	<title>Login V19</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--memasukkan template-->
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="<?= base_url('aset/')?>images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('aset/')?>vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('aset/')?>fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('aset/')?>fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('aset/')?>vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?= base_url('aset/')?>vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('aset/')?>vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('aset/')?>vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?= base_url('aset/')?>vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('aset/')?>css/util.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('aset/')?>css/main.css">
<!--===============================================================================================-->
</head>
<body>
<form action="<?php echo base_url('login/aksi_login'); ?>" method="post"> <!--memanggil controller login dengan method aksi_login-->		
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
				<form class="login100-form validate-form">
					<span class="login100-form-title p-b-33">
						Account Login
					</span>
''
					<div class="wrap-input100 validate-input" >
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>
''
					<div class="wrap-input100 rs1 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>
''
					<div class="container-login100-form-btn m-t-20">
						<button class="login100-form-btn">
							Sign in
						</button>
					</div>
''
					<div class="text-center p-t-45 p-b-4">
						<span class="txt1">
							Forgot
						</span>
''
						<a href="#" class="txt2 hov1">
							Username / Password?
						</a>
					</div>
''
					<div class="text-center">
						<span class="txt1">
							Create an account?
						</span>
''
						<a href="#" class="txt2 hov1">
							Sign up
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
``
	<!--memasukkan template-->
<!--===============================================================================================-->
	<script src="<?= base_url('aset/')?>vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= base_url('aset/')?>vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= base_url('aset/')?>vendor/bootstrap/js/popper.js"></script>
	<script src="<?= base_url('aset/')?>vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= base_url('aset/')?>vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= base_url('aset/')?>vendor/daterangepicker/moment.min.js"></script>
	<script src="<?= base_url('aset/')?>vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="<?= base_url('aset/')?>vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="<?= base_url('aset/')?>js/main.js"></script>

</body>
</html>
```
15 Terakhir masukkan tempate login. Caranya download terlebih dahulu tamplate yang diinginkan. Kemudian ekstrak. kemudian isinya masukkan ke folder dengan nama aset. Setelah itu panggil pada view login.