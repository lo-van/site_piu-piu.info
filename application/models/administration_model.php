<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administration_model extends CI_Model
{
    
    
//правила для страницы настроек
public $preferences_rules = array
(
    array
    (
      'field' => 'admin_login',
      'label' => 'Логин',
      'rules' => 'alpha_dash|trim|required|max_length[50]'
    ),
    array
    (
      'field' => 'admin_pass',
      'label' => 'Пароль',
      'rules' => 'alpha_dash|trim|required|max_length[50]'
    ),
    array
   (
     'field' => 'user_per_page',
     'label' => 'Материалов на страницу',
     'rules' => 'required|numeric'
   ),
    array
   (
     'field' => 'admin_per_page',
     'label' => 'Материалов на страницу',
     'rules' => 'required|numeric'
   )
);



//правила для страницы логина
public $login_rules = array
(
    array
    (
      'field' => 'login',
      'label' => 'Логин',
      'rules' => 'trim|required|alpha_dash|max_length[50]'
    ),
    array
    (
      'field' => 'pass',
      'label' => 'Пароль',
      'rules' => 'trim|required|alpha_dash|max_length[50]'
    )
);


//правила для поиска
public $search_rules = array
(
    array
    (
      'field' => 'search',
      'label' => 'Поисковый запрос',
      'rules' => 'required|trim|min_length[3]|max_length[50]|xss_clean'
    )
);


public function __construct()
{       
    parent::__construct();
    $this->get_preferences();
}


//Считывание настроек из базы в массив config для дальнейшего использования
public function get_preferences()
{
    $query = $this->db->get('preferences');
    
    //Получаем в переменную массив со всеми настройками
    $preferences = $query->result_array();
    
    foreach ($preferences as $item)
    {
        $val = $item['value']; 
                
        if(is_numeric($val))
        {
            settype($val,"int");
        }     
        
        //Устанавливаем элементу значение
        $this->config->set_item($item['pref_id'],$val);          
    }    
}


// Получение списка месяцев из БД
public function get_archive()
{
    $sql = "SELECT DISTINCT left(date,7) AS month FROM materials ORDER BY month DESC";
    $query = $this->db->query($sql);
    return $query->result_array();
}


// Получение информации по материалам за конкретный месяц
public function archive_by_month($url_month)
{
    $this->db->like('date',$url_month,'both');
    $this->db->order_by ('material_id','desc');
    $query = $this->db->get('materials');
    return $query->result_array();//Возвращаем массив с результатами
}


// Формирование RSS-ленты
public function feeds_info()
{
    $this->db->order_by ('material_id','desc');
    $this->db->limit(6);
    $query = $this->db->get('materials');
    
    //Возвращаем массив с материалами для формирования ленты
    return $query->result_array();
}



//Поиск по материалам (поисковый запрос, количество результатов на странице, с какого результата начинать)
public function materials_search($search,$limit,$start_from)
{
    $query = $this->db->get('materials');
    
    //Получаем массив со всеми материалами
    $all_materials = $query->result_array();

    //Начальное значение счетчика для подсчета количества материалов,         удовлетворяющих поисковому запросу
    $i = -1;

    //Объявляем массив (важно, вне цикла foreach) - в нем будут находиться    все найденные по запросу материалы
    $total_result = array();
    
    //Делаем проход по всем материалам   
    foreach ($all_materials as $material)
    {   
        //Удаляем все тэги в поле main_text
        $material['main_text'] = strip_tags ($material['main_text']);
        
        //Вычисляем общую длину поля main_text (положительное число)
        $length = strlen ($material['main_text']);        
        
        //Находим позицию первого вхождения поискового запроса -                  положительное число (stripos - не чувствительна к регистру)
        $position = stripos ($material['main_text'],$this->session->userdata('search_query'));                  

        //Если найдено вхождение поискового запроса, т.е. $position не            равна FALSE
        if ($position !== FALSE)
        {
            //Увеличиваем на "1" счетчик материалов, удовлетворяющих                  запросу (нужно для формирования элементов массива                         $total_result )
            $i++;
            
            //Начальная позиция вывода: 100 - на сколько символов до                  искомого запроса мы начинаем вывод), в любом случае                       $begin_from будет содержать отрицательное число
            $begin_from = $position - $length - 100;                  

            //Получаем нужную нам часть: строка; откуда начинаем; общая               длина фрагмента. (так как $begin_from имеет отрицательное                 значение, то возвращаемая строка будет начинаться с                       $begin_from знака, считая с конца строки)      
            $material['main_text'] = substr ($material['main_text'],$begin_from, 250);        

            // Формируем массив со всеми найденными материалами в цикле ($i увеличивается при каждом подходящем материале, и мы получаем массив со всеми материалами, содержащими поисковый запрос, который для каждого подходящего материала содержит указанные ниже, нужные нам поля)
            $total_result[$i][0] = $material['material_id'];
            $total_result[$i][1] = $material['title'];
            $total_result[$i][2] = $material['main_text'];
            $total_result[$i][3] = $material['small_img_url'];
            $total_result[$i][4] = $material['author'];
            $total_result[$i][5] = $material['count_views'];
            $total_result['counter'] = $i+1; // прибавляем "1" к переменной $i, так как нам нужно реальное количество удовлетворяющих запросу материалов, а нумерация у нас идет с нуля (мы сами задали начальное значение счетчика в "-1", увеличивая его при каждом подходящем материале)     
        }           
    }

    // Объявляем массив (важно, вне цикла) - в нем будут формироваться        найденные материалы в соответствии с разбивкой pagination
    $msearch_results = array();
    
    // Для этого запускаем цикл: $start_from (с какого по счету найденного материала начинать вывод) передается функции materials_search по ссылке, сформированной с помощью pagination в результатах поиска; $limit - ограничение
    for ($i = $start_from; $i < $start_from + $limit; $i++)
    {
        //Проверяем, есть ли хоть один результат поиска (произвольно берем        для проверки поле material_id)
        if (isset ($total_result[$i][0]))
        {     
            $msearch_results[$i][0] = $total_result[$i][0];
            $msearch_results[$i][1] = $total_result[$i][1];
            $msearch_results[$i][2] = $total_result[$i][2];
            $msearch_results[$i][3] = $total_result[$i][3];
            $msearch_results[$i][4] = $total_result[$i][4];
            $msearch_results[$i][5] = $total_result[$i][5];
            
            //Общее количество найденных материалов
            $msearch_results['counter'] = $total_result['counter']; 
            
            // С какого найденного материала начинать вывод
            $msearch_results['start_from'] = $start_from;
            
            // Ограничение 
            $msearch_results['limit'] = $limit; 
        }    
    }
    
    //Возвращаем сформированный массив
    return $msearch_results;      
}


}
?>