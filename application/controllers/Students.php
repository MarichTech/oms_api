<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    class Students extends RestController{

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

            $this->load->model("students_model", "students");

         
           
        }

        public function get_students_get(){


            //Get a single account
              $data= $this->students->get_students();
  
              //Check if Accounts exist else display accounts not found
              if(empty($data)){
  
                  $this->response([
                      'status' => false,
                      'message' => 'STUDENTS NOT FOUND'
                  ],  400);
  
                }else{
                  $this->response($data, 200);
  
                }   
          }

          public function get_student_get($id){
            //Get a single account
              $data['students'] = $this->students->get_student($id);
  
              //Check if Accounts exist else display accounts not found
              if(empty($data['students'])){
  
                  $this->response([
                      'status' => false,
                      'message' => 'STUDENT NOT FOUND'
                  ],  400);
  
                }else{
                  $this->response($data, 200);
  
                }   
          }


        public function add_student_post(){

            $data = array(
                //Format 'name_of_db_column' => data you want to store in the column(you can use post to get data from form)
                'fullnames'=> $this->input->post('fullnames'),
                'email' => $this->input->post('email'),
                'school' => $this->input->post('school'),
                'phone_no' => $this->input->post('phone_no'),
                'nationality' => $this->input->post('nationality'),
                'type' => $this->input->post('type'),
    
               );
               
                //Create Account
                $result =  $this->students->add_student($data);
  

                if($result > 0)
                {
                    $this->response([
                        'status' => true,
                        'message' => 'STUDENT ADDED'
                    ], 200); 
                }
                else
                {
                    $this->response([
                        'status' => false,
                        'message' => 'FAILED TO ADD STUDENT'
                    ],  400);
                }
   
        }

        public function delete_student_delete($id){
            //Delete Account
            $result = $this->students->delete_student($id);

            if($result > 0)
            {
                $this->response([
                    'status' => true,
                    'message' => 'STUDENT DELETED'
                ], RestController::HTTP_OK); 
            }
            else
            {
                $this->response([
                    'status' => false,
                    'message' => 'FAILED TO DELETE STUDENT'
                ],  400);
            }
        }


        public function update_put(){ 

            $id = $this->input->post("id");

             $data = array(
                'fullname'=> $this->input->post('fullname'),
                'email' => $this->input->post('email'),
                'school' => $this->input->post('school'),
                'phone_no' => $this->input->post('phone_no'),
                'nationality' => $this->input->post('nationality'),
                'type' => $this->input->post('type'),
    
               );
               
                //Update Account
                $result =  $this->students->update_student($data, $id);

                if($result > 0)
                {
                    $this->response([
                        'status' => true,
                        'message' => 'STUDENT UPDATED'
                    ], RestController::HTTP_OK); 
                }
                else
                {
                    $this->response([
                        'status' => false,
                        'message' => 'FAILED TO UPDATE STUDENT'
                    ],  400);
                }

        }



        public function importStudents_post()
        {

        $path 		= 'documents/users/';
		$json 		= [];
		$this->upload_config($path);
		if (!$this->upload->do_upload('doc')) {

            $this->response([
                'status' => false,
                'message' => showErrorMessage($this->upload->display_errors()),
            ],  400);
		} else {
			$file_data 	= $this->upload->data();
			$file_name 	= $path.$file_data['file_name'];
			$arr_file 	= explode('.', $file_name);
			$extension 	= end($arr_file);
			if('csv' == $extension) {
				$reader 	= new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			} else {
				$reader 	= new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}
			$spreadsheet 	= $reader->load($file_name);
			$sheet_data 	= $spreadsheet->getActiveSheet()->toArray();
            $list =[];
			foreach($sheet_data as $key => $val) {
				if($key != 0) {
                  //  var_dump($val[0]);
                  //  var_dump($val);
					$result 	= $this->students->get(strval($val[0]), strval($val[1]));
					if($result) {
					} else {
					
                        $list = array(
                            'fullnames'					=> $val[0],
							'email'			=> $val[1],
							'school'				=> $val[2],
							'phone_no'					=> $val[3],
							'nationality'					=> $val[4],
                
                           );
					}
				}
			}
			if(file_exists($file_name))
				unlink($file_name);
			if(count($list) > 0) {
				$result 	=  $this->students->add_student($list);
				if($result) {
					$this->response([
                        'status' => true,
                        'message' => 'STUDENTS IMPORTED'
                    ], 200); 
				} else {
                    $this->response([
                        'status' => false,
                        'message' => 'FAILED TO IMPORT STUDENT'
                    ],  400);
				}
			} else {
                $result 	=  $this->students->add_student($list);
                $this->response([
                    'status' => false,
                    'message' => 'NO NEW RECORD FOUND'
                ],  400);
			}
		}
		echo json_encode($json);
	}

	public function upload_config($path) {
		if (!is_dir($path)) 
			mkdir($path, 0777, TRUE);		
		$config['upload_path'] 		= './'.$path;		
		$config['allowed_types'] 	= 'csv|CSV|xlsx|XLSX|xls|XLS';
		$config['max_filename']	 	= '255';
		$config['encrypt_name'] 	= TRUE;
		$config['max_size'] 		= 4096; 
		$this->load->library('upload', $config);
    
        
    }
//-----------End------------------------------------------------------------------------
    }