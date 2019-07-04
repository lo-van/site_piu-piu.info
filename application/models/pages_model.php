<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages_model extends Crud
{    
    
public $table = 'pages'; //��� �������	
public $idkey = 'page_id'; //��� ID


// ������� ��� ���������� ����� ��������
public $add_rules = array
(
    array
    (
      'field' => 'page_id',
      'label' => '������������� ��������',
      'rules' => 'trim|required|alpha_dash|max_length[100]'
    ),
    array
    (
      'field' => 'title',
      'label' => '�������� ��������',
      'rules' => 'required|max_length[100]'
    ),        
    array
    (
      'field' => 'description',
      'label' => '����-�������� ��������',
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
      'label' => '�������� ���������� ��������',
      'rules' => 'required'
    )
);


// ������� ��� �������������� ��������    
public $update_rules = array
(
    array
    (
      'field' => 'title',
      'label' => '�������� ��������',
      'rules' => 'required|max_length[100]'
    ),        
    array
    (
      'field' => 'description',
      'label' => '����-�������� ��������',
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
      'label' => '�������� ���������� ��������',
      'rules' => 'required'
    )
);


// ������� ��� ���������� �����
public $contact_rules = array
    (   
       array
       (
         'field' => 'name',
         'label' => '���',
         'rules' => 'trim|required|xss_clean|max_length[70]'
       ),
       array
       (
         'field' => 'email',
         'label' => '�-mail',
         'rules' => 'trim|required|valid_email|xss_clean|max_length[70]'
       ),
       array
       (
         'field' => 'topic',
         'label' => '���� ���������',
         'rules' => 'required|xss_clean|max_length[70]'
       ),        
       array
       (
         'field' => 'message',
         'label' => '����� ���������',
         'rules' => 'required|xss_clean|max_length[5000]'
       ),
       array
       (
         'field' => 'captcha',
         'label' => '����� � ��������',
         'rules' => 'required|numeric|exact_length[5]'
       )
    );
    
    

public function get_all()
{
    $query = $this->db->get('pages');
    
    //���������� ������ �� ����� ����������
    return $query->result_array();
}

}
?>