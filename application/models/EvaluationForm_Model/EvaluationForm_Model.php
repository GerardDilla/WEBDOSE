<?php


class EvaluationForm_Model extends CI_Model
{
    public function index(){

    }
    public function getAreaAll(){
        $this->db->select('ie_area.*,iad.*,iet.eval_type');
        $this->db->from('ie_area');
        $this->db->join('ie_area_description as iad','ie_area.id = iad.area_id');
        $this->db->join('ie_evaluation_type as iet','iad.evaluation_type_id = iet.id','left');
        $this->db->order_by('orderr','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getArea(){
        $this->db->order_by('orderr','ASC');
        $query = $this->db->get('ie_area');
        return $query->result_array();
    }
    public function getEvaluationType(){
        // $this->db->order_by('orderr','ASC');
        $query = $this->db->get('ie_evaluation_type');
        return $query->result_array();
    }
    public function getAreaDescription(){
        $this->db->select('iad.*,iet.eval_type');
        $this->db->from('ie_area_description as iad');
        $this->db->join('ie_evaluation_type as iet','iad.evaluation_type_id = iet.id','left');
        $this->db->order_by('eval_id','ASC ');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getAreaDescriptionInfo($id){
        $this->db->where('eval_id',$id);
        $query = $this->db->get('ie_area_description');
        return $query->row_array();
    }
    public function updateAreaDescription($data,$id){
        $this->db->where('eval_id',$id);
        $this->db->update('ie_area_description',$data);
    }
    public function insertAreaDescription($data){
        $this->db->insert('ie_area_description');
    }
}