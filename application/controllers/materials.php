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
    
   // Формируем элементы, нужные в любом случае
   $data = array();
   
   //Массив по свежим материалам
   $data['latest_materials'] = $this->materials_model->get_latest();  
   
   //Массив по популярным материалам
   $data['popular_materials'] = $this->materials_model->get_popular();
   
   // Архив
   $data['archive_list'] = $this->administration_model->get_archive();
   
   $data['latest_comments'] = $this->comments_model->get_latest($material_id); 
   
   // Массив по одному материалу 
   $data['main_info'] = $this->materials_model->get($material_id);       
         
   //Если массив пуст
   if (empty($data['main_info']))
   {                            
        $data['info'] = 'Нет такого материала';                              
        $name = 'info'; 
        
        $this->display_lib->user_info_page($data,$name);
   }
      
   else
   {
       //Формируем массив для обновления поля count_views (текущее число показов материала +1)  
       $counter_data = array('count_views' => $data['main_info']['count_views'] + 1);
     
       //Запускаем функцию обновления, меняющую значение счетчика в базе 
       $this->materials_model->update_counter($material_id,$counter_data);
       
       // Создаем простой индексный массив, содержащий все смайлики
       $img_array = get_clickable_smileys(base_url().'img/smileys/','comment_text');// Путь и id поля

       // Создаем многомерный массив из индексного и передаем, сколько           столбцов должно быть в таблице
	   $col_array = $this->table->make_columns($img_array,15); 
       
       // Сообщение, если неправильно введена капча
       $data['fail_captcha'] = '';
       
       // Сообщение, если комментарий успешно добавлен                   
       $data['success_comment'] = '';
       
       //Получаем код капчи
       $data['imgcode'] = $this->captcha_lib->captcha_actions(); 
       
       // Комментарии к материалу
       $data['comments_list'] = $this->comments_model->get_by($material_id);
       //Таблица смайлов
       $data['smiley_table'] = $this->table->generate($col_array);        
                                         
       $name = 'materials/content'; 
       $this->display_lib->user_page($data,$name);
   }    
}



//Добавление материала 
public function add()
{
    $this->auth_lib->check_admin();
    
    $this->load->helper('tinymce');
    
    //Если нажата кнопка "Добавить материал"  
    if (isset($_POST['add_button']))
    {      
        $this->form_validation->set_rules($this->materials_model->add_rules);
		
     	if ($this->form_validation->run() == TRUE)
        {
            //Добавляем новый материал
            $this->materials_model->add();

            $data = array('info' => 'Материал добавлен');
            $this->display_lib->admin_info_page($data);
        }
        
        else
        {            
            $name = 'materials/add';
            
            // Передаем пустой массив data так как того требует функция admin_page
            $this->display_lib->admin_page($data = array(),$name); 			
        }
    }  
      
    //Если не нажата кнопка "Добавить материал", выводим пустую форму
    else
    {    
        $name = 'materials/add';
        $this->display_lib->admin_page($data = array(),$name);            
    }  
}



//Редактирование материала (вывод списка материалов для выбора)  
public function edit_list($start_from = 0)
{
    $this->auth_lib->check_admin();
    
    $this->load->library('pagination');
    $this->load->library('pagination_lib');

    //Задаем ограничение числа материалов на страницу
    $limit = $this->config->item('admin_per_page');

    //Считаем общее количество материалов
    $total = $this->materials_model->count_all(); 

    //Настройки (для чего навигация, имя для подстановки к base_url, всего,ограничение)
    $settings = $this->pagination_lib->get_settings('material_edit_list','',$total,$limit);
                
    //Применяем настройки
    $this->pagination->initialize($settings);      

    // Список материалов
    $data['materials_list'] = $this->materials_model->get_all($limit,$start_from); 
    
    // Ссылки pagination   
    $data['page_nav'] = $this->pagination->create_links();
     
    $name = 'materials/edit_list';
    
    $this->display_lib->admin_page($data,$name);
}



//Редактирование материала (форма со значениями, подставившимися из базы) 
public function edit($material_id = '')
{
    $this->auth_lib->check_admin();
    
    $this->load->helper('checkbox');
    $this->load->helper('tinymce');    

    //Формируем массив одного материала для отображения в форме               редактирования
    $data = array();
    $data = $this->materials_model->get($material_id);

    //Если массив пуст
    if (empty($data))
    {
        $data = array('info' => 'Такого материала не существует');
        $this->display_lib->admin_info_page($data);                   
    }

    else
    {   
        //Получаем дополнительно значения полей section0 - section3
        $data['names'] = $this->materials_model->get_section_values($material_id);
        $name = 'materials/edit';    
        
        $this->display_lib->admin_page($data,$name);
    }
}



//Обновление материала (Обновление материала в базе данных) 
public function update($material_id = '')
{
   $this->auth_lib->check_admin(); 
    
   $this->load->helper('checkbox');
   $this->load->helper('tinymce');   

   //Если нажата кнопка "Обновить материал"
   if (isset($_POST['update_button']))
   {         
       $this->form_validation->set_rules($this->materials_model->update_rules);
		
	   if ($this->form_validation->run() == TRUE)
       {
           //Обновляем материал
           $this->materials_model->update($material_id);

           $data = array('info' => 'Материал обновлен');       
           $this->display_lib->admin_info_page($data);  
       } 
       
       else
       {
            //формируем массив с данными о материале для подстановки в поля формы (те, что не прошли валидацию, берутся из базы, а те            , что прошли - из массива POST)
            $data = array();
            $data = $this->materials_model->get($material_id); 
            
            //Получаем дополнительно значения полей section0 - section3
            $data['names'] = $this->materials_model->get_section_values($material_id);                   
            $name = 'materials/edit';

            $this->display_lib->admin_page($data,$name);			
       }       
   }
   
   //Не нажата кнопка "Обновить материал"    
   else
   {
       $data = array('info' => 'Материал не был обновлен, так как вы не нажали кнопку "Обновить материал"');
       $this->display_lib->admin_info_page($data);
   }
}



//Удаление материала
public function delete($start_from = 0)
{
    $this->auth_lib->check_admin();
    
    $this->load->library('pagination');
    $this->load->library('pagination_lib');

    //Если не нажата кнопка "Удалить материал"
    if ( ! isset($_POST['delete_button']))
    {
        //Задаем ограничение числа материалов на страницу 
        $limit = $this->config->item('admin_per_page');
      
        //Считаем общее количество материалов
        $total = $this->materials_model->count_all();        
      
        //Настройки (для чего навигация, имя для подстановки к base_url,          всего, ограничение)
        $settings = $this->pagination_lib->get_settings('material_delete','',$total,$limit);
                
        //Применяем настройки
        $this->pagination->initialize($settings);            
        
        //Список материалов, разбитый в соответствии с pagination   
        $data['materials_list'] = $this->materials_model->get_all($limit,$start_from); 
        
        // Ссылки pagination
        $data['page_nav'] = $this->pagination->create_links(); 
        $name = 'materials/delete';    
        
        $this->display_lib->admin_page($data,$name);
    }
    
    //Если кнопка "Удалить материал" нажата
    else
    {
        //но не выбран материал
        if ( ! isset($_POST['material_id']))
        {
            $data = array('info' => 'Не выбран материал для удаления');
            $this->display_lib->admin_info_page($data);        
        }

        //и выбран материал
        else 
        {  
            //Получаем идентификатор материала из массива POST
            $material_id = $this->input->post('material_id');
            
            //Удаляем материал с выбранным идентификатором
            $this->materials_model->delete($material_id);           
            
            $data = array('info' => 'Материал удален');
            $this->display_lib->admin_info_page($data);
        }
    }
}
   
   


}
?>