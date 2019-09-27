<?php  
defined('BASEPATH') OR exit('No direct script access allowed');  
  
class Home extends CI_Controller {  
    public function __construct()
    {
            parent::__construct();
            $this->load->model('todo_model');
            $this->load->model('users_model');
            $this->load->helper('url_helper');
            $this->load->library('session');

    } 
    public function index()  
    {  
        if(isset($_SESSION['user_id'])){
            $this->load->view('header');
            $this->load->view('index');
        }else{
            redirect('home/login');
        }
        
    }  

    public function add_todo(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('event', 'Event', 'required');
            if ($this->form_validation->run())  
            {  
                if($this->input->post('status')){
                    $status = 1;
                }else{
                    $status = 0;
                }
                $data = array(
                    'user_id' => $this->input->post('user_id'),
                    'event' => $this->input->post('event'),
                    'status' => $status
                );
                
                $this->todo_model->create_todo($data);
                echo json_encode(["msg" => "Todo Successfully added"]);
                //echo json_encode($data);
            }else{
                $data = array(
                    'error' => validation_errors()
                );  
                echo json_encode($data);
                }
    }
    public function update_todo(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('event', 'Event', 'required');
            if ($this->form_validation->run())  
            {  
                if($this->input->post('status')){
                    $status = 1;
                }else{
                    $status = 0;
                }
                $data = array(
                    'todo_id' => $this->input->post('todo_id'),
                    'event' => $this->input->post('event'),
                    'status' => $status
                );
                
                $this->todo_model->update_todo($data);
                echo json_encode(["msg" => "Todo Successfully updated"]);
                //echo json_encode($data);
            }else{
                $data = array(
                    'error' => validation_errors()
                );  
                echo json_encode($data);
                }
    }
    public function delete_todo(){
        $id = $this->input->post('id');
        $this->todo_model->delete_todo($id);
        echo json_encode(["msg" => "Todo Successfully deleted"]);

    }
    public function edit_todo(){
        $id = $this->input->post('id');
        $data = $this->todo_model->get_todo($id);
        echo json_encode($data);

    }
    public function get_todos(){
        $data = $this->todo_model->get_todos($_SESSION['user_id']);
        $output = '';
        $output .= '<table class="table table-responsive table-bordered table-striped table-dark">
                    <thead>
                        <tr>
                            <th scope="col" >Todos</th>
                            <th scope="col" >Status</th>
                            <th scope="col" >Time</th>
                            <th scope="col" >actions</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach($data as $todo){
                        $output .= '<tr><td width="60%"><span class="mr-2">'.
                            $todo['event'].'</span></td>';
                           
                          if($todo['status'] == 0 ) {
                              $output.='<td width="10%"><span>Pending</span></td>';
                          }else{
                              $output.='<td width="10%"><span>Completed</span></td>';
                          }
                        $output .='<td width="10%"><span>'.$todo['time'].'</span></td>';
                        $output.='<td width="20%"><button class="btn btn-primary btn-xm edit" type="button" name="edit" id="'.$todo['id'].'">
                              Edit
                          </button>
                          <button class="btn btn-danger btn-xm delete" type="button" name="delete" id="'.$todo['id'].'">
                              delete
                          </button>
                      </td>
                    </tr>';
                    }
                    $output .= '</tbody></table>';
                    echo $output;
    }
    public function search_todos(){
        $keyword = $this->input->post('keyword');
        $data = $this->todo_model->search_todos($keyword, $_SESSION['user_id']);
        $output = '';

        if($data){
            $output .= '<table class="table table-responsive table-bordered table-striped table-dark">
            <thead>
                <tr>
                    <th scope="col" >Todos</th>
                    <th scope="col" >Status</th>
                    <th scope="col" >Time</th>
                    <th scope="col" >actions</th>
                </tr>
            </thead>
            <tbody>';
            foreach($data as $todo){
                $output .= '<tr><td width="60%"><span class="mr-2">'.
                    $todo['event'].'</span></td>';
                   
                  if($todo['status'] == 0 ) {
                      $output.='<td width="10%"><span>Pending</span></td>';
                  }else{
                      $output.='<td width="10%"><span>Completed</span></td>';
                  }
                $output .='<td width="10%"><span>'.$todo['time'].'</span></td>';
                $output.='<td width="20%"><button class="btn btn-primary btn-xm edit" type="button" name="edit" id="'.$todo['id'].'">
                      Edit
                  </button>
                  <button class="btn btn-danger btn-xm delete" type="button" name="delete" id="'.$todo['id'].'">
                      delete
                  </button>
              </td>
            </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        }else{
            $output .= 'no search found';
            echo $output;
        }

    }

}

?>