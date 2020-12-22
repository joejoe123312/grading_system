<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Main_model');
    }

    public function index()
    {
        $this->load->view('includes/header');
        $this->load->view('dashboard');
        $this->load->view('includes/footer');
    }
}
