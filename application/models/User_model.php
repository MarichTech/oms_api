<?php
    class User_model extends CI_Model{

       //Log user in
        public function login($username, $password){
            //Validate
            $this->db->where('username', $username);
            $this->db->where('password', $password);

            $result = $this->db->get('users');

            if($result->num_rows() == 1){
                //If user exist return the user_id for storage in session when user is logged in
                return $result->row(0)->id;
            } else {
                //Return false if user does not exist in db
                return false;
            }

        }

        public function register($data){
            return $this->db->insert('users', $data);
        }

        public function check_username_exists($username){
            //Check if the username exist in db
            $query = $this->db->get_where('users', array('username' => $username));
            if(empty($query->row_array())){
                //Return true if username exists
                return true;
            } else {
                 //Return false if username doesn't exist
                return false;
            }
        }


        public function check_email_exists($email){
            //Check if the email exist in db
            $query = $this->db->get_where('users', array('email' => $email));
            if(empty($query->row_array())){
                //Return true if email exists
                return true;
            } else {
                //Return false if email doesn't exist
                return false;
            }
        }



    }
?>