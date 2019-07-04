<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Materials_model extends Crud
{
    
public $table = 'materials'; //��� �������	
public $idkey = 'material_id'; //��� ID


// ������� ��� ���������� ������ ���������
public $add_rules = array
(
    array
    (
      'field' => 'title',
      'label' => '�������� ���������',
      'rules' => 'required|max_length[250]'
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
      'field' => 'small_img_url',
      'label' => '���� � ����-������ ��� ������',
      'rules' => 'required'
    ),
    array
    (
      'field' => 'short_text',
      'label' => '������� ��������',
      'rules' => 'required'
    ),
    array
    (
      'field' => 'main_text',
      'label' => '������ �����',
      'rules' => 'required'
    ),
    array
    (
      'field' => 'date',
      'label' => '���� ����������',
      'rules' => 'required'
    ),
    array
    (
      'field' => 'author',
      'label' => '����� ���������',
      'rules' => 'required|max_length[250]'
    ),
    array
    (
      'field' => 'section[]',
      'label' => '���������',
      'rules' => 'required'
    )
);



// ������� ��� ���������� ������ ���������
public $update_rules = array
(                   
    array
    (
      'field' => 'title',
      'label' => '�������� ���������',
      'rules' => 'required|max_length[250]'
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
      'field' => 'small_img_url',
      'label' => '���� � ����-������ ��� ������',
      'rules' => 'required'
    ),
    array
    (
      'field' => 'short_text',
      'label' => '������� ��������',
      'rules' => 'required'
    ),
    array
    (
      'field' => 'main_text',
      'label' => '������ �����',
      'rules' => 'required'
    ),
    array
    (
      'field' => 'date',
      'label' => '���� ����������',
      'rules' => 'required'
    ),
    array
    (
      'field' => 'author',
      'label' => '����� ���������',
      'rules' => 'required|max_length[250]'
    ),
    array
    (
      'field' => 'section[]',
      'label' => '���������',
      'rules' => 'required'
    )
);    
    

public function get_latest()
{
    $this->db->order_by ('material_id','desc');
    $this->db->limit (9);
    $query = $this->db->get('materials');
    return $query->result_array();//���������� ������ � ���������� �����������
}


public function get_popular()
{
    $this->db->order_by('count_views','desc');
    $this->db->limit (9);
    $query = $this->db->get('materials');
    return $query->result_array();//���������� ������ � �������� ���������������� �����������
}


// ���������� �������� �������� ����������
public function update_counter($material_id,$counter_data)
{
    $this->db->where('material_id',$material_id);
    $this->db->update('materials',$counter_data);
}


//�������� ��� ���������: id ���������, ����������� ���������� �������, � � ����� ������ ������
public function get_by($section_id,$limit,$start_from)
{
    $this->db->order_by('material_id','desc');
    $this->db->where ('section0',$section_id);
    for ($i=1;$i<6;$i++)
    {
        $cname = 'section'.$i;
        $this->db->or_where($cname,$section_id);
    }
     
    //������������ ������ � ���� ����� �����������     
    $this->db->limit($limit,$start_from);       

    $query = $this->db->get('materials');
    
    // ���������� ������ � ����������� ���������� ���������, ��������� �      ������������ � ��������� pagination
    return $query->result_array();
}
    

//������� ���������� ���������� � ���������� ���������
public function count_by($section_id)
{
    $this->db->where ('section0',$section_id);
    for ($i=1;$i<6;$i++)
    {
        $cname = 'section'.$i;
        $this->db->or_where($cname,$section_id);
    }

    return $this->db->count_all_results('materials');
}


public function get_all($limit,$start_from)
{
    $this->db->order_by('material_id','desc');
    
    //������������ ������ � ���� ����� �����������
    $this->db->limit($limit,$start_from);    
    $query = $this->db->get('materials');
    
    //���������� ������ � �����������, ��������� � ������������ �             ��������� pagination
    return $query->result_array();
}


//��������� ��������, ���������� � ����� section0 - section4 ��� ����������� ���������
public function get_section_values($material_id)
{
    $this->db->where('material_id',$material_id);
    for ($i=0;$i<6;$i++)
    {
        $cname = 'section'.$i;
        $this->db->select($cname);
    }

    $query = $this->db->get('materials');
    return $query->row_array();
}
    
    
}
?>