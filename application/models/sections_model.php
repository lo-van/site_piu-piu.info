<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sections_model extends Crud
{  

public $table = 'sections'; //��� �������	
public $idkey = 'section_id'; //��� ID
 
 
// ������� ��� ���������� ����� ���������
public $add_rules = array
(
    array
    (
      'field' => 'section_id',
      'label' => '������������� ���������',
      'rules' => 'trim|required|alpha_dash|max_length[100]'
    ),
    array
    (
      'field' => 'title',
      'label' => '�������� ���������',
      'rules' => 'required|max_length[100]'
    ),
    array
    (
      'field' => 'description',
      'label' => '����-�������� ���������',
      'rules' => 'required|max_length[250]'
    ),        
    array
    (
      'field' => 'keywords',
      'label' => '�������� �����',
      'rules' => 'required|max_length[250]'
    ),        
    array
    (
      'field' => 'main_text',
      'label' => '������� �������� ���������',
      'rules' => 'required'
    )
);


// ������� ��� ���������� ���������
public $update_rules = array
(
    array
    (
      'field' => 'title',
      'label' => '�������� ���������',
      'rules' => 'required|max_length[100]'
    ),        
    array
    (
      'field' => 'description',
      'label' => '����-�������� ���������',
      'rules' => 'required|max_length[250]'
    ),        
    array
    (
      'field' => 'keywords',
      'label' => '�������� �����',
      'rules' => 'required|max_length[250]'
    ),        
    array
    (
      'field' => 'main_text',
      'label' => '������� �������� ���������',
      'rules' => 'required'
    )
);



//������ �� ����� �����������    
public function get_all()
{
    $query = $this->db->get('sections');
    return $query->result_array();
}
    

}
?>