<?php

// use SebastianBergmann\CodeCoverage\Report\Html\Renderer;

defined('BASEPATH') OR exit('No direct script access allowed');
use Dompdf\Dompdf;
class EvaluationForm extends MY_Controller  {
    public function __construct(){
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST');
        header('Access-Control-Request-Headers: Content-Type');
        
        // parent::__construct();
        $this->load->library('set_views');
        $this->load->library('email');
        $this->load->library('session');
        $this->load->library('set_custom_session');
        $this->admin_data = $this->set_custom_session->admin_session();
        $this->load->model('EvaluationForm_Model/EvaluationForm_Model','e_model');
        //user accessibility
        // $this->load->library('User_accessibility');
        // $this->user_accessibility->module_treasury_access($this->admin_data['userid']);
        // $this->load->model('Treasury_Model/Treasury_Model');
    }
    public function index(){
        $getAreaAll = $this->e_model->getAreaAll();
        $getAreaDescription = $this->e_model->getAreaDescription();
        $getArea = $this->e_model->getArea();
        $getEvaluationType = $this->e_model->getEvaluationType();
        // echo '<pre>'.print_r($getAreaAll,1).'</pre>';exit;
        // foreach($getAreaDescription as $ad){ 
        //     echo $ad['question_name'].'-'.$ad['evaluation_type_id'].'<br>';
        // }
        // exit;
        $this->data['title'] = 'Update SATE Form';
        $this->data['area_description'] = $getAreaAll;
        $this->data['area'] = $getArea;
        $this->data['eval_type'] = $getEvaluationType;
        // echo '<pre>'.print_r($this->data['eval_type'],1).'</pre>';
        // exit;
        $this->render($this->set_views->UpdateSATEForm());
    }
    public function getAreaDescriptionInfo(){
        $id = $this->input->post('id');
        $data = $this->e_model->getAreaDescriptionInfo($id);
        echo json_encode($data);
    }
    public function updateSATEForm(){
        $id = $this->input->post('chosen_id');
        $name = $this->input->post('name');
        $type = $this->input->post('type');
        $area = $this->input->post('area');
        $status = $this->input->post('question_status');
        $message = '';
        // echo '<pre>'.print_r(array(
        //         'area_id' => $area,
        //         'evaluation_type_id' => $type,
        //         'question_name' => $name,
        //         'active_question' => $status 
        // ),1).'</pre>';exit;
        if(empty($id)){
            $message = 'Successfully Created!!';
            $this->e_model->insertAreaDescription(array(
                'area_id' => $area,
                'evaluation_type_id' => $type,
                'question_name' => $name,
                'active_question' => 1 
            ));
        }
        else{
            $message = 'Successfully Updated!!';
            $this->e_model->updateAreaDescription(array(
                'area_id' => $area,
                'evaluation_type_id' => $type,
                'question_name' => $name,
                'active_question' => $status 
            ),$id);
        }
        $this->session->set_flashdata('success', $message);
        redirect($_SERVER['HTTP_REFERER']);
        // echo 'hello';
    }
    
}