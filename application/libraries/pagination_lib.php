<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pagination_lib
{    

//id - для чего навигация, name - имя для подстановки к base_url (только для категорий),всего, ограничение)
public function get_settings($id,$name,$total,$limit)
{    
    $config = array();
    $config['total_rows'] = $total;
    $config['per_page'] = $limit;    
    $config['first_link'] = '&laquo;Первая';
    $config['last_link'] = 'Последняя&raquo;';
    $config['next_link'] = '&raquo;';
    $config['prev_link'] = '&laquo;';
    
    // открывющий тэг перед навигацией
    $config['full_tag_open'] = '<ul id="pagination">';
    
    // закрывающий тэг после навигации 
    $config['full_tag_close'] = '</ul>';
    
    // первая страница открывающий тэг 
    $config['first_tag_open'] = '<li>'; 
    
    // первая страница закрывающий тэг 
    $config['first_tag_close'] = '</li>';
    
    // последняя страница открывающий тэг 
    $config['last_tag_open'] = '<li>'; 
    
    // последняя страница закрывающий тэг
    $config['last_tag_close'] = '</li>'; 
    
    // предыдущая страница открывающий тэг
    $config['prev_tag_open'] = '<li>';
    
    // предыдущая страница закрывающий тэг 
    $config['prev_tag_close'] = '</li>';
    
    // текущая страница открывающий тэг
    $config['cur_tag_open'] = '<li class = "active">'; 
    
    // текущая страница закрывающий тэг
    $config['cur_tag_close'] = '</li>';
        
    $config['num_tag_open'] = '<li>'; // цифровая ссылка открывающий тэг
    $config['num_tag_close'] = '</li>'; // цифровая ссылка закрывающий тэг
    
    // следующая страница открывающий тэг
    $config['next_tag_open'] = '<li>'; 
    
    // следующая страница закрывающий тэг
    $config['next_tag_close'] = '</li>'; 
    
    
    switch($id)
    {
        // Если навигация для категорий
        case 'section':            
            
            $config['base_url'] = base_url().'sections/show/'.$name;      
            $config['uri_segment'] = 4;
            
            //количество "цифровых" ссылок по бокам от текущей
            $config['num_links'] = 2;             
            
            return $config;            
            break; 
            
        // Если навигация для материалов (список для редактирования в админке)    
        case 'material_edit_list':

            $config['base_url'] = base_url().'materials/edit_list/';
            $config['uri_segment'] = 3;
            $config['num_links'] = 2;

            return $config;
            break;
            
        // Если навигация для материалов (список для удаления в админке)  
        case 'material_delete':

            $config['base_url'] = base_url().'materials/delete/';
            $config['uri_segment'] = 3;
            $config['num_links'] = 2;

            return $config;
            break;
            
       // Если навигация для комментариев (список для редактирования в           админке)
        case 'comment_edit_list':

            $config['base_url'] = base_url().'comments/edit_list/';
            $config['uri_segment'] = 3;
            $config['num_links'] = 2;

            return $config;
            break;
            
        // Если навигация для комментариев (список для удаления в админке)
        case 'comment_delete':

            $config['base_url'] = base_url().'comments/delete/';
            $config['uri_segment'] = 3;
            $config['num_links'] = 2;

            return $config;
            break; 
        
        // Если навигация для поиска
        case 'search':

            $config['base_url'] = base_url().'search/';
            $config['uri_segment'] = 2;
            $config['num_links'] = 2;

            return $config;
            break;    
                     
    }
}
   
}
?>