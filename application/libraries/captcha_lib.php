<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Captcha_lib
{    

public function captcha_actions()
{
    $CI =& get_instance ();          
        
    //Загружаем плагин Капча
    $CI->load->helper('captcha');
        
    //Загружаем хэлпер для генерирования случайной строки
    $CI->load->helper('string');		
    $rnd_str = random_string('numeric',5);
            			
    //Записываем строку в сессию
    $ses_data = array();
    $ses_data['rnd_captcha'] = $rnd_str;
    $CI->session->set_userdata($ses_data);
            			
    //Параметры картинки
    $settings = array('word'	   => $rnd_str,
     				  'img_path'   => './img/captcha/',
       				  'img_url'	   => base_url().'img/captcha/',
       				  'font_path'  => './system/fonts/cour.ttf',
      				  'img_width'  => 120,
      				  'img_height' => 30,
       				  'expiration' => 10);

    //Создаем капчу
    $captcha = create_captcha($settings);
                     
    //Получаем в переменную код картинки 
    $imgcode = $captcha['image'];   
    return $imgcode;          
}
   
}
?>