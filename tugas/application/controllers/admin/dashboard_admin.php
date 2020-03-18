<?php 

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