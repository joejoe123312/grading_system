<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Credentials_model extends CI_Model
{
    function getUserType()
    {
        $credentialsId = $_SESSION['credentialsId'];

        $credentialsTable = $this->Main_model->get_where('credentials', 'id', $credentialsId)->row();

        return $credentialsTable->user_type;
    }
}
