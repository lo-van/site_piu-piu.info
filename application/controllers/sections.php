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


//start_from - с какого материала начинать вывод для каждой страницы, разбитой с помощью pagination
public function show($section_id,$start_from = 0)
{
   $this->load->library('pagination');
   $this->load->library('pagination_lib');
    
   $data = array();
   
   //Массив по свежим материалам
   $data['latest_materials'] = $this->materials_model->get_latest();
   
   //Массив по популярным материалам   
   $data['popular_materials'] = $this->materials_model->get_popular();
   
   // Архив
   $data['archive_list'] = $this->administration_model->get_archive();
   
   //Массив по одной категории
   $data['main_info'] = $this->sections_model->get($section_id);          
      
   //Если массив пуст
   if (empty($data['main_info']))
   {                       
        $data['info'] = 'Такой категории не существует';                      
        $name = 'info'; 
        
        $this->display_lib->user_info_page($data,$name);             
   }
      
   else
   {
        //Задаем ограничение числа материалов на страницу
        $limit = $this->config->item('user_per_page');

        //Считаем общее количество материалов в конкретной категории
        $total = $this->materials_model->count_by($section_id);
        
        //Настройки (для чего навигация, имя для подстановки к base_url,           всего, ограничение)
        $settings = $this->pagination_lib->get_settings('section',$section_id,$total,$limit);

        //Применяем настройки
        $this->pagination->initialize($settings);        
        
        // Получаем список материалов, разбитый в соответствии с                  настройками
        $data['materials_list'] = $this->materials_model->get_by($section_id,$limit,$start_from);
        
        // Получаем код ссылок постраничной навигации
        $data['page_nav'] = $this->pagination->create_links();
        $name = 'sections/content';
        
        $this->display_lib->user_page($data,$name);
   }
}




//Добавление категории
public function add()
{ 
    $this->auth_lib->check_admin();
    
    $this->load->helper('tinymce');
    
    //Если нажата кнопка "Добавить категорию"  
    if (isset($_POST['add_button']))
    {    
        $this->form_validation->set_rules($this->sections_model->add_rules);

     	if ($this->form_validation->run() == TRUE)
        {        
            //Добавляем новую категорию
            $this->sections_model->add();
            
            $data = array('info' => 'Категория добавлена');
            $this->display_lib->admin_info_page($data);
        }

        else
        {            
            $name = 'sections/add';
            
            // Передаем пустой массив data так как того требует функция               admin_page
            $this->display_lib->admin_page($data = array(),$name); 			
        }        
    }
      
    //Если не нажата кнопка "Добавить категорию", выводим пустую форму
    else
    {
        $name = 'sections/add';
        $this->display_lib->admin_page($data = array(),$name);
    }
}



//Редактирование (вывод списка категорий для выбора)  
public function edit_list()
{
    $this->auth_lib->check_admin();
    
    //Массив по всем категориям для вывода списка
    $data = array('sections_list' => $this->sections_model->get_all());
    $name = 'sections/edit_list';
    
    $this->display_lib->admin_page($data,$name);
}



//Редактирование (форма со значениями, подставившимися из базы) 
public function edit($section_id = '')
{
    $this->auth_lib->check_admin();
    
    $this->load->helper('tinymce');
    
    //Массив одной категории для отображения в форме редактирования
    $data = array();
    $data = $this->sections_model->get($section_id);        

    //Если массив пуст
    if (empty($data))
    {
        $data = array('info' => 'Такой категории не существует');
        $this->display_lib->admin_info_page($data);                  
    }
        
    else
    {   
        $name = 'sections/edit';
        $this->display_lib->admin_page($data,$name);            
    }
}




//Обновление (Обновление категории в базе данных)  
public function update($section_id = '')
{
   $this->auth_lib->check_admin(); 
   
   $this->load->helper('tinymce');
    
   //Если нажата кнопка "Обновить категорию"    
   if (isset($_POST['update_button']))
   {
       $this->form_validation->set_rules($this->sections_model->update_rules);
		
	   if ($this->form_validation->run() == TRUE)
       {        
           //Обновляем категорию
           $this->sections_model->update($section_id);
           $data = array('info' => 'Категория обновлена');
                  
           $this->display_lib->admin_info_page($data);
       } 
       
       else
       {    
            //Формируем массив с данными о категории для подстановки в поля формы (те, что не прошли                   валидацию, берутся из базы, а те, что прошли - из массива POST)
            $data = array();	             
            $data = $this->sections_model->get($section_id);                    
            $name = 'sections/edit';
            
            $this->display_lib->admin_page($data,$name);			
       }
   }
       
   //Не нажата кнопка "Обновить категорию"
   else
   {
       $data = array('info' => 'Категория не была обновлена, так как вы не нажали кнопку "Обновить                категорию"');
       $this->display_lib->admin_info_page($data);
   }
}



//Удаление категории
public function delete()
{
    $this->auth_lib->check_admin();
    
    //Если не нажата кнопка "Удалить категорию", выводим список категорий
    if ( ! isset($_POST['delete_button']))
    {         
        //Массив по всем категориям для вывода списка
        $data = array('sections_list' => $this->sections_model->get_all());       
        $name = 'sections/delete';
        $this->display_lib->admin_page($data,$name);             
    }
    
    //Если кнопка "Удалить категорию" нажата
    else
    {
        //но не выбрана категория
        if ( ! isset($_POST['section_id']))
        {
            $data = array('info' => 'Не выбрана категория для удаления');       
            $this->display_lib->admin_info_page($data);              
        }
        
        //и выбрана категория
        else 
        {  
            //Получаем идентификатор категории из массива POST
            $section_id = $this->input->post('section_id');
            
            //Удаляем категорию с выбранным идентификатором
            $this->sections_model->delete($section_id);
            
            $data = array('info' => 'Категория удалена');
            $this->display_lib->admin_info_page($data);
        }
    }
}



}
?>