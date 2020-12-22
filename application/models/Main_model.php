<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main_model extends CI_Model
{



    //every time you will click a new nav. the system will let you 
    //login again to access the voucher sending
    function removeUserVoucherAuthenticated()
    {
        unset($_SESSION['userVoucherAuthenticated']);
    }

    function deactivateActivators()
    {
        //SET PAGE ACTIVATORS
        $data['active1'] = null;
        $data['active2'] = null;
        $data['active3'] = null;
        $data['active4'] = null;
        $data['active5'] = null;
        $data['active6'] = null;
        $data['active7'] = null;
        $data['active8'] = null;
        $data['active8'] = null;
        $data['active9'] = null;
        $data['active10'] = null;
        $this->session->set_userdata($data);
    }

    function activateCurrentNav($x)
    {
        $this->deactivateActivators();
        switch ($x) {
            case 1:
                $this->session->set_userdata('active1', 'active');
                break;
            case 2:
                $this->session->set_userdata('active2', 'active');
                break;
            case 3:
                $this->session->set_userdata('active3', 'active');
                break;

            case 4:
                $this->session->set_userdata('active4', 'active');
                break;
            case 5:
                $this->session->set_userdata('active5', 'active');
                break;
            case 6:
                $this->session->set_userdata('active6', 'active');
                break;
            case 7:
                $this->session->set_userdata('active7', 'active');
                break;

            case 8:
                $this->session->set_userdata('active8', 'active');
                break;
            case 9:
                $this->session->set_userdata('active9', 'active');
                break;
            default:
                # code...
                break;
        }
    }

    function accessGranted()
    {
        $accountId = isset($_SESSION['account_id']);
        $authenticator = isset($_SESSION['vc555']);



        if (($accountId != Null) && ($authenticator != Null)) {
            return true;
        } else {
            $this->session->set_userdata('notLogin', 1);
        }


        if (isset($_SESSION['notLogin'])) {
            unset($_SESSION['notLogin']);
            session_destroy();

            redirect('Main_controller');
        }
        // echo "terminated";

    }

    function get($table, $order_by)  //ascending order
    {
        $this->db->order_by($order_by, "desc");
        $query = $this->db->get($table);
        return $query;
    }

    function getNameSliced($table, $column, $teacherId)
    {
        $table = $this->Main_model->get_where($table, $column, $teacherId);

        foreach ($table->result() as $row) {
            $data['firstname'] = $row->firstname;
            $data['middlename'] = $row->middlename;
            $data['lastname'] = $row->lastname;
        }
        return $data;
    }

    function getFullName($table, $column, $teacherId)
    {
        $table = $this->Main_model->get_where($table, $column, $teacherId);
        if (count($table->result_array()) != 0) {
            foreach ($table->result() as $row) {
                $firstname = ucfirst($row->firstname);
                $middlename = ucfirst($row->middlename);
                $lastname = ucfirst($row->lastname);

                $fullName = "$firstname $middlename $lastname";
            }

            return $fullName;
        } else {
            //wala siyang nahanap 
            return null;
        }
    }

    function getFullNameSliced($table, $column, $teacherId)
    {
        $table = $this->Main_model->get_where($table, $column, $teacherId);

        foreach ($table->result() as $row) {
            $data['firstname'] = ucfirst($row->firstname);
            $data['lastname'] = ucfirst($row->lastname);
        }
        return $data;
    }

    function get_where($table, $db_column_name, $value)
    {
        $this->db->where($db_column_name, $value);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get($table);
        return $query;
    }

    function getWhereLimit($table, $db_column_name, $value)
    {
        $this->db->where($db_column_name, $value);
        $this->db->limit(5);
        $query = $this->db->get($table);
        return $query;
    }

    function get_where_limit($table, $db_column_name, $value, $limit)
    {
        $this->db->where($db_column_name, $value);
        $this->db->limit($limit);
        $query = $this->db->get($table)->result();
        return $query;
    }


    function multiple_where($table_name, $array)
    {
        $this->db->where($array);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get($table_name);

        return $query;
    }

    function passwordEncryptor($string)
    {
        $string = hash('md5', $string);
        return $string;
    }

    function array_show($array)
    {
        echo "<pre>";
        print_r($array->result_array());
        echo "</pre>";
    }

    function alertDanger($sessionName, $alert_message)
    {
        if (isset($_SESSION["$sessionName"])) {
            echo "<div class='alert alert-danger' id='alert'>";
            echo    $alert_message;
            echo "</div>";
            unset($_SESSION["$sessionName"]);
        }
    }

    function alertSuccess($sessionName, $alert_message)
    {
        if (isset($_SESSION["$sessionName"])) {
            echo "<div class='alert alert-success' id='alert'>";
            echo    $alert_message;
            echo "</div>";
            unset($_SESSION["$sessionName"]);
        }
    }

    function alertWarning($sessionName, $alert_message)
    {
        if (isset($_SESSION["$sessionName"])) {
            echo "<div class='alert alert-warning' id='alert'>";
            echo    $alert_message;
            echo "</div>";
            unset($_SESSION["$sessionName"]);
        }
    }

    function seeAllSessions()
    {
        echo "<pre>" . print_r($_SESSION, true) . "</pre>";
    }

    function _insert($table_name, $data)
    {
        $table = $table_name;
        $this->db->insert($table, $data);
        // OPTIONAL: Return ID of inserted table for Reference purposes
        return $this->db->insert_id();
    }

    function _update($table_name, $column_id_name, $id, $data)
    {
        $table = $table_name;
        $this->db->where($column_id_name, $id);
        $this->db->update($table, $data);
    }

    function _multi_update($table_name, $where, $update)
    {
        $this->db->where($where);
        $this->db->update($table_name, $update);
    }

    function _delete($table, $column_id_name, $id)
    {
        $this->db->where($column_id_name, $id);
        $this->db->delete($table);
    }

    function multiple_delete($table, $data)
    {
        $this->db->delete($table, $data);
    }


    function accountDuplicationChecker($table, $data, $redirect) //accountDuplication
    {
        $table = $this->multiple_where($table, $data);

        if (count($table->result_array()) != 0) {
            $this->session->set_userdata('accountDuplication', 1);
            redirect($redirect);
        }
    }

    function showNormalArray($array)
    {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }

    function alertPromt($message, $sessionName)
    {
        if (isset($_SESSION[$sessionName])) {
            echo '<script>alert("' . $message . '");</script>';
            unset($_SESSION[$sessionName]);
        }
    }

    function findId($table, $array, $columnId)
    {
        $table = $this->multiple_where($table, $array);
        foreach ($table->result() as $row) {
            return $row->$columnId;
        }
    }

    function notifyAndRedirect($sessionName, $redirect)
    {
        $this->session->set_userdata($sessionName, 1);
        redirect($redirect);
    }

    function formValidation($postNames)
    {
        foreach ($postNames as $key => $value) {
            $this->form_validation->set_rules($key, $value, 'required');
        }

        return $this->form_validation->run();
    }
}
