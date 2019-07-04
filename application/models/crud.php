<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crud extends CI_Model
{
    
public $table = ''; //»м€ таблицы	
public $idkey = ''; //»м€ ID	


public function __construct()
{       
    parent::__construct();         
}

// ѕолучение данных об одной записи
public function get($obj_id)
{
    $this->db->where($this->idkey,$obj_id);
    $query = $this->db->get($this->table);
    return $query->row_array();
}


// ѕодсчет общего числа записей
public function count_all()
{
    return $this->db->count_all($this->table);
}


// ƒобавление записи
public function add()
{
     $data = array();  
     $section = $this->input->post('section'); 
     
     // если добавл€етс€ не материал (так как данное поле есть только у материлов)
     if (empty($section))
     {
	     foreach ($this->add_rules as $item)
         {
             $f = $item['field'];
             $data[$f] = $this->input->post($f);
	     }         
     }

     //если добавл€етс€ материал
     else
     {
         foreach ($this->add_rules as $item)
         {
             $f = $item['field'];
             
             switch($f)
             {
                 case 'section[]':
                 
                     unset($f);
                     break;  
                     
                 default:
                 
                     $data[$f] = $this->input->post($f);
                     break;
             }
	     }
         
         $i = 0;
         foreach ($section as $one)
         {
             $cname = 'section'.$i;
             $$cname = $section[$i];
             $data[$cname] = $$cname;
             $i++;
         }
     }

	 $this->db->insert($this->table,$data);
}



// ќбновление записи
public function update($obj_id)
{
     $data = array ();
     $section = $this->input->post('section');

     // если обновл€етс€ не материал (так как данное поле есть только у материлов)
     if (empty($section))
     {
         foreach ($this->update_rules as $item)
         {
             $f = $item['field'];
             $data[$f] = $this->input->post($f);           
	     }             
     }

     // если обновл€етс€ материал
     else
     {
         foreach ($this->update_rules as $item)
         {
             $f = $item['field'];
             
             switch($f)
             {
                 case 'section[]':
                 
                     unset($f);
                     break;  
                     
                 default:
                 
                     $data[$f] = $this->input->post($f);
                     break;
             }
	     }         

         for ($i=0;$i<6;$i++)
         {   
             foreach ($section as $one)
             {   
                 $cname = 'section'.$i;

                 if (isset($section[$i]))
                 {
                     $$cname = $section[$i];
                     $data[$cname] = $$cname; 
                 }

                 else
                 {                  
                     $$cname = '';
                     $data[$cname] = $$cname;                  
                 }               
             }
         } 	     
	 }

     $this->db->where($this->idkey,$obj_id);
	 $this->db->update($this->table,$data);
}



// ”даление записи
public function delete($obj_id)
{
    $this->db->where ($this->idkey,$obj_id);
    $this->db->delete($this->table);
}
    
}
?>