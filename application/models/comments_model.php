<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comments_model extends Crud
{    
    
public $table = 'comments'; //��� �������	
public $idkey = 'comment_id'; //��� ID

//������� ��� ���������� ������������
public $add_rules = array
(                   
    array
    (
      'field' => 'author',
      'label' => '���',
      'rules' => 'trim|required|xss_clean|max_length[70]'
    ),        
    array
    (
      'field' => 'comment_text',
      'label' => '����� �����������',
      'rules' => 'required|xss_clean|max_length[5000]'
    ),
    array
    (
     'field' => 'captcha',
     'label' => '����� � ��������',
     'rules' => 'required|numeric|exact_length[5]'
    )
);


//������� ��� ���������� ������������
public $update_rules = array
(
    array
    (
      'field' => 'author',
      'label' => '���',
      'rules' => 'trim|required|max_length[70]'
    ),
    array
    (
      'field' => 'comment_text',
      'label' => '����� �����������',
      'rules' => 'required|max_length[5000]'
    )
);


public function get_by($material_id)
{
    $this->db->order_by ('comment_id','desc'); 
    $this->db->where ('material_id',$material_id);   
    $query = $this->db->get('comments');
    return $query->result_array();//���������� ������ � ������������� � ���������
}


public function get_latest()
{
    $this->db->order_by('comment_id','desc');
    $this->db->limit(5);
    $query = $this->db->get('comments');
    return $query->result_array();//���������� ������ �� ������� �������������
}


public function add_new($comment_data)
{        
    $this->db->insert('comments',$comment_data);                       
}


public function get_all($limit,$start_from)
{
    $this->db->order_by('comment_id','desc');
    
    //������������ ������ � ���� ����� �����������
    $this->db->limit($limit,$start_from);
    $query = $this->db->get('comments');
    
    //���������� ������ �� ����� �������������, ��������� � ������������      � ��������� pagination
    return $query->result_array();
}


}
?>