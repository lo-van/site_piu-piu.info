<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comments extends CI_Controller
{ 
    
public function __construct()
{
   parent::__construct();    
   $this->load->model('comments_model');                
} 

//�� ��������� �������� �������� � ������ id
public function add($material_id = '')
{
    $this->load->library('table');
    $this->load->library('captcha_lib');
    $this->load->library('typography');
    
    // �������������� ������ � ����������-��������
    $img_array = get_clickable_smileys(base_url().'img/smileys/','comment_text');
	$col_array = $this->table->make_columns($img_array,15);    
          
    
    $data = array();    
    //������ �� ������ ����������
    $data['latest_materials']  = $this->materials_model->get_latest();     
    //������ �� ���������� ����������
    $data['popular_materials'] = $this->materials_model->get_popular();
    
    // �����
    $data['archive_list'] = $this->administration_model->get_archive(); 
    
    //������ �� ������ ���������
    $data['main_info'] = $this->materials_model->get($material_id); 
    
    // ����������� � ���������
    $data['comments_list'] = $this->comments_model->get_by($material_id); 
    
    $data['latest_comments'] = $this->comments_model->get_latest($material_id); 
    
    // ������� ������� �������
    $data['smiley_table'] = $this->table->generate($col_array); 
                
    // �� ������ ������ "��������������"    
    if ( ! isset($_POST['post_comment']))
    {         
        $data['info'] = '�� ���������� � ����� ��������, �� ����� ������ "��������������"';              
        $name = 'info'; 
                
        $this->display_lib->user_info_page($data,$name);       
    }
    
    // ������ ������ "��������������"
    else
    {                 
        //��������� ������ ���������
        $this->form_validation->set_rules($this->comments_model->add_rules);
        	  
        $val_res = $this->form_validation->run();
              
        // ���� ��������� ��������
        if ($val_res == TRUE)
        {
             //�������� �������� ���� �����
             $entered_captcha = $this->input->post('captcha');
        		   
             //���� ��� ��������� �� ��������� � ������ (�������� ��� ��� ���� - ������ � ������� ����� ��������� ��� ��������� ���������, � ��������������� ���� ������ �� �������� ���������)	
             if ($entered_captcha == $this->session->userdata('rnd_captcha'))
             {
                  $comment_text = $this->input->post('comment_text');                       
                  // TRUE - ����� ���� ��������� ������ ��� �����                           ��������� �� ��� ��������           
                  $comment_text = $this->typography->auto_typography($comment_text,TRUE);
                  
                  $comment_text = parse_smileys($comment_text,base_url().'img/smileys/');           
                
                
                  // ������ ��� ������� ������ �� �����������
                  $comment_data = array(); 
                  
                  //��� ������� ��� �������� ������� add                 
                  $comment_data['material_id'] = $material_id;       
                  $comment_data['author'] = $this->input->post('author');
                  $comment_data['comment_text'] = $comment_text; 
                  $comment_data['date'] = date('Y-m-d');
                  
                  //��������� ����������� � ����
                  $this->comments_model->add_new($comment_data);                   
                                  
           //������� ������ ��� �������� ������-���������� ��������������
                  //��� �����������
                  $author = $this->input->post('author'); 
                  
             // �������� ����� 70 ������ (����������� ������� mail � PHP)
                  $comment_text = wordwrap($comment_text,70); 
                  
                  // ������� html-���� ��� �������� ������      
                  $comment_text = strip_tags($comment_text);
                  
                  //���� ������������ ������
                  $address = "lomakin.ivan@gmail.com"; 
                  
                  // ���� ������
                  $subject = "����������� � ���������: ".$data['main_info']['title']; 
                  // ���������
                  $message = "�������(�):$author\n����� �����������:\n$comment_text\n������: http://www.piu-piu.info/materials/$material_id#captcha";                
                  
                  // ��������� ������-����������   
        	      mail ($address,$subject,$message,"Content-type:text/plain;charset = windows-1251\r\n");                   
                  $data['fail_captcha'] = '';
                  $data['success_comment']  = '��� ����������� ������� ��������<br><a href="#new_comment">����������� �����������</a>';          
                  //�������� ��� �����
                  $data['imgcode']  = $this->captcha_lib->captcha_actions(); 
                 //�������� ������ ������������ � ��������� ������ (���                    ��� ������ ��� ��� �������� ����� �����������)
                  $data['comments_list'] = $this->comments_model->get_by($material_id);  
                                                    
                  $name = 'materials/content'; 
                  $this->display_lib->user_page($data,$name);                    
             }   
                 
             // ���� ����� �� ���������
             else 
             {                                    
                  $data['fail_captcha'] = '������� ������� ����� � ��������<br><a href="#captcha">������ ��� ���!<a>';
                  
                  //�������� ��� �����
                  $data['imgcode']  = $this->captcha_lib->captcha_actions(); 
                  
                  $data['success_comment']  = '';                        
                                      
                  $name = 'materials/content';                   
                  $this->display_lib->user_page($data,$name);                 
             }                  
        }
            
        //���� ��������� �� ��������
        else
        {               
            $data['fail_captcha'] = '';
            $data['imgcode']  = $this->captcha_lib->captcha_actions(); //�������� ��� �����
            $data['success_comment']  = '';            
                                  
            $name = 'materials/content'; 
            $this->display_lib->user_page($data,$name);          
        }            
    }
}




//�������������� ����������� (����� ������ ��� ������ �����������)  
public function edit_list($start_from = 0)
{
    $this->auth_lib->check_admin();
    
    $this->load->library('pagination');
    $this->load->library('pagination_lib');
    
    //������ ����������� ����� ������������ �� ��������
    $limit = $this->config->item('admin_per_page');

    //������� ����� ���������� ������������
    $total = $this->comments_model->count_all();

    //��������� (��� ���� ���������, ��� ��� ����������� � base_url, �����, �����������)
    $settings = $this->pagination_lib->get_settings('comment_edit_list','',$total,$limit);

    //��������� ���������
    $this->pagination->initialize($settings);       

    //�������� ������ ���� ������������ � �������� ������� ��������� ��� pagination
    $data['comments_list'] = $this->comments_model->get_all($limit,$start_from);
    
    // ������ ��� pagination                       
    $data['page_nav'] = $this->pagination->create_links();  
                   
    $name = 'comments/edit_list';
    $this->display_lib->admin_page($data,$name);
}



//�������������� ����������� (����� �� ����������, ��������������� �� ����)
public function edit($comment_id = '')
{
    $this->auth_lib->check_admin();
    
    $this->load->helper('tinymce');
    
    //��������� ������ ������ ����������� (row_array) ��� ����������� �       ����� ��������������
    $data = array(); 
    $data = $this->comments_model->get($comment_id);
        
    //���� ������ ����
    if (empty($data))
    {
        $data = array('info' => '������ ����������� �� ����������');      
        $this->display_lib->admin_info_page($data);
    }
        
    else
    {
        $name = 'comments/edit';
        $this->display_lib->admin_page($data,$name);
    }
}



//���������� ����������� (���������� ����������� � ���� ������) 
public function update($comment_id = '')
{
   $this->auth_lib->check_admin();
   
   $this->load->helper('tinymce');
    
   //���� ������ ������ "�������� �����������"
   if (isset($_POST['update_button']))
   {
       $this->form_validation->set_rules($this->comments_model->update_rules);

       // ���� ��������� �������� 
	   if ($this->form_validation->run() == TRUE)
       {
           //��������� �����������
           $this->comments_model->update($comment_id);

           $data = array('info' => '����������� ��������');
           $this->display_lib->admin_info_page($data);
       } 
       
       else
       {    
            //��������� ������ � ������� � ����������� ��� ����������� �              ���� ����� (��, ��� �� ������ ���������, ������� �� ����, � ��            , ��� ������ - �� ������� POST)
            $data = array();	             
            $data = $this->comments_model->get($comment_id);                    
            $name = 'comments/edit';
            $this->display_lib->admin_page($data,$name);
       }
   } 
   
   //�� ������ ������ "�������� �����������"
   else
   {     
       $data = array('info' => '����������� �� ��� ��������, ��� ��� �� ��       ������ ������ "�������� �����������"');
       $this->display_lib->admin_info_page($data);             
   }
}



//�������� �����������  
public function delete($start_from = 0)
{
    $this->auth_lib->check_admin();
    
    $this->load->library('pagination');
    $this->load->library('pagination_lib');

    //���� �� ������ ������ "������� �����������"
    if ( ! isset($_POST['delete_button']))
    {
        //������ ����������� ����� ������������ �� ��������
        $limit = $this->config->item('admin_per_page');

        //������� ����� ���������� ������������
        $total = $this->comments_model->count_all();

        //��������� (��� ���� ���������, ��� ��� ����������� � base_url, �����, �����������)
        $settings = $this->pagination_lib->get_settings('comment_delete','',$total,$limit);
    
        //��������� ���������
        $this->pagination->initialize($settings);        
                
        //�������� ������ ���� ������������ � �������� ������� ���������          ��� pagination
        $data['comments_list'] = $this->comments_model->get_all($limit,$start_from);  
        
        // ������ ��� pagination                     
        $data['page_nav'] = $this->pagination->create_links();   

        $name = 'comments/delete';    
        $this->display_lib->admin_page($data,$name);            
    }

    //���� ������ "������� �����������" ������
    else
    {
        //�� �� ������ �����������
        if ( ! isset($_POST['comment_id']))
        {
            $data = array('info' => '�� ������ ����������� ��� ��������');
            $this->display_lib->admin_info_page($data);
        }

        //� ������ �����������
        else
        {  
            //�������� ������������� ����������� �� ������� POST
            $comment_id = $this->input->post('comment_id');
            
            //������� ����������� � ��������� ���������������
            $this->comments_model->delete($comment_id);      
            
            $data = array('info' => '����������� ������');       
            $this->display_lib->admin_info_page($data);             
        }
    }                
}





}
?>