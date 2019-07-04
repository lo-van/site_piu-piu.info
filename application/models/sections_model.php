<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sections_model extends Crud
{  

public $table = 'sections'; //Имя таблицы	
public $idkey = 'section_id'; //Имя ID
 
 
// правила для добавления новой категории
public $add_rules = array
(
    array
    (
      'field' => 'section_id',
      'label' => 'Идентификатор категории',
      'rules' => 'trim|required|alpha_dash|max_length[100]'
    ),
    array
    (
      'field' => 'title',
      'label' => 'Название категории',
      'rules' => 'required|max_length[100]'
    ),
    array
    (
      'field' => 'description',
      'label' => 'Мета-описание категории',
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
      'field' => 'main_text',
      'label' => 'Краткое описание категории',
      'rules' => 'required'
    )
);


// правила для обновления категории
public $update_rules = array
(
    array
    (
      'field' => 'title',
      'label' => 'Название категории',
      'rules' => 'required|max_length[100]'
    ),        
    array
    (
      'field' => 'description',
      'label' => 'Мета-описание категории',
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
      'field' => 'main_text',
      'label' => 'Краткое описание категории',
      'rules' => 'required'
    )
);



//массив со всеми категориями    
public function get_all()
{
    $query = $this->db->get('sections');
    return $query->result_array();
}
    

}
?>