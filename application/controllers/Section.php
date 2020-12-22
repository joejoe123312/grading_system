<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Section extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Main_model');
        $this->load->model('YearLevelModel');
    }

    function index()
    {
        //get all of the sections in the db
        $data['sectionTable'] = $this->Main_model->get('sections', 'id');

        //get year level 
        $data['yearLevelTable'] = $this->Main_model->get('year_level', 'id');

        $this->load->view('includes/header');
        $this->load->view('sections', $data);
        $this->load->view('includes/footer');
    }

    function createSectionName()
    {
        if (isset($_POST['section_name'])) {
            $insert['section_name'] = $this->input->post('section_name');
            $insert['year_level_id'] = $this->input->post('year_level_id');

            $this->Main_model->_insert('sections', $insert);
        }
    }

    function maskYearLevel()
    {
        if (isset($_POST['year_level_id'])) {
            $yearLevelId = $this->input->post('year_level_id');

            $yearlevelName = $this->YearLevelModel->maskYearLevel($yearLevelId);

            echo $yearlevelName;
        }
    }

    function refreshTable()
    {
        $sectionTable = $this->Main_model->get('sections', 'id');

        $counter = 0;
        foreach ($sectionTable->result() as $row) {
            $counter++;
            echo '
            <tr>
                <td>' . $counter . '</td>
                <td>' . $row->section_name . '</td>
                <td>' . $this->YearLevelModel->maskYearLevel($row->year_level_id) . '</td>
                <td>
                    <button class="btn btn-primary btn-sm edit" value="' . $row->id . '"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger btn-sm delete" value="' . $row->id . '"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            ';
        }
    }

    function deleteSection()
    {
        if (isset($_POST['section_id'])) {
            $sectionId = $this->input->post('section_id');

            $this->Main_model->_delete('sections', 'id', $sectionId);
        }
    }

    function getSectionIfo()
    {
        if (isset($_POST['section_id'])) {
            $sectionId = $this->input->post('section_id');

            $sectionTable = $this->Main_model->get_where('sections', 'id', $sectionId)->result_array();

            echo json_encode($sectionTable);
        }
    }

    function updateSection()
    {
        if (isset($_POST['section_id'])) {
            $sectionId = $this->input->post('section_id');
            $update['section_name'] = $this->input->post('section_name');
            $update['year_level_id'] = $this->input->post('year_level_id');

            $this->Main_model->_update('sections', 'id', $sectionId, $update);
        }
    }
}
