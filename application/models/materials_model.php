<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Materials_model extends Crud
{
    
public $table = 'materials'; //Имя таблицы	
public $idkey = 'material_id'; //Имя ID


// правила для добавления нового материала
public $add_rules = array
(
    array
    (
      'field' => 'title',
      'label' => 'Название материала',
      'rules' => 'required|max_length[250]'
    ),
    array
    (
      'field' => 'description',
      'label' => 'Мета-описание материала',
      'rules' => 'required|max_length[250]'
    ),        
    array
    (
      'field' => 'keywords',
      'label' => 'Ключевые слова',
      'rules' => 'required|max_length[250]'
    ),        
    array
    (
      'field' => 'small_img_url',
      'label' => 'Путь к мини-иконке для анонса',
      'rules' => 'required'
    ),
    array
    (
      'field' => 'short_text',
      'label' => 'Краткое описание',
      'rules' => 'required'
    ),
    array
    (
      'field' => 'main_text',
      'label' => 'Полный текст',
      'rules' => 'required'
    ),
    array
    (
      'field' => 'date',
      'label' => 'Дата добавления',
      'rules' => 'required'
    ),
    array
    (
      'field' => 'author',
      'label' => 'Автор материала',
      'rules' => 'required|max_length[250]'
    ),
    array
    (
      'field' => 'section[]',
      'label' => 'Категория',
      'rules' => 'required'
    )
);



// правила для обновления нового материала
public $update_rules = array
(                   
    array
    (
      'field' => 'title',
      'label' => 'Название материала',
      'rules' => 'required|max_length[250]'
    ),        
    array
    (
      'field' => 'description',
      'label' => 'Мета-описание материала',
      'rules' => 'required|max_length[250]'
    ),        
    array
    (
      'field' => 'keywords',
      'label' => 'Ключевые слова',
      'rules' => 'required|max_length[250]'
    ),        
    array
    (
      'field' => 'small_img_url',
      'label' => 'Путь к мини-иконке для анонса',
      'rules' => 'required'
    ),
    array
    (
      'field' => 'short_text',
      'label' => 'Краткое описание',
      'rules' => 'required'
    ),
    array
    (
      'field' => 'main_text',
      'label' => 'Полный текст',
      'rules' => 'required'
    ),
    array
    (
      'field' => 'date',
      'label' => 'Дата добавления',
      'rules' => 'required'
    ),
    array
    (
      'field' => 'author',
      'label' => 'Автор материала',
      'rules' => 'required|max_length[250]'
    ),
    array
    (
      'field' => 'section[]',
      'label' => 'Категория',
      'rules' => 'required'
    )
);    
    

public function get_latest()
{
    $this->db->order_by ('material_id','desc');
    $this->db->limit (9);
    $query = $this->db->get('materials');
    return $query->result_array();//Возвращаем массив с последними материалами
}


public function get_popular()
{
    $this->db->order_by('count_views','desc');
    $this->db->limit (9);
    $query = $this->db->get('materials');
    return $query->result_array();//Возвращаем массив с наиболее просматриваемыми материалами
}


// Обновление значения счетчика просмотров
public function update_counter($material_id,$counter_data)
{
    $this->db->where('material_id',$material_id);
    $this->db->update('materials',$counter_data);
}


//получает три параметра: id категории, ограничение количества записей, и с какой записи начать
public function get_by($section_id,$limit,$start_from)
{
    $this->db->order_by('material_id','desc');
    $this->db->where ('section0',$section_id);
    for ($i=1;$i<6;$i++)
    {
        $cname = 'section'.$i;
        $this->db->or_where($cname,$section_id);
    }
     
    //ограничиваем запрос к базе двумя параметрами     
    $this->db->limit($limit,$start_from);       

    $query = $this->db->get('materials');
    
    // Возвращает массив с материалами конкретной категории, урезанный в      соответствии с разбивкой pagination
    return $query->result_array();
}
    

//Подсчет количества материалов в конкретной категории
public function count_by($section_id)
{
    $this->db->where ('section0',$section_id);
    for ($i=1;$i<6;$i++)
    {
        $cname = 'section'.$i;
        $this->db->or_where($cname,$section_id);
    }

    return $this->db->count_all_results('materials');
}


public function get_all($limit,$start_from)
{
    $this->db->order_by('material_id','desc');
    
    //ограничиваем запрос к базе двумя параметрами
    $this->db->limit($limit,$start_from);    
    $query = $this->db->get('materials');
    
    //Возвращаем массив с материалами, урезанный в соответствии с             разбивкой pagination
    return $query->result_array();
}


//Получение значений, хранящихся в полях section0 - section4 для конкретного материала
public function get_section_values($material_id)
{
    $this->db->where('material_id',$material_id);
    for ($i=0;$i<6;$i++)
    {
        $cname = 'section'.$i;
        $this->db->select($cname);
    }

    $query = $this->db->get('materials');
    return $query->row_array();
}
    
    
}
?>