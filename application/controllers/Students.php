<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Students extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Main_model');
        $this->load->model('YearLevelModel');
        $this->load->model('Subject_model');
    }

    function index()
    {
        // get all of the students 
        $data['studentsTable'] = $this->Main_model->get('students', 'id');

        // get all of the year levels
        $data['yearLevelTable'] = $this->Main_model->get('year_level', 'id');

        $this->load->view('includes/header');
        $this->load->view('students', $data);
        $this->load->view('includes/footer');
    }

    function create()
    {
        if (isset($_POST['fname'])) {
            $insert['firstname'] = $this->input->post('fname');
            $insert['middlename'] = $this->input->post('mname');
            $insert['lastname'] = $this->input->post('lname');
            $insert['year_level_id'] = $this->input->post('year_level_id');
            $insert['fullname'] = $this->input->post('full_name');

            $this->Main_model->_insert('students', $insert);
        }
    }

    function refreshTable()
    {
        $studentsTable = $this->Main_model->get('students', 'id');

        $counter = 0;
        foreach ($studentsTable->result() as $row) {
            $counter++;

            echo '
            <tr>
                <td>' . $counter . '</td>
                <td>' . $row->firstname . '</td>
                <td>' . $row->middlename . '</td>
                <td>' . $row->lastname . '</td>
                <td>' . $this->YearLevelModel->maskYearLevel($row->year_level_id) . '</td>
                <td style="display:flex">
                    <button class="btn btn-primary btn-sm edit" value="' . $row->id . '"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger btn-sm delete" value="' . $row->id . '"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            ';
        }
    }

    function delete()
    {
        if (isset($_POST['student_id'])) {
            $studentId = $this->input->post('student_id');

            $this->Main_model->_delete('students', 'id', $studentId);
        }
    }

    function studentInfo()
    {
        if (isset($_POST['student_id'])) {
            $studentId = $this->input->post('student_id');

            $studentTable = $this->Main_model->get_where('students', 'id', $studentId)->result_array();

            echo json_encode($studentTable);
        }
    }

    function update()
    {

        if (isset($_POST['student_id'])) {
            $studentId = $this->input->post('student_id');

            $update['firstname'] = $this->input->post('fName');
            $update['middlename'] = $this->input->post('mName');
            $update['lastname'] = $this->input->post('lName');
            $update['year_level_id'] = $this->input->post('year_level_id');
            $this->Main_model->showNormalArray($update);
            $this->Main_model->_update('students', 'id', $studentId, $update);
        }
    }
}
