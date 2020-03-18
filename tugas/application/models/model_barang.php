<?php
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