<?php
    class Opportunity_model extends CI_Model{

        public function _construct(){
            $this->load->database();
        }

        public function get_opportunity($id){
            //Get a single opportunity by id
            $query = $this->db->get_where('opportunities', array('id' => $id));
            return $query->row_array();
        }

        public function get_account_opportunities($id){
           //Get all account opportunities
            $query = $this->db->get_where('opportunities', array('account_id' => $id));
            return $query->result_array();
        }

        public function insert_opportunity($data){
            //Insert $data into the db
           


            return $this->db->insert('opportunities', $data);
        }


        public function delete_opportunity($id){
            //Delete an opportunity from db using passed id
            return $this->db->delete('opportunities', ['id' => $id]);
        }

         public function update_opportunity($data, $id){
            //Update $data in the db
            //Update data by the use of passed id
            $this->db->where('id', $id);
           return $this->db->update('opportunities', $data);
        }



    }
    ?>