<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    use chriskacerguis\RestServer\RestController;

    require APPPATH . 'libraries/RestController.php';
    require APPPATH . 'libraries/Format.php';

    

    class Opportunities extends RestController{

        public function account_opportunities_get($id){

            $data['opportunity'] = $this->opportunity_model->get_account_opportunities($id);

             //Check if Opportunities exist else display opportunities not found
             if(empty($data['opportunity'])){

                $this->response([
					"status" => "false",
					"message" => "OPPORTUNITY NOT FOUND",
				], 400);


              }else{
                $this->response($data, 200);

              }  
            
        }

        public function get_opportunity_get($id){
            //Get a single opportunity
              $data['opportunity'] = $this->opportunity_model->get_opportunity($id);
  
              //Check if opportunity exist else display accounts not found
              if(empty($data['opportunity'])){
  
                  $this->response([
                      'status' => false,
                      'message' => 'OPPORTUNITY NOT FOUND',
                  ], 400);
  
                }else{
                  $this->response($data, 200);
  
                }   
          }


        
        public function create_post(){

            $data = array(
                'account_id'=> $this->input->post('accountId'),
                'user_id' => $this->input->post('user_id'),
                'name' => $this->input->post('name'),
                'amount' => $this->input->post('amount'),
                'stage' => $this->input->post('stage'),
            );
                //Create opportunity
                $result = $this->opportunity_model->insert_opportunity($data);

                if($result > 0)
                {
                    $this->response([
                        'status' => true,
                        'message' => 'NEW OPPORTUNITY CREATED',
                    ], 200); 
                }
                else
                {
                    $this->response([
                        'status' => false,
                        'message' => 'FAILED TO CREATE NEW OPPORTUNITY',
                    ],  400);
                }


        }

        public function delete_delete($id){
            //Delete opportunity
            $result = $this->opportunity_model->delete_opportunity($id);

            if($result > 0)
            {
                $this->response([
                    'status' => true,
                    'message' => 'OPPORTUNITY DELETED',
                ], 200); 
            }
            else
            {
                $this->response([
                    'status' => false,
                    'message' => 'FAILED TO DELETE OPPORTUNITY',
                ],  400);
            }

        }



        public function update_put(){

            $id = $this->input->post('id');

            $data = array(
                //Format 'name_of_db_column' => data you want to store in the column(you can use post to get data from form)
                'account_id'=> $this->input->post('accountId'),
                'user_id' => $this->input->post('user_id'),
                'name' => $this->input->post('name'),
                'amount' => $this->input->post('amount'),
                'stage' => $this->input->post('stage'),
            );

            $result = $this->opportunity_model->update_opportunity($data, $id);

            if($result > 0)
            {
                $this->response([
                    'status' => true,
                    'message' => 'ACCOUNT UPDATED',
                ], 200); 
            }
            else
            {
                $this->response([
                    'status' => false,
                    'message' => 'FAILED TO UPDATE ACCOUNT',
                ], 400);
            }


          
        }

   

    }