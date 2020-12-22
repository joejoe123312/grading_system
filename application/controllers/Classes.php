<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Classes extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Main_model');
        $this->load->model('YearLevelModel');
        $this->load->model('Subject_model');
        $this->load->model('Section_model');
    }

    function index()
    {
        // get all of the classes data
        $data['classTable'] = $this->Main_model->get('class', 'id');

        //get all of the subject
        $data['subjectTable'] = $this->Main_model->get('subjects', 'id');

        // get all of the teachers
        $data['teacherTable'] = $this->Main_model->get('teachers', 'id');

        // get all of the teachers
        $data['yearLevelTable'] = $this->Main_model->get('year_level', 'id');

        // get all of the teachers
        $data['sectionTable'] = $this->Main_model->get('sections', 'id');


        $this->load->view('includes/header');
        $this->load->view('classes', $data);
        $this->load->view('includes/footer');
    }

    function createClass()
    {
        if (isset($_POST['subject_id'])) {
            $insert['subject_id'] = $this->input->post('subject_id');
            $insert['teacher_Id'] = $this->input->post('teacher_id');
            $insert['year_level_id'] = $this->input->post('year_level_id');
            $insert['section_id'] = $this->input->post('section_id');

            $this->Main_model->_insert('class', $insert);
        }
    }

    function refreshTable()
    {
        // get all of the subjects classes
        $classTable = $this->Main_model->get('class', 'id');
        $counter = 0;

        foreach ($classTable->result() as $row) {
            $counter++;
            echo '
            <tr>
                <td>' . $counter  . '</td>
                <td>' . $this->Subject_model->maskSubject($row->subject_id) . '</td>
                <td>' . $this->Main_model->getFullName('teachers', 'id', $row->teacher_id)  . '</td>
                <td>' . $this->YearLevelModel->maskYearLevel($row->year_level_id)  . '</td>
                <td>' . $this->Section_model->maskSection($row->section_id) . '</td>
                <td style="display:flex">
                    <button class="btn btn-primary btn-sm edit" value="' . $row->id  . '"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger btn-sm delete" value="' . $row->id  . '"><i class="fas fa-trash"></i></button>
                    <button class="btn btn-dark btn-sm view" value="' . $row->id  . '"><i class="fas fa-user"></i></button>
                </td>
            </tr>
            ';
        }
    }

    function deleteClass()
    {
        if (isset($_POST['class_id'])) {
            $classId = $this->input->post('class_id');

            //delete in the db
            $this->Main_model->_delete('class', 'id', $classId);
        }
    }

    function getInfo()
    {
        if (isset($_POST['class_id'])) {
            $classId = $this->input->post('class_id');

            // get info about the class
            $classTable = $this->Main_model->get_where('class', 'id', $classId)->result_array();

            echo json_encode($classTable);
        }
    }

    function maskSubjectId()
    {
        if (isset($_POST['subject_id'])) {
            $subjectId = $this->input->post('subject_id');

            $subjectName = $this->Subject_model->maskSubject($subjectId);

            echo $subjectName;
        }
    }

    function maskYearLevel()
    {
        if (isset($_POST['year_level_id'])) {
            $yearLevelId = $this->input->post('year_level_id');

            $yearLevelName = $this->YearLevelModel->maskYearLevel($yearLevelId);

            echo $yearLevelName;
        }
    }

    function maskTeacher()
    {
        if (isset($_POST['teacher_id'])) {
            $teacherId = $this->input->post('teacher_id');

            $teacherName = $this->Main_model->getFullName('teachers', 'id', $teacherId);

            echo $teacherName;
        }
    }

    function update() //udpate class but not the students
    {
        if (isset($_POST['class_id'])) {
            $classId = $this->input->post('class_id');
            $update['subject_id'] = $this->input->post('subject_id');
            $update['teacher_id'] = $this->input->post('teacher_id');
            $update['year_level_id'] = $this->input->post('year_level_id');
            $update['section_id'] = $this->input->post('section_id');

            $this->Main_model->_update('class', 'id', $classId, $update);
        }
    }

    function getAllStudents()
    {
        // get all of the students
        $studentTable = $this->Main_model->get('students', 'id');

        $namesArray = array();

        foreach ($studentTable->result() as $row) {
            //get the full name
            $firstname = $row->firstname;
            $middlename = $row->middlename;
            $lastname = $row->lastname;

            $fullName = "$firstname $middlename $lastname";

            array_push($namesArray, $fullName);
        }

        echo json_encode($namesArray);
    }

    function getStudentIdByFullName($fullName)
    {
        $studentTable = $this->Main_model->get_where('students', 'fullname', $fullName)->row();

        return $studentTable->id;
    }

    function insertIntoClass()
    {
        if (isset($_POST['class_id'])) {
            $classId = $this->input->post('class_id');
            $fullName = $this->input->post('fullname');

            // get the student id by full name
            $studentId = $this->getStudentIdByFullName($fullName);

            // get the values of the class id
            $classTable = $this->Main_model->get_where('class', 'id', $classId)->row();

            $teacherId = $classTable->teacher_id;
            $year_level_id = $classTable->year_level_id;
            $subject_id = $classTable->subject_id;
            $section_id = $classTable->section_id;

            // prepare class_group insertion 
            $insert['student_id'] = $studentId;
            $insert['teacher_id'] = $teacherId;
            $insert['year_level_id'] = $year_level_id;
            $insert['subject_id'] = $subject_id;
            $insert['section_id'] = $section_id;
            $insert['class_id'] = $classId;

            $this->Main_model->_insert('class_group', $insert);
        }
    }

    function refreshStudentTable()
    {

        if (isset($_POST['class_id'])) {
            $classId = $this->input->post('class_id');

            $classGroupTable = $this->Main_model->get_where('class_group', 'class_id', $classId);

            $counter = 0;
            foreach ($classGroupTable->result() as $row) {
                $counter++;

                $fullNameSliced = $this->Main_model->getNameSliced('students', 'id', $row->student_id);
                echo '
                <tr>
                    <td>' . $counter . '</td>
                    <td>' . $fullNameSliced['firstname'] . '</td>
                    <td>' . $fullNameSliced['middlename'] . '</td>
                    <td>' . $fullNameSliced['lastname'] . '</td>
                    <td>' . $this->Section_model->maskSection($row->section_id) . '</td>
                    <td>
                        <button class="btn btn-danger btn-sm deleteStudent" value="' . $row->id . '"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                ';
            }
        }
    }

    function deleteClassStudent()
    {
        if (isset($_POST['class_group_id'])) {
            $classGroupId = $this->input->post('class_group_id');

            // echo out class id 
            $classTable = $this->Main_model->get_where('class_group', 'id', $classGroupId)->row();

            echo $classTable->class_id;

            // delete the 
            $this->Main_model->_delete('class_group', 'id', $classGroupId);
        }
    }
}
