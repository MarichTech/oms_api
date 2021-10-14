<?php
    class Account_model extends CI_Model{

        public function _construct(){

         

            $this->load->database();

       
        }

        public function get_account($id){
            //Get a single account by id
            $query = $this->db->get_where('accounts', array('id' => $id));
            return $query->row_array();
        }

        public function user_accounts($id){
            //Get all user accounts
            $query = $this->db->get_where('accounts', array('user_id' => $id));
            return $query->result_array();
        }

        public function insert_account($data){
            //Insert $data into the db
            return $this->db->insert('accounts', $data);
        }

        public function delete_account($id){
            //Delete an account from db using passed id
            return $this->db->delete('accounts', ['id' => $id]);
        }

         public function update_account($data, $id){
           //Update $data in the db
           //Update data by the use of passed id
           $this->db->where('id', $id);
           return $this->db->update('accounts', $data);
        }



    }
    ?>