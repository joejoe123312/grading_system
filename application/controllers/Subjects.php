<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subjects extends CI_Controller
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
        // get all of the classes data
        $data['subjectTable'] = $this->Main_model->get('subjects', 'id');

        $this->load->view('includes/header');
        $this->load->view('subjects', $data);
        $this->load->view('includes/footer');
    }

    function createSubject()
    {
        if (isset($_POST['subject_name'])) {
            $insert['subject_name'] = $this->input->post('subject_name');
            $this->Main_model->_insert('subjects', $insert);
        }
    }

    function refreshTable()
    {
        // get all of the subjects
        $subjectTable = $this->Main_model->get('subjects', 'id');

        $counter = 0;
        foreach ($subjectTable->result() as $row) {
            $counter++;
            echo '
            <tr>
                <td> ' . $counter . ' </td>
                <td> ' . $this->Subject_model->maskSubject($row->id) . ' </td>
                <td>
                    <button class="btn btn-primary btn-sm edit" value=" ' . $row->id . ' "><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger btn-sm delete" value=" ' . $row->id . ' "><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            ';
        }
    }

    function deleteSubject()
    {
        if (isset($_POST['subject_id'])) {
            $subjectId = $this->input->post('subject_id');

            $this->Main_model->_delete('subjects', 'id', $subjectId);
        }
    }

    function getSubjectInfo()
    {
        if (isset($_POST['subject_id'])) {
            $subjectId = $this->input->post('subject_id');
            $subjectTable = $this->Main_model->get_where('subjects', 'id', $subjectId)->row();

            echo $subjectTable->subject_name;
        }
    }

    function updateSubject()
    {
        if (isset($_POST['subject_id'])) {
            $subjectId = $this->input->post('subject_id');
            $update['subject_name'] = $this->input->post('subject_name');

            $this->Main_model->_update('subjects', 'id', $subjectId, $update);
        }
    }
}
