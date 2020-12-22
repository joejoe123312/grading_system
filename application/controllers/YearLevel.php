<?php
defined('BASEPATH') or exit('No direct script access allowed');

class YearLevel extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Main_model');
    }

    public function index()
    {
        // get all of the teachers account
        $data['yearLevelTable'] = $this->Main_model->get('year_level', 'id');

        $this->load->view('includes/header');
        $this->load->view('yearLevel', $data);
        $this->load->view('includes/footer');
    }

    function createYearLevel()
    {
        if (isset($_POST['year_level'])) {
            $insert['year_level_name'] = $this->input->post('year_level');

            $this->Main_model->_insert('year_level', $insert);
        }
    }

    function refreshTable()
    {
        //get the year level 
        $yearLevelTable = $this->Main_model->get('year_level', 'id');

        $counter = 0;
        foreach ($yearLevelTable->result() as $row) {
            $counter++;
            echo '
            <tr>
                <td>' . $counter . '</td>
                <td>' . $row->year_level_name . '</td>
                <td>
                    <button class="btn btn-primary btn-sm edit" value="' . $row->id . '"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger btn-sm delete" value="' . $row->id . '"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            ';
        }
    }

    function deleteYearLevel()
    {
        if (isset($_POST['year_level_id'])) {
            $yearLevelId = $this->input->post('year_level_id');

            //delete in the database
            $this->Main_model->_delete('year_level', 'id', $yearLevelId);
        }
    }

    function getYearLevelInfo()
    {
        if (isset($_POST['year_level_id'])) {
            $yearLevelId = $this->input->post('year_level_id');

            $yearLevelTable = $this->Main_model->get_where('year_level', 'id', $yearLevelId)->result_array();

            echo json_encode($yearLevelTable);
        }
    }

    function updateYearLevel()
    {
        if (isset($_POST['year_level_id'])) {
            $yearLevelId = $this->input->post('year_level_id');
            $yearLevelName = $this->input->post('year_level_name');

            $update['year_level_name'] = $yearLevelName;
            $this->Main_model->_update('year_level', 'id', $yearLevelId, $update);
        }
    }
}
