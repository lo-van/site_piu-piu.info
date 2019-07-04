<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sections extends CI_Controller
{           

public function __construct()
{
   parent::__construct();    
   $this->load->model('sections_model');         
}


public function index()
{
    redirect (base_url());
}


//start_from - � ������ ��������� �������� ����� ��� ������ ��������, �������� � ������� pagination
public function show($section_id,$start_from = 0)
{
   $this->load->library('pagination');
   $this->load->library('pagination_lib');
    
   $data = array();
   
   //������ �� ������ ����������
   $data['latest_materials'] = $this->materials_model->get_latest();
   
   //������ �� ���������� ����������   
   $data['popular_materials'] = $this->materials_model->get_popular();
   
   // �����
   $data['archive_list'] = $this->administration_model->get_archive();
   
   //������ �� ����� ���������
   $data['main_info'] = $this->sections_model->get($section_id);          
      
   //���� ������ ����
   if (empty($data['main_info']))
   {                       
        $data['info'] = '����� ��������� �� ����������';                      
        $name = 'info'; 
        
        $this->display_lib->user_info_page($data,$name);             
   }
      
   else
   {
        //������ ����������� ����� ���������� �� ��������
        $limit = $this->config->item('user_per_page');

        //������� ����� ���������� ���������� � ���������� ���������
        $total = $this->materials_model->count_by($section_id);
        
        //��������� (��� ���� ���������, ��� ��� ����������� � base_url,           �����, �����������)
        $settings = $this->pagination_lib->get_settings('section',$section_id,$total,$limit);

        //��������� ���������
        $this->pagination->initialize($settings);        
        
        // �������� ������ ����������, �������� � ������������ �                  �����������
        $data['materials_list'] = $this->materials_model->get_by($section_id,$limit,$start_from);
        
        // �������� ��� ������ ������������ ���������
        $data['page_nav'] = $this->pagination->create_links();
        $name = 'sections/content';
        
        $this->display_lib->user_page($data,$name);
   }
}




//���������� ���������
public function add()
{ 
    $this->auth_lib->check_admin();
    
    $this->load->helper('tinymce');
    
    //���� ������ ������ "�������� ���������"  
    if (isset($_POST['add_button']))
    {    
        $this->form_validation->set_rules($this->sections_model->add_rules);

     	if ($this->form_validation->run() == TRUE)
        {        
            //��������� ����� ���������
            $this->sections_model->add();
            
            $data = array('info' => '��������� ���������');
            $this->display_lib->admin_info_page($data);
        }

        else
        {            
            $name = 'sections/add';
            
            // �������� ������ ������ data ��� ��� ���� ������� �������               admin_page
            $this->display_lib->admin_page($data = array(),$name); 			
        }        
    }
      
    //���� �� ������ ������ "�������� ���������", ������� ������ �����
    else
    {
        $name = 'sections/add';
        $this->display_lib->admin_page($data = array(),$name);
    }
}



//�������������� (����� ������ ��������� ��� ������)  
public function edit_list()
{
    $this->auth_lib->check_admin();
    
    //������ �� ���� ���������� ��� ������ ������
    $data = array('sections_list' => $this->sections_model->get_all());
    $name = 'sections/edit_list';
    
    $this->display_lib->admin_page($data,$name);
}



//�������������� (����� �� ����������, ��������������� �� ����) 
public function edit($section_id = '')
{
    $this->auth_lib->check_admin();
    
    $this->load->helper('tinymce');
    
    //������ ����� ��������� ��� ����������� � ����� ��������������
    $data = array();
    $data = $this->sections_model->get($section_id);        

    //���� ������ ����
    if (empty($data))
    {
        $data = array('info' => '����� ��������� �� ����������');
        $this->display_lib->admin_info_page($data);                  
    }
        
    else
    {   
        $name = 'sections/edit';
        $this->display_lib->admin_page($data,$name);            
    }
}




//���������� (���������� ��������� � ���� ������)  
public function update($section_id = '')
{
   $this->auth_lib->check_admin(); 
   
   $this->load->helper('tinymce');
    
   //���� ������ ������ "�������� ���������"    
   if (isset($_POST['update_button']))
   {
       $this->form_validation->set_rules($this->sections_model->update_rules);
		
	   if ($this->form_validation->run() == TRUE)
       {        
           //��������� ���������
           $this->sections_model->update($section_id);
           $data = array('info' => '��������� ���������');
                  
           $this->display_lib->admin_info_page($data);
       } 
       
       else
       {    
            //��������� ������ � ������� � ��������� ��� ����������� � ���� ����� (��, ��� �� ������                   ���������, ������� �� ����, � ��, ��� ������ - �� ������� POST)
            $data = array();	             
            $data = $this->sections_model->get($section_id);                    
            $name = 'sections/edit';
            
            $this->display_lib->admin_page($data,$name);			
       }
   }
       
   //�� ������ ������ "�������� ���������"
   else
   {
       $data = array('info' => '��������� �� ���� ���������, ��� ��� �� �� ������ ������ "��������                ���������"');
       $this->display_lib->admin_info_page($data);
   }
}



//�������� ���������
public function delete()
{
    $this->auth_lib->check_admin();
    
    //���� �� ������ ������ "������� ���������", ������� ������ ���������
    if ( ! isset($_POST['delete_button']))
    {         
        //������ �� ���� ���������� ��� ������ ������
        $data = array('sections_list' => $this->sections_model->get_all());       
        $name = 'sections/delete';
        $this->display_lib->admin_page($data,$name);             
    }
    
    //���� ������ "������� ���������" ������
    else
    {
        //�� �� ������� ���������
        if ( ! isset($_POST['section_id']))
        {
            $data = array('info' => '�� ������� ��������� ��� ��������');       
            $this->display_lib->admin_info_page($data);              
        }
        
        //� ������� ���������
        else 
        {  
            //�������� ������������� ��������� �� ������� POST
            $section_id = $this->input->post('section_id');
            
            //������� ��������� � ��������� ���������������
            $this->sections_model->delete($section_id);
            
            $data = array('info' => '��������� �������');
            $this->display_lib->admin_info_page($data);
        }
    }
}



}
?>