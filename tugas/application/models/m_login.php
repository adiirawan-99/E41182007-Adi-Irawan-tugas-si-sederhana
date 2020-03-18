<?php 
 
class M_login extends CI_Model{	
	function cek_login($table,$where){		// memanggil fungsi cek login
		return $this->db->get_where($table,$where);
	}	
}