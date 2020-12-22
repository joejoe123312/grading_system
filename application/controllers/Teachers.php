<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Teachers extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Main_model');
    }

    public function index()
    {
        // get all of the teachers account
        $data['teacherTable'] = $this->Main_model->get('teachers', 'id');

        $this->load->view('includes/header');
        $this->load->view('teachers', $data);
        $this->load->view('includes/footer');
    }

    function registerTeacher()
    {
        if (isset($_POST['first_name'])) {
            $insert['firstname'] = $this->input->post('first_name');
            $insert['middlename'] = $this->input->post('middle_name');
            $insert['lastname'] = $this->input->post('last_name');
            $this->Main_model->_insert('teachers', $insert);
        }
    }

    function refreshTeacherTable()
    {
        // get all of the teachers
        $teacherTable = $this->Main_model->get('teachers', 'id');

        $counter = 0;
        foreach ($teacherTable->result() as $row) {
            $counter++;
            echo '
            <tr>
                <td>' . $counter . '</td>
                <td>' . ucfirst($row->firstname) . '</td>
                <td>' . ucfirst($row->middlename) . '</td>
                <td>' . ucfirst($row->lastname) . '</td>
                <td>
                    <button class="btn btn-primary btn-sm edit" value="' . $row->id . '"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger btn-sm delete" value="' . $row->id . '"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        ';
        }
    }

    function deleteTeacher()
    {
        if (isset($_POST['teacher_id'])) {
            $teacherId = $this->input->post('teacher_id');

            //delete the teacher in the db
            $this->Main_model->_delete('teachers', 'id', $teacherId);
        }
    }

    function getTeacherData()
    {
        if (isset($_POST['teacher_id'])) {
            $teacherId = $this->input->post('teacher_id');

            //get the info by teacher id
            $teacherTable = $this->Main_model->get_where('teachers', 'id', $teacherId)->result_array();

            $json = json_encode($teacherTable);

            echo $json;
        }
    }

    function updateTeacherInfo()
    {

        if (isset($_POST['teacher_id'])) {
            $teacherId = $this->input->post('teacher_id');
            $update['firstname'] = $this->input->post('first_name');
            $update['middlename'] = $this->input->post('middle_name');
            $update['lastname'] = $this->input->post('last_name');

            //update the teacher's info in the db
            $this->Main_model->_update('teachers', 'id', $teacherId, $update);

            echo $update['firstname'] . ' ' . $update['middlename'] . ' ' . $update['lastname'];
        }
    }
}
