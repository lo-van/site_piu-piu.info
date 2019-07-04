<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administration extends CI_Controller
{  


public function index()
{
   $this->auth_lib->check_admin();
    
   $this->load->model('comments_model');
   $this->load->model('pages_model');
   $this->load->model('sections_model');

   $data = array();
   
   // всего материалов
   $data['materials_count']   = $this->materials_model->count_all();
   
   // всего страниц 
   $data['pages_count']       = $this->pages_model->count_all(); 
   
   // всего категорий
   $data['sections_count']    = $this->sections_model->count_all();
   
   // всего комментариев 
   $data['comments_count']    = $this->comments_model->count_all(); 
   
   //популярные материалы
   $data['popular_materials'] = $this->materials_model->get_popular(); 
   
   //свежие комментарии
   $data['latest_comments']   = $this->comments_model->get_latest(); 

   $name = 'main_admin';
   $this->display_lib->admin_page($data,$name);
}
    

public function archive()  
{
    //Дата из 2 сегмента url
    $url_month = $this->uri->segment(2);    
    
    // Если длина 2 сегмента url не равна 7
    if (strlen($url_month) != 7)
    {
        redirect (base_url());
    }
    
    else
    {        
        $data = array();
        
        //Массив по свежим материалам
        $data['latest_materials'] = $this->materials_model->get_latest();  
        //Архив
        $data['archive_list'] = $this->administration_model->get_archive(); 
        //Массив по популярным материалам
        $data['popular_materials'] = $this->materials_model->get_popular(); 
        $data['url_month'] = $url_month;
        
        //Материалы за месяц
        $data['archive_result'] = $this->administration_model->archive_by_month($url_month);        
        
        // Если некорректные данные
        if ( ! $data['archive_result'])
        {
            redirect (base_url());        
        }
        
        else
        {    
            $name = 'admin/archive';    
            $this->display_lib->user_info_page($data,$name); 
        }    
    }   
}



public function preferences()
{
   $this->auth_lib->check_admin();
    
   //Если нажата кнопка "Сохранить настройки"
   if (isset($_POST['save_button']))
   {
       //Установка правил валидации
       $this->form_validation->set_rules($this->administration_model->preferences_rules);

       //Если валидация успешно пройдена
       if ($this->form_validation->run() == TRUE)
       {
           //Заносим в массив data полученные из формы переменные
           $data = array();
           $data['user_per_page']   = $this->input->post('user_per_page');
           $data['admin_per_page']  = $this->input->post('admin_per_page');
           $data['admin_login']     = $this->input->post('admin_login');
           $data['admin_pass']      = $this->input->post('admin_pass');
           $data['search_per_page'] = $this->input->post('search_per_page');   
           
           foreach ($data as $key => $value)
           {    
                //Обновление в цикле для каждой настройки      
                $this->db->where('pref_id',$key);
                //Второй параметр для update - массив (полю value присваиваем значение переменной $value)
                $this->db->update('preferences',array('value' => $value));
           }
           
           $data = array('info' => 'Настройки сохранены');                
           $this->display_lib->admin_info_page($data);
       }
       
       //Если валидация не пройдена
       else
       {
            $name = 'preferences';
            
            //Передаем пустой массив data, так как этого требует функция              admin_page()
            $this->display_lib->admin_page($data = array(),$name);// 
       }
   }   
    
   //Кнопка "Сохранить настройки" не нажата: выводим просто форму с подставленными из базы данными (данные напрямую берутся в виде, что не    совсем по правилам)
   else
   {
       $name = 'preferences';
       $this->display_lib->admin_page($data = array(),$name);
   }
}



public function login()
{
    //Установка правил валидации
    $this->form_validation->set_rules($this->administration_model->login_rules);

    //Если валидация не пройдена
    if ($this->form_validation->run() == FALSE)
    {
        $this->display_lib->login_page();
    }

    //Если валидация пройдена, пытаемся войти
    else
    {
        $this->auth_lib->do_login($this->input->post('login'),$this->input->post('pass'));
    }
}


public function logout()
{
    //Проверяем, был ли осуществлен вход
    $this->auth_lib->check_admin();//Здесь проверка не так обязательна в принципе
    $this->auth_lib->do_logout();
}


public function rss()  
{
    $data = array('feeds' => $this->administration_model->feeds_info());
    $this->load->view('rss_view',$data);
}



public function search($start_from = 0)
{
    $this->load->library('pagination');
    $this->load->library('pagination_lib');
    
    // для подсветки поискового запроса в виде с результатами поиска
    $this->load->helper('text'); 

    // Формируем элементы, нужные в любом случае
    $data = array();    
    
    //Массив по свежим материалам
    $data['latest_materials'] = $this->materials_model->get_latest(); 
    
    //Архив 
    $data['archive_list'] = $this->administration_model->get_archive(); 
    
    //Массив по популярным материалам
    $data['popular_materials'] = $this->materials_model->get_popular(); 
    
    //Задаем количество результатов поиска на страницу
    $limit = $this->config->item('search_per_page');

    // Если нажата кнопка "Искать"
    if (isset($_POST['search_button']))
    {  
        //Установка правил валидации
        $this->form_validation->set_rules($this->administration_model->search_rules);
        
        $val_res = $this->form_validation->run();

        // Формируем массив с пустыми значениями
        $ses_search = array();
        $ses_search['val_passed'] = ''; // Прошла ли валидация
        $ses_search['search_query'] = ''; // Поисковый запрос
        $this->session->set_userdata($ses_search);//Записываем сессию
        
        // Если валидация пройдена 
        if ($val_res == TRUE)
        {
            //TRUE - фильтруем на xss-атаку            
            $search = $this->input->post('search',TRUE);
            
            // конвертация спецсимволов в html-сущности, чтобы введенный              запрос не содержал разметки html
            $search = htmlspecialchars($search); 
            
            // Записываем сессию после прохождения валидации
            $ses_search = array();    
            
            // Валидация пройдена успешно для поискового запроса        
            $ses_search['val_passed'] = 'yes'; 
            
            // Поисковый запрос
            $ses_search['search_query'] = $search;  
            
            //Записываем сессию          
            $this->session->set_userdata($ses_search);
            
            //Массив по найденным материалам
            $msearch_results = $this->administration_model->materials_search($search,$limit,$start_from);  
            
            // Если массив пуст
            if (empty ($msearch_results))
            {                      
                $data['info'] = 'Информации по Вашему запросу не найдено';                             
                $name = 'info';
                
                $this->display_lib->user_info_page($data,$name);
            }
            
            // Поиск дал результат
            else
            {
                //Считаем общее количество страниц, содержащих поисковый запрос
                $total = $msearch_results['counter'];             
                
                //Настройки (для чего навигация, имя для подстановки к                    base_url, всего, ограничение)
                $settings = $this->pagination_lib->get_settings('search','',$total,$limit);
                
                //Применяем настройки
                $this->pagination->initialize($settings);
                
                // массив по найденным материалам
                $data['msearch_results'] = $msearch_results; 
                
                //ссылки pagination         
                $data['page_nav'] = $this->pagination->create_links();
                 
                $name = 'admin/search';
                $this->display_lib->user_info_page($data,$name);            
            }
        }

        // Если валидация не пройдена
        else
        {
            $data['info'] = 'Неверные параметры поиска';                              
            $name = 'info';                  

            $this->display_lib->user_info_page($data,$name);
        }        
    }

    // Если не нажата кнопка "Искать"
    else
    {
        // но в сессии хранится информация об успешном прохождении                валидации
        if ($this->session->userdata('val_passed') === 'yes')
        {
            // Заносим в переменую search строку поискового запроса,                  сохраненную в сессии
            $search = $this->session->userdata('search_query');

            //Массив по найденным материалам
            $msearch_results = $this->administration_model->materials_search($search,$limit,$start_from);
            
            // Если массив пуст
            if (empty($msearch_results))
            {                       
                $data['info'] = 'Информации по Вашему запросу не найдено';                             
                $name = 'info';
                
                $this->display_lib->user_info_page($data,$name);            
            }
            
            // Поиск дал результат
            else
            {
                //Считаем общее количество страниц, содержащих поисковый                  запрос
                $total = $msearch_results['counter'];
                
                //Настройки (для чего навигация, имя для подстановки к                    base_url, всего, ограничение)
                $settings = $this->pagination_lib->get_settings('search','',$total,$limit);

                //Применяем настройки
                $this->pagination->initialize($settings);
                
                // массив по найденным материалам
                $data['msearch_results']  = $msearch_results; 
                
                // ссылки pagination    
                $data['page_nav'] = $this->pagination->create_links(); 
                
                $name = 'admin/search';           
                $this->display_lib->user_info_page($data,$name);
            }
        }

        // и в сессии нет информации об успешном прохождении валидации
        else
        {
            $data['info'] = 'Неверные параметры поиска';                          
            $name = 'info';

            $this->display_lib->user_info_page($data,$name);
        }
    }
}

      
}      
?>