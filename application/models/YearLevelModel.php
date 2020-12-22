<?php
defined('BASEPATH') or exit('No direct script access allowed');

class YearLevelModel extends CI_Model
{
    function maskYearLevel($yearLevelId)
    {
        $yearLevelTable = $this->Main_model->get_where('year_level', 'id', $yearLevelId)->row();

        return $yearLevelTable->year_level_name;
    }
}
