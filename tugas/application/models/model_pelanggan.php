<?php
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