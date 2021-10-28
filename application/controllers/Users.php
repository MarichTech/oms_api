<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

	class Users extends RestController{

        public function __construct()
        {
            parent::__construct();

            if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
                // The request is using the POST method
                header('Access-Control-Allow-Headers: x-requested-with');
                header('Access-Control-Allow-Methods: *');
                header('Access-Control-Allow-Origin: *');
            } else {
                header('Access-Control-Allow-Origin: *');
                header('Content-type: application/json');
            }
           
        }


        //User Registration
		public function register(){

                //Encrypt password
                $enc_password = md5($this->input->post('password'));

                //User data array
                $data = array(
                    'name' => $this->input->post('name'),
                    'username' => $this->input->post('username'),
                    'email' => $this->input->post('email'),
                    'password' => $enc_password,
                );
               
                //Register 
                $this->user_model->register($data);

                if($result > 0)
                {
                    $this->response([
                        'status' => true,
                        'message' => 'USER REGISTERED'
                    ], 200); 
                }
                else
                {
                    $this->response([
                        'status' => false,
                        'message' => 'FAILED TO REGISTER USER'
                    ],  400);
                }

		}

        //User Login
        public function login(){
            // Check if user is Logged In
            if($this->session->userdata('logged_in')){
                redirect('accounts');
            }

            $data['title'] = 'Sign In';

            $this->form_validation->set_rules('username','Username', 'required');
            $this->form_validation->set_rules('password','Password', 'required');
            $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

            if($this->form_validation->run() === FALSE){
                $this->load->view('templates/header');
                $this->load->view('users/login', $data);
                $this->load->view('templates/footer');

            }else{
                //Get username
                $username = $this->input->post('username');
                $password = md5($this->input->post('password'));

                //Login user
                $user_id = $this->user_model->login($username, $password);

                print_r($user_id);
                
                if($user_id){
                    //Create session
                    $user_data = array(
                        'user_id' => $user_id,
                        'username' => $username,
                        'logged_in' => true
                    );

                    $this->session->set_userdata($user_data);

                    //Set message
                    $this->session->set_flashdata('user_loggedin', 'You are now logged in');
                    redirect('accounts');
                }else{
                    $this->session->set_flashdata('login_failed', 'Your Password is Incorrect');
                     redirect('users/login');
                }
               
            }
        }

        public function logout(){
           //Unset user data
           $this->session->unset_userdata('logged_in');
           $this->session->unset_userdata('user_id');
           $this->session->unset_userdata('username'); 

           //Set message
           $this->session->set_flashdata('user_loggedout', 'You are now logged out');
           redirect('users/login');
        }



        //Check if username exists (return true for registration)
        function check_username_exists($username){
            $this->form_validation->set_message('check_username_exists','That username is taken. Please choose a different one');

            if($this->user_model->check_username_exists($username)){
                return true;
            } else {
                return false;
            }
        }

         //Check if email exists
        function check_email_exists($email){
            $this->form_validation->set_message('check_email_exists','That email is taken. Please choose a different one');

            if($this->user_model->check_email_exists($email)){
                return true;
            } else {
                return false;
            }
        }

         //Ensure username exists (Before user login)
        function check_username_exists_login($username){
            $this->form_validation->set_message('check_username_exists_login','The Username does not exist. Register first before Trying to LogIn');

            if($this->user_model->check_username_exists($username)){
                return false;
            } else {
                return true;
            }
        }
	}