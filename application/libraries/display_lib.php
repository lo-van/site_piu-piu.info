<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Display_lib
{

//data - массив с переменными, name - начало имени файла вида    
public function user_page($data,$name)
{
    $CI =& get_instance ();
    
    $CI->load->view('preheader_view',$data);
    $CI->load->view('header_view');
    $CI->load->view('top_navigation_view');
    $CI->load->view($name.'_view',$data);
    $CI->load->view('leftblock_view',$data);
    $CI->load->view('rightblock_view',$data);
    $CI->load->view('footer_view');        
}


public function user_info_page($data,$name)
{
    $CI =& get_instance ();

    $CI->load->view('info_preheader_view');
    $CI->load->view('header_view');
    $CI->load->view('top_navigation_view');
    $CI->load->view($name.'_view',$data);
    $CI->load->view('leftblock_view',$data);
    $CI->load->view('rightblock_view',$data);
    $CI->load->view('footer_view');
}    


public function admin_page($data,$name)
{
    $CI =& get_instance ();

    $CI->load->view('admin/preheader_view');
    $CI->load->view('admin/header_view');
    $CI->load->view('top_navigation_view');
    $CI->load->view('admin/'.$name.'_view',$data);
    $CI->load->view('admin/leftblock_view');
    $CI->load->view('admin/footer_view');
}


public function admin_info_page($data)
{
    $CI =& get_instance ();

    $CI->load->view('admin/preheader_view');
    $CI->load->view('admin/header_view');
    $CI->load->view('top_navigation_view');
    $CI->load->view('info_view',$data);
    $CI->load->view('admin/leftblock_view');
    $CI->load->view('admin/footer_view');
}


public function login_page()
{
    $CI =& get_instance ();

    $CI->load->view('admin/preheader_view');
    $CI->load->view('admin/header_view');
    $CI->load->view('admin/login_view');
    $CI->load->view('admin/footer_view');
}

          
}
?>