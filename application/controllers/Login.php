<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Main_model');
	}

	public function index()
	{
		//notifications
		$this->Main_model->alertPromt('Invalid user', 'userInvalid');
		$this->Main_model->alertPromt('Register Success', 'registerSuccess');

		$postNames['username'] = 'Username';
		$postNames['password'] = 'Password';
		if ($this->Main_model->formValidation($postNames)) {
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			//validate username and password
			$where['username'] = $username;
			$where['password'] = $this->Main_model->passwordEncryptor($password);
			$credentialsTable = $this->Main_model->multiple_where('credentials', $where);

			if (count($credentialsTable->result_array()) != 0) {
				//meron siyang nahanap

				//validate and take account the user type
				$credentialsTable = $credentialsTable->row();
				$this->session->set_userdata('credentialsId', $credentialsTable->id);
				redirect('Dashboard');
			} else {
				//wala siyang nahanap
				$this->session->set_userdata('userInvalid', 1);
				redirect('Login');
			}
		}
		// $this->load->view('includes/header');
		$this->load->view('login');
		// $this->load->view('includes/footer');
	}

	function changePassword()
	{
		//notifications
		$this->Main_model->alertPromt('Current password incorrect', 'currentPasswordWrong');
		$this->Main_model->alertPromt('Confirm password not the same', 'confirmPasswordWrong');
		$this->Main_model->alertPromt('Password changed successfully', 'changedPassword');

		$this->form_validation->set_rules('currentPassword', 'Current Password', 'required');
		$this->form_validation->set_rules('newPassword', 'New Password', 'required');
		$this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'required');
		if ($this->form_validation->run()) {
			$currentPassword = $this->input->post('currentPassword');
			$newPassword = $this->input->post('newPassword');
			$confirmPassword = $this->input->post('confirmPassword');

			//validate current password
			$where['id'] = $_SESSION['credentials_id'];
			$where['password'] = $this->Main_model->passwordEncryptor($currentPassword);
			$credentialsTable = $this->Main_model->multiple_where('credentials', $where);

			if (count($credentialsTable->result_array()) == 0) {
				//wala siyang nahanap meaning wrong password
				$this->session->set_userdata('currentPasswordWrong', 1);
				redirect("Login/changePassword");
			}

			//validate newPassword and confirm password
			if ($newPassword != $confirmPassword) {
				$this->session->set_userdata('confirmPasswordWrong', 1);
				redirect("Login/changePassword");
			}

			//change the password
			$update['password'] = $this->Main_model->passwordEncryptor($newPassword);
			$this->Main_model->_update('credentials', 'id', $_SESSION['credentials_id'], $update);

			#notify and redirect
			$this->session->set_userdata('changedPassword', 1);
			redirect("Login/changePassword");
		}

		$this->load->view('changePassword');
	}

	function logout()
	{
		session_destroy();
		redirect('Login');
	}
}
