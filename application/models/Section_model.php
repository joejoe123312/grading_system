<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Section_model extends CI_Model
{
    function maskSection($section_id)
    {
        $sectionTable = $this->Main_model->get_where('sections', 'id', $section_id)->row();

        return $sectionTable->section_name;
    }
}
