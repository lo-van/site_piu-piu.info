<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Materials extends CI_Controller
{  

public function __construct()
{
   parent::__construct();
   $this->load->model('comments_model');            
}
    
    
public function index()
{
    redirect (base_url());
}
   

public function show($material_id)
{
   $this->load->library('table'); 
   $this->load->library('captcha_lib'); 
    
   // ��������� ��������, ������ � ����� ������
   $data = array();
   
   //������ �� ������ ����������
   $data['latest_materials'] = $this->materials_model->get_latest();  
   
   //������ �� ���������� ����������
   $data['popular_materials'] = $this->materials_model->get_popular();
   
   // �����
   $data['archive_list'] = $this->administration_model->get_archive();
   
   $data['latest_comments'] = $this->comments_model->get_latest($material_id); 
   
   // ������ �� ������ ��������� 
   $data['main_info'] = $this->materials_model->get($material_id);       
         
   //���� ������ ����
   if (empty($data['main_info']))
   {                            
        $data['info'] = '��� ������ ���������';                              
        $name = 'info'; 
        
        $this->display_lib->user_info_page($data,$name);
   }
      
   else
   {
       //��������� ������ ��� ���������� ���� count_views (������� ����� ������� ��������� +1)  
       $counter_data = array('count_views' => $data['main_info']['count_views'] + 1);
     
       //��������� ������� ����������, �������� �������� �������� � ���� 
       $this->materials_model->update_counter($material_id,$counter_data);
       
       // ������� ������� ��������� ������, ���������� ��� ��������
       $img_array = get_clickable_smileys(base_url().'img/smileys/','comment_text');// ���� � id ����

       // ������� ����������� ������ �� ���������� � ��������, �������           �������� ������ ���� � �������
	   $col_array = $this->table->make_columns($img_array,15); 
       
       // ���������, ���� ����������� ������� �����
       $data['fail_captcha'] = '';
       
       // ���������, ���� ����������� ������� ��������                   
       $data['success_comment'] = '';
       
       //�������� ��� �����
       $data['imgcode'] = $this->captcha_lib->captcha_actions(); 
       
       // ����������� � ���������
       $data['comments_list'] = $this->comments_model->get_by($material_id);
       //������� �������
       $data['smiley_table'] = $this->table->generate($col_array);        
                                         
       $name = 'materials/content'; 
       $this->display_lib->user_page($data,$name);
   }    
}



//���������� ��������� 
public function add()
{
    $this->auth_lib->check_admin();
    
    $this->load->helper('tinymce');
    
    //���� ������ ������ "�������� ��������"  
    if (isset($_POST['add_button']))
    {      
        $this->form_validation->set_rules($this->materials_model->add_rules);
		
     	if ($this->form_validation->run() == TRUE)
        {
            //��������� ����� ��������
            $this->materials_model->add();

            $data = array('info' => '�������� ��������');
            $this->display_lib->admin_info_page($data);
        }
        
        else
        {            
            $name = 'materials/add';
            
            // �������� ������ ������ data ��� ��� ���� ������� ������� admin_page
            $this->display_lib->admin_page($data = array(),$name); 			
        }
    }  
      
    //���� �� ������ ������ "�������� ��������", ������� ������ �����
    else
    {    
        $name = 'materials/add';
        $this->display_lib->admin_page($data = array(),$name);            
    }  
}



//�������������� ��������� (����� ������ ���������� ��� ������)  
public function edit_list($start_from = 0)
{
    $this->auth_lib->check_admin();
    
    $this->load->library('pagination');
    $this->load->library('pagination_lib');

    //������ ����������� ����� ���������� �� ��������
    $limit = $this->config->item('admin_per_page');

    //������� ����� ���������� ����������
    $total = $this->materials_model->count_all(); 

    //��������� (��� ���� ���������, ��� ��� ����������� � base_url, �����,�����������)
    $settings = $this->pagination_lib->get_settings('material_edit_list','',$total,$limit);
                
    //��������� ���������
    $this->pagination->initialize($settings);      

    // ������ ����������
    $data['materials_list'] = $this->materials_model->get_all($limit,$start_from); 
    
    // ������ pagination   
    $data['page_nav'] = $this->pagination->create_links();
     
    $name = 'materials/edit_list';
    
    $this->display_lib->admin_page($data,$name);
}



//�������������� ��������� (����� �� ����������, ��������������� �� ����) 
public function edit($material_id = '')
{
    $this->auth_lib->check_admin();
    
    $this->load->helper('checkbox');
    $this->load->helper('tinymce');    

    //��������� ������ ������ ��������� ��� ����������� � �����               ��������������
    $data = array();
    $data = $this->materials_model->get($material_id);

    //���� ������ ����
    if (empty($data))
    {
        $data = array('info' => '������ ��������� �� ����������');
        $this->display_lib->admin_info_page($data);                   
    }

    else
    {   
        //�������� ������������� �������� ����� section0 - section3
        $data['names'] = $this->materials_model->get_section_values($material_id);
        $name = 'materials/edit';    
        
        $this->display_lib->admin_page($data,$name);
    }
}



//���������� ��������� (���������� ��������� � ���� ������) 
public function update($material_id = '')
{
   $this->auth_lib->check_admin(); 
    
   $this->load->helper('checkbox');
   $this->load->helper('tinymce');   

   //���� ������ ������ "�������� ��������"
   if (isset($_POST['update_button']))
   {         
       $this->form_validation->set_rules($this->materials_model->update_rules);
		
	   if ($this->form_validation->run() == TRUE)
       {
           //��������� ��������
           $this->materials_model->update($material_id);

           $data = array('info' => '�������� ��������');       
           $this->display_lib->admin_info_page($data);  
       } 
       
       else
       {
            //��������� ������ � ������� � ��������� ��� ����������� � ���� ����� (��, ��� �� ������ ���������, ������� �� ����, � ��            , ��� ������ - �� ������� POST)
            $data = array();
            $data = $this->materials_model->get($material_id); 
            
            //�������� ������������� �������� ����� section0 - section3
            $data['names'] = $this->materials_model->get_section_values($material_id);                   
            $name = 'materials/edit';

            $this->display_lib->admin_page($data,$name);			
       }       
   }
   
   //�� ������ ������ "�������� ��������"    
   else
   {
       $data = array('info' => '�������� �� ��� ��������, ��� ��� �� �� ������ ������ "�������� ��������"');
       $this->display_lib->admin_info_page($data);
   }
}



//�������� ���������
public function delete($start_from = 0)
{
    $this->auth_lib->check_admin();
    
    $this->load->library('pagination');
    $this->load->library('pagination_lib');

    //���� �� ������ ������ "������� ��������"
    if ( ! isset($_POST['delete_button']))
    {
        //������ ����������� ����� ���������� �� �������� 
        $limit = $this->config->item('admin_per_page');
      
        //������� ����� ���������� ����������
        $total = $this->materials_model->count_all();        
      
        //��������� (��� ���� ���������, ��� ��� ����������� � base_url,          �����, �����������)
        $settings = $this->pagination_lib->get_settings('material_delete','',$total,$limit);
                
        //��������� ���������
        $this->pagination->initialize($settings);            
        
        //������ ����������, �������� � ������������ � pagination   
        $data['materials_list'] = $this->materials_model->get_all($limit,$start_from); 
        
        // ������ pagination
        $data['page_nav'] = $this->pagination->create_links(); 
        $name = 'materials/delete';    
        
        $this->display_lib->admin_page($data,$name);
    }
    
    //���� ������ "������� ��������" ������
    else
    {
        //�� �� ������ ��������
        if ( ! isset($_POST['material_id']))
        {
            $data = array('info' => '�� ������ �������� ��� ��������');
            $this->display_lib->admin_info_page($data);        
        }

        //� ������ ��������
        else 
        {  
            //�������� ������������� ��������� �� ������� POST
            $material_id = $this->input->post('material_id');
            
            //������� �������� � ��������� ���������������
            $this->materials_model->delete($material_id);           
            
            $data = array('info' => '�������� ������');
            $this->display_lib->admin_info_page($data);
        }
    }
}
   
   


}
?>