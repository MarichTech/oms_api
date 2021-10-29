<?php
    class Students_model extends CI_Model{

        public function _construct(){
            $this->load->database();
            $this->table = 'mscholar';
        }

        private $_batchImport;
 
        public function setBatchImport($batchImport) {
            $this->_batchImport = $batchImport;
        }
     
        // save data
        public function importData() {
            $data = $this->_batchImport;
            return $this->db->insert_batch('mscholar', $data);
        }

        public function get_students($school){
                //Get a single account by id
                
                $query = $this->db->get_where('mscholar', array('type' => "Student"), array('school' => $school));
                return $query->result_array();
        }

        public function get($where = 0) {
            //$name, $email
		//$query = $this->db->get('mscholar', array('fullnames' => $name), array('email' => $email));
		//return $query->row();

        if($where) 
			$this->db->where($where);
		$query = $this->db->get($this->table);
		return $query->row();
	}

        public function get_student($id){
            //Get a single account by id
           
            $query = $this->db->get_where('mscholar', array('id' => $id), array('type' => "Student"));
            return $query->row_array();
        }

     

        public function add_student($data){
            //Insert $data into the db
            return $this->db->insert('mscholar', $data);
        }

        public function delete_student($id){
            //Delete an account from db using passed id
            return $this->db->delete('mscholar', ['id' => $id]);
        }

         public function update_student($data, $id){
           //Update $data in the db
           //Update data by the use of passed id
           $this->db->where('id', $id);
           return $this->db->update('mscholar', $data);
        }



    }
    ?>