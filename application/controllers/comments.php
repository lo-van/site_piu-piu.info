<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comments extends CI_Controller
{ 
    
public function __construct()
{
   parent::__construct();    
   $this->load->model('comments_model');                
} 

//По умолчанию передаем материал с пустым id
public function add($material_id = '')
{
    $this->load->library('table');
    $this->load->library('captcha_lib');
    $this->load->library('typography');
    
    // Подготавливаем массив с картинками-смайлами
    $img_array = get_clickable_smileys(base_url().'img/smileys/','comment_text');
	$col_array = $this->table->make_columns($img_array,15);    
          
    
    $data = array();    
    //Массив по свежим материалам
    $data['latest_materials']  = $this->materials_model->get_latest();     
    //Массив по популярным материалам
    $data['popular_materials'] = $this->materials_model->get_popular();
    
    // Архив
    $data['archive_list'] = $this->administration_model->get_archive(); 
    
    //Массив по одному материалу
    $data['main_info'] = $this->materials_model->get($material_id); 
    
    // Комментарии к материалу
    $data['comments_list'] = $this->comments_model->get_by($material_id); 
    
    $data['latest_comments'] = $this->comments_model->get_latest($material_id); 
    
    // Готовая таблица смайлов
    $data['smiley_table'] = $this->table->generate($col_array); 
                
    // Не нажата кнопка "Комментировать"    
    if ( ! isset($_POST['post_comment']))
    {         
        $data['info'] = 'Вы обратились к файлу напрямую, не нажав кнопку "Комментировать"';              
        $name = 'info'; 
                
        $this->display_lib->user_info_page($data,$name);       
    }
    
    // Нажата кнопка "Комментировать"
    else
    {                 
        //Установка правил валидации
        $this->form_validation->set_rules($this->comments_model->add_rules);
        	  
        $val_res = $this->form_validation->run();
              
        // Если валидация пройдена
        if ($val_res == TRUE)
        {
             //Получаем значение поля капча
             $entered_captcha = $this->input->post('captcha');
        		   
             //Если оно совпадает со значением в сессии (значение там уже есть - сессия с цифрами капчи создается при просмотре материала, а комментирование идет только со страницы материала)	
             if ($entered_captcha == $this->session->userdata('rnd_captcha'))
             {
                  $comment_text = $this->input->post('comment_text');                       
                  // TRUE - более двух переводов строки все равно                           считаются за два перевода           
                  $comment_text = $this->typography->auto_typography($comment_text,TRUE);
                  
                  $comment_text = parse_smileys($comment_text,base_url().'img/smileys/');           
                
                
                  // Массив для вставки данных по комментарию
                  $comment_data = array(); 
                  
                  //Уже передан как параметр функции add                 
                  $comment_data['material_id'] = $material_id;       
                  $comment_data['author'] = $this->input->post('author');
                  $comment_data['comment_text'] = $comment_text; 
                  $comment_data['date'] = date('Y-m-d');
                  
                  //Вставляем комментарий в базу
                  $this->comments_model->add_new($comment_data);                   
                                  
           //Готовим данные для отправки письма-оповещения администратору
                  //Имя отправителя
                  $author = $this->input->post('author'); 
                  
             // Переносы после 70 знаков (ограничение функции mail в PHP)
                  $comment_text = wordwrap($comment_text,70); 
                  
                  // Удаляем html-тэги для удобства чтения      
                  $comment_text = strip_tags($comment_text);
                  
                  //Куда отправляется письмо
                  $address = "lomakin.ivan@gmail.com"; 
                  
                  // Тема письма
                  $subject = "Комментарий к материалу: ".$data['main_info']['title']; 
                  // Сообщение
                  $message = "Написал(а):$author\nТекст комментария:\n$comment_text\nСсылка: http://www.piu-piu.info/materials/$material_id#captcha";                
                  
                  // Оправляем письмо-оповощение   
        	      mail ($address,$subject,$message,"Content-type:text/plain;charset = windows-1251\r\n");                   
                  $data['fail_captcha'] = '';
                  $data['success_comment']  = 'Ваш комментарий успешно добавлен<br><a href="#new_comment">Просмотреть комментарий</a>';          
                  //получаем код капчи
                  $data['imgcode']  = $this->captcha_lib->captcha_actions(); 
                 //Получаем список комментариев к материалу заново (так                    как только что был добавлен новый комментарий)
                  $data['comments_list'] = $this->comments_model->get_by($material_id);  
                                                    
                  $name = 'materials/content'; 
                  $this->display_lib->user_page($data,$name);                    
             }   
                 
             // Если капча не совпадает
             else 
             {                                    
                  $data['fail_captcha'] = 'Неверно введены цифры с картинки<br><a href="#captcha">Ввести еще раз!<a>';
                  
                  //получаем код капчи
                  $data['imgcode']  = $this->captcha_lib->captcha_actions(); 
                  
                  $data['success_comment']  = '';                        
                                      
                  $name = 'materials/content';                   
                  $this->display_lib->user_page($data,$name);                 
             }                  
        }
            
        //Если валидация не пройдена
        else
        {               
            $data['fail_captcha'] = '';
            $data['imgcode']  = $this->captcha_lib->captcha_actions(); //получаем код капчи
            $data['success_comment']  = '';            
                                  
            $name = 'materials/content'; 
            $this->display_lib->user_page($data,$name);          
        }            
    }
}




//Редактирование комментария (вывод списка для выбора комментария)  
public function edit_list($start_from = 0)
{
    $this->auth_lib->check_admin();
    
    $this->load->library('pagination');
    $this->load->library('pagination_lib');
    
    //Задаем ограничение числа комментариев на страницу
    $limit = $this->config->item('admin_per_page');

    //Считаем общее количество комментариев
    $total = $this->comments_model->count_all();

    //Настройки (для чего навигация, имя для подстановки к base_url, всего, ограничение)
    $settings = $this->pagination_lib->get_settings('comment_edit_list','',$total,$limit);

    //Применяем настройки
    $this->pagination->initialize($settings);       

    //Получаем список всех комментариев и передаем функции параметры для pagination
    $data['comments_list'] = $this->comments_model->get_all($limit,$start_from);
    
    // ссылки для pagination                       
    $data['page_nav'] = $this->pagination->create_links();  
                   
    $name = 'comments/edit_list';
    $this->display_lib->admin_page($data,$name);
}



//Редактирование комментария (форма со значениями, подставившимися из базы)
public function edit($comment_id = '')
{
    $this->auth_lib->check_admin();
    
    $this->load->helper('tinymce');
    
    //Формируем массив одного комментария (row_array) для отображения в       форме редактирования
    $data = array(); 
    $data = $this->comments_model->get($comment_id);
        
    //Если массив пуст
    if (empty($data))
    {
        $data = array('info' => 'Такого комментария не существует');      
        $this->display_lib->admin_info_page($data);
    }
        
    else
    {
        $name = 'comments/edit';
        $this->display_lib->admin_page($data,$name);
    }
}



//Обновление комментария (Обновление комментария в базе данных) 
public function update($comment_id = '')
{
   $this->auth_lib->check_admin();
   
   $this->load->helper('tinymce');
    
   //Если нажата кнопка "Обновить комментарий"
   if (isset($_POST['update_button']))
   {
       $this->form_validation->set_rules($this->comments_model->update_rules);

       // Если валидация пройдена 
	   if ($this->form_validation->run() == TRUE)
       {
           //Обновляем комментарий
           $this->comments_model->update($comment_id);

           $data = array('info' => 'Комментарий обновлен');
           $this->display_lib->admin_info_page($data);
       } 
       
       else
       {    
            //формируем массив с данными о комментарии для подстановки в              поля формы (те, что не прошли валидацию, берутся из базы, а те            , что прошли - из массива POST)
            $data = array();	             
            $data = $this->comments_model->get($comment_id);                    
            $name = 'comments/edit';
            $this->display_lib->admin_page($data,$name);
       }
   } 
   
   //Не нажата кнопка "Обновить комментарий"
   else
   {     
       $data = array('info' => 'Комментарий не был обновлен, так как вы не       нажали кнопку "Обновить комментарий"');
       $this->display_lib->admin_info_page($data);             
   }
}



//Удаление комментария  
public function delete($start_from = 0)
{
    $this->auth_lib->check_admin();
    
    $this->load->library('pagination');
    $this->load->library('pagination_lib');

    //Если не нажата кнопка "Удалить комментарий"
    if ( ! isset($_POST['delete_button']))
    {
        //Задаем ограничение числа комментариев на страницу
        $limit = $this->config->item('admin_per_page');

        //Считаем общее количество комментариев
        $total = $this->comments_model->count_all();

        //Настройки (для чего навигация, имя для подстановки к base_url, всего, ограничение)
        $settings = $this->pagination_lib->get_settings('comment_delete','',$total,$limit);
    
        //Применяем настройки
        $this->pagination->initialize($settings);        
                
        //Получаем список всех комментариев и передаем функции параметры          для pagination
        $data['comments_list'] = $this->comments_model->get_all($limit,$start_from);  
        
        // ссылки для pagination                     
        $data['page_nav'] = $this->pagination->create_links();   

        $name = 'comments/delete';    
        $this->display_lib->admin_page($data,$name);            
    }

    //Если кнопка "Удалить комментарий" нажата
    else
    {
        //но не выбран комментарий
        if ( ! isset($_POST['comment_id']))
        {
            $data = array('info' => 'Не выбран комментарий для удаления');
            $this->display_lib->admin_info_page($data);
        }

        //и выбран комментарий
        else
        {  
            //Получаем идентификатор комментария из массива POST
            $comment_id = $this->input->post('comment_id');
            
            //Удаляем комментарий с выбранным идентификатором
            $this->comments_model->delete($comment_id);      
            
            $data = array('info' => 'Комментарий удален');       
            $this->display_lib->admin_info_page($data);             
        }
    }                
}





}
?>