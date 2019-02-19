<?php
class Users extends Controller{
	protected function register(){
		$viewmodel = new UserModel();
		$this->returnView($viewmodel->register());
	}

	protected function login(){
		$viewmodel = new UserModel();
		$this->returnView($viewmodel->login());
	}

	protected function logout(){
		unset($_SESSION['is_logged_in']);
		unset($_SESSION['user_data']);
		session_destroy();
		// Redirect
		header('Location: '.ROOT_URL);
	}
}