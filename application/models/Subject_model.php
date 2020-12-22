<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subject_model extends CI_Model
{
    function maskSubject($subjectId)
    {
        $subjectTable = $this->Main_model->get_where('subjects', 'id', $subjectId)->row();

        return $subjectTable->subject_name;
    }
}
