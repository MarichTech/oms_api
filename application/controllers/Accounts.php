<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    use chriskacerguis\RestServer\RestController;
    require APPPATH . 'libraries/RestController.php';
    require APPPATH . 'libraries/Format.php';

    class Accounts extends RestController{


        public function user_accounts_get($id){
          //Get all user accounts and its associated opportunities 
            $data['accounts'] = $this->account_model->user_accounts($id);

            //Check if Accounts exist else display accounts not found
            if(empty($data['accounts'])){

                $this->response([
                    'status' => false,
                    'message' => 'ACCOUNTS NOT FOUND',
                ],  400);

              }else{
                $this->response($data, 200);

              }   
        }

        public function get_account_get($id){
            //Get a single account
              $data['account'] = $this->account_model->get_account($id);
  
              //Check if Accounts exist else display accounts not found
              if(empty($data['account'])){
  
                  $this->response([
                      'status' => false,
                      'message' => 'ACCOUNTS NOT FOUND'
                  ],  400);
  
                }else{
                  $this->response($data, 200);
  
                }   
          }


        public function create_post(){

            $data = array(
                //Format 'name_of_db_column' => data you want to store in the column(you can use post to get data from form)
                'name'=> $this->input->post('name'),
                'email' => $this->input->post('email'),
                'phonenumber' => $this->input->post('phonenumber'),
                'address' => $this->input->post('address')
    
               );
               
                //Create Account
                $result =  $this->account_model->insert_account($data);

                if($result > 0)
                {
                    $this->response([
                        'status' => true,
                        'message' => 'NEW ACCOUNT CREATED'
                    ], 200); 
                }
                else
                {
                    $this->response([
                        'status' => false,
                        'message' => 'FAILED TO CREATE NEW ACCOUNT'
                    ],  400);
                }
   
        }

        public function delete_delete($id){
            //Delete Account
            $result = $this->account_model->delete_account($id);

            if($result > 0)
            {
                $this->response([
                    'status' => true,
                    'message' => 'ACCOUNT DELETED'
                ], RestController::HTTP_OK); 
            }
            else
            {
                $this->response([
                    'status' => false,
                    'message' => 'FAILED TO DELETE ACCOUNT'
                ],  400);
            }
        }


        public function update_put(){ 

            $id = $this->input->post("id");

             $data = array(
                'name'=> $this->input->post('name'),
                'email' => $this->input->post('email'),
                'phonenumber' => $this->input->post('phonenumber'),
                'address' => $this->input->post('address')
    
               );
               
                //Update Account
                $result =  $this->account_model->update_account($data, $id);

                if($result > 0)
                {
                    $this->response([
                        'status' => true,
                        'message' => 'ACCOUNT UPDATED'
                    ], RestController::HTTP_OK); 
                }
                else
                {
                    $this->response([
                        'status' => false,
                        'message' => 'FAILED TO UPDATE ACCOUNT'
                    ],  400);
                }

        }

//-----------End------------------------------------------------------------------------
    }