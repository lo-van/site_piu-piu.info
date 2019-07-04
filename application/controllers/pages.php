<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller
{
    
public function __construct()
{
    parent::__construct();
    $this->load->model('pages_model');
}    
    
public function index()
{
    redirect (base_url());
}

public function links()
{
	$this->load->view('links_view');
}

public function show ($page_id)
{
  // ��������� ������ ��� �������� � ���
  $data = array(); 
  
  //������ �� ������ ����������
  $data['latest_materials'] = $this->materials_model->get_latest();
  
  //������ �� ���������� ����������
  $data['popular_materials'] = $this->materials_model->get_popular();
  
  // �����
  $data['archive_list'] = $this->administration_model->get_archive(); 
  
  //������ �� ����� ��������  
  $data['main_info'] = $this->pages_model->get($page_id); 
    
  switch($page_id)
  {
    //���� �������� "�������"
    case 'index':         
        
        $name = 'pages/mainpage';
         
        $this->display_lib->user_page($data,$name);
                   
        break;
    
    
    //���� �������� "��������"
    case 'contact':
        
        $this->load->library('captcha_lib');
    
        // �� ������ ������ "���������"    
        if ( ! isset($_POST['send_message']))
        {    
            //�������� ��� ��������
            $data['imgcode'] = $this->captcha_lib->captcha_actions(); 
            $data['info'] = ''; //�������������� ���������                           
            $name = 'pages/contact'; 
            
            $this->display_lib->user_page($data,$name);
        }
          
        // ������ ������ "���������"
        else
        {  
            //��������� ������ ���������
            $this->form_validation->set_rules($this->pages_model->contact_rules);		
        	  
        	$val_res = $this->form_validation->run();
              
            //���� ��������� ��������
            if ($val_res == TRUE)
            {
                 //�������� �������� ���� �����
        	     $entered_captcha = $this->input->post('captcha');
        		   
                 //���� ����� ���������, ���������� ������
        	     if ($entered_captcha == $this->session->userdata('rnd_captcha'))
                 {
                     $this->load->library('typography');
                     
                     //��� �����������
                     $name = $this->input->post('name');
                     
                     //��������� ������������ email 
                     $email = $this->input->post('email'); 
                     
                     //���� ���������, ��������� ������������
                     $topic = $this->input->post('topic'); 
                     
                     //����� ���������
                     $text = $this->input->post('message');
                     
                     //�������� ����� 70 ������ (����������� mail � PHP)  
                     $text = wordwrap($text,70); 
                     
                     // TRUE - ����� ���� ��������� ����� ��� ����� ��������� �� ��� �������� ������
                     $text = $this->typography->auto_typography($text,TRUE);
                     // ������� html-���� ��� �������� ������
                     $text = strip_tags($text);

                     //���� ������������ ������
                     $address = "lomakin.ivan@gmail.com"; 
                     
                     //���� ������ ��� �� ����� ����������
                     $subject = "������ �� ����� �������� �����";          
                     $message = "�������(�):$name\n����: $topic\n���������:\n$text\nE-mail �����������: $email"; 
                                          
                     //���������� ������
        	         mail ($address,$subject,$message,"Content-type:text/plain;charset = windows-1251\r\n");
                                  
                     $data['info'] = '���� ��������� ����������. � ������� � ����� � ���������� �����, ���� � ���� ����� �������������';
                     $name = 'info'; 

                     $this->display_lib->user_info_page($data,$name);                     
        	     }   
                   
                 // ���� ����� �� ���������
                 else 
                 {
                     //�������� ��� ��������;
                     $data['imgcode'] = $this->captcha_lib->captcha_actions();
                     
                     $data['info'] = '������� ������� ����� � ��������';                                   
                     $name = 'pages/contact';

                     $this->display_lib->user_page($data,$name);
                 }            						
            }
              
            //���� ��������� �� ��������
            else
            {   
                //�������� ��� ��������;
                $data['imgcode'] = $this->captcha_lib->captcha_actions(); 
                $data['info'] = ''; //�������������� ���������                               
                $name = 'pages/contact'; 

                $this->display_lib->user_page($data,$name);
            }
        }
        break;
    
        
    // ����� ������ ��������
    default:

        //���� ������ ����
        if (empty($data['main_info']))
        {
           $data['info'] = '��� ����� ��������';
           $name = 'info'; 

           $this->display_lib->user_info_page($data,$name);
        }
           
        else
        {
           $name = 'pages/page';
           $this->display_lib->user_page($data,$name);           
    	}
        break;    
  }
}
    


//���������� ��������
public function add()
{
    $this->auth_lib->check_admin();
    
    $this->load->helper('tinymce');
    
    //���� ������ ������ "�������� ��������"  
    if (isset($_POST['add_button']))      
    {
        $this->form_validation->set_rules($this->pages_model->add_rules);
		
     	if ($this->form_validation->run() == TRUE)
        {
            //��������� ����� ��������
            $this->pages_model->add();
                        
            $data = array('info' => '�������� ���������');       
            $this->display_lib->admin_info_page($data); 
        }
        
        else
        {
            $name = 'pages/add';
            
            // �������� ������ ������ data ��� ��� ���� ������� �������               admin_page 
            $this->display_lib->admin_page($data = array(),$name);           
        }
    }
          
    //���� �� ������ ������ "�������� ��������", ������� ������ �����
    else
    {                      
        $name = 'pages/add';
        $this->display_lib->admin_page($data = array(),$name);
    }
}



//�������������� (����� ������ ������� ��� ������)  
public function edit_list()
{
    $this->auth_lib->check_admin();
    
    //������ �� ���� ��������� ��� ������ ������
    $data = array('pages_list' => $this->pages_model->get_all());
    $name = 'pages/edit_list';

    $this->display_lib->admin_page($data,$name);
} 


//�������������� (����� �� ����������, ��������������� �� ����)
public function edit($page_id = '')
{
    $this->auth_lib->check_admin();
    
    $this->load->helper('tinymce');
    
    //��������� ������ ����� �������� (row_array) ��� ����������� � �����     �������������� 
    $data = array();
    $data = $this->pages_model->get($page_id);        

    //���� ������ ����
    if (empty($data))
    {
        $data = array('info' => '����� �������� �� ����������');       
        $this->display_lib->admin_info_page($data);               
    }

    else
    {
        $name = 'pages/edit';
        $this->display_lib->admin_page($data,$name);
    }
}



//���������� (���������� �������� � ���� ������) 
public function update($page_id = '')
{
   $this->auth_lib->check_admin();
   
   $this->load->helper('tinymce'); 
    
   //���� ������ ������ "�������� ��������"
   if (isset($_POST['update_button']))
   {
       $this->form_validation->set_rules($this->pages_model->update_rules);

	   if ($this->form_validation->run() == TRUE)
       {        
           //��������� ��������
           $this->pages_model->update($page_id);
          
           $data = array('info' => '�������� ���������');       
           $this->display_lib->admin_info_page($data);
       }

       else
       {
           //��������� ������ � ������� � �������� ��� ����������� � ����            ����� (��, ��� �� ������ ���������, ������� �� ����, � ��, ���            ������ - �� ������� POST)
           $data = array ();
           $data = $this->pages_model->get($page_id);
           $name = 'pages/edit';
           
           $this->display_lib->admin_page($data,$name);
       }               
   }

   //�� ������ ������ "�������� ��������"
   else
   { 
       $data = array('info' => '�������� �� ���� ���������, ��� ��� �� ��        ������ ������ "�������� ��������"');
       $this->display_lib->admin_info_page($data);             
   }      
}



//�������� �������� 
public function delete()
{
    $this->auth_lib->check_admin();
    
    //���� �� ������ ������ "������� ��������"
    if ( ! isset($_POST['delete_button']))
    {
        //������ �� ���� ���������
        $data = array('pages_list' => $this->pages_model->get_all());
        $name = 'pages/delete';

        $this->display_lib->admin_page($data,$name);
    }

    //���� ������ "������� �������" ������
    else
    {
        //�� �� ������� ��������
        if ( ! isset($_POST['page_id']))
        {
            $data = array('info' => '�� ������� �������� ��� ��������');
            $this->display_lib->admin_info_page($data);                      
        }

        //� ������� ��������
        else 
        {
            //�������� ������������� �������� �� ������� POST
            $page_id = $this->input->post('page_id');
            
            //������� �������� � ��������� ���������������
            $this->pages_model->delete($page_id);                         
            
            $data = array('info' => '�������� �������');                  
            $this->display_lib->admin_info_page($data);            
        }
    }
}   
    
    
    
    
}
?>