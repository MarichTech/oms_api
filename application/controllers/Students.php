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
            $this->load->helper('string');    
        }

        public function get_students_get($school){


            //Get a single account
              $data= $this->students->get_students($school);
  
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


// file upload functionality
public function importStudents_post()
{

    $data = array();
  
                // If file uploaded
                if(!empty($_FILES['doc']['name'])) { 
                    // get file extension
                    $extension = pathinfo($_FILES['doc']['name'], PATHINFO_EXTENSION);

                    if($extension == 'csv'){
                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                    } elseif($extension == 'xlsx') {
                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                    } else {
                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                    }
                    // file path
                    $spreadsheet = $reader->load($_FILES['doc']['tmp_name']);
                    $allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                
                    // array Count
                    $arrayCount = count($allDataInSheet);
                    $flag = 0;
                    $createArray = array('fullnames', 'email', 'school', 'phone_no', 'nationality');
                    $makeArray = array('fullnames' => 'fullnames', 'email' => 'email', 'school' => 'school', 'phone_no' => 'phone_no', 'nationality' => 'nationality');
                    $SheetDataKey = array();
                    foreach ($allDataInSheet as $dataInSheet) {
                        foreach ($dataInSheet as $key => $value) {
                            if (in_array(trim($value), $createArray)) {
                                $value = preg_replace('/\s+/', '', $value);
                                $SheetDataKey[trim($value)] = $key;
                            } 
                        }
                    }
                    $dataDiff = array_diff_key($makeArray, $SheetDataKey);
                    if (empty($dataDiff)) {
                        $flag = 1;
                    }
                    // match excel sheet column
                    if ($flag == 1) {
                        for ($i = 2; $i <= $arrayCount; $i++) {
                            
                            $fullnames = $SheetDataKey['fullnames'];
                            $email = $SheetDataKey['email'];
                            $school = $SheetDataKey['school'];
                            $phone_no = $SheetDataKey['phone_no'];
                            $nationality = $SheetDataKey['nationality'];

                            $fullnames = filter_var(trim($allDataInSheet[$i][$fullnames]), FILTER_SANITIZE_STRING);
                            $school = filter_var(trim($allDataInSheet[$i][$school]), FILTER_SANITIZE_STRING);
                            $email = filter_var(trim($allDataInSheet[$i][$email]), FILTER_SANITIZE_EMAIL);
                            $phone_no = filter_var(trim($allDataInSheet[$i][$phone_no]), FILTER_SANITIZE_STRING);
                            $nationality = filter_var(trim($allDataInSheet[$i][$nationality]), FILTER_SANITIZE_STRING);

                            $password = random_string('alnum', 5);

                                    if($fullnames != null){
                                        $fetchData[] = array('fullnames' => $fullnames, 'school' => $school, 'email' => $email, 'phone_no' => $phone_no, 'nationality' => $nationality);
                                        $userEmails[] = array('email' => $email, 'password' => $password);
                               
                                    }
                                    
                            
                        }   
                        $data = $fetchData;
                        $this->sendEmailWithLoginCredentials($userEmails);
                        $this->students->setBatchImport($fetchData);
                      
                        $result =  $this->students->importData();
                     
                        if($result) {

                            $this->response([
                                $data,
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

                        $this->response([
                            'status' => false,
                            'message' => 'Please import correct file, did not match excel sheet column'
                        ],  400);
                    }

           // $this->load->view('spreadsheet/display', $data);
                     
    }


}



public function sendEmailWithLoginCredentials($emails){

    for ($i=0; $i < count($emails); $i++) { 
        var_dump($emails[$i]['email']);
        } 

     
    // $this->load->config('email');
    // $this->load->library('email');

    // $from = $this->config->item('smtp_user');
    // $to = $post['email'];
    // $subject = "My Future App Student Login Credentials";
    // $message = "My Future App Student Login Credentials \n  Email:" . $email . "\r\n Password: " . $password . "\r\n You can now login to https://myfutureapp.org/ student portal.";

    // $this->email->set_newline("\r\n");
    // $this->email->from($from, "MyFutureApp Bot");
    // //$this->email->to('trulance247@gmail.com'); //Test
    // $this->email->to($email);
    // $this->email->subject($subject);
    // $this->email->message($message);

    // if ($this->email->send()) {
    // 	$resp['msg'] = 'Email sent.';
    // 	$resp['status'] = true;
    // 	// echo 'Your Email has successfully been sent.';
    // } else {

    // 	$resp['msg'] = $this->email->print_debugger();
    // 	$resp['status'] = false;
    // }

}


//-----------End------------------------------------------------------------------------
    }