<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//Подгружает вид tinymce - простой javascript и возвращает его код
function get_tinymce()
{
    $CI =& get_instance();
    $code = $CI->load->view('tinymce','',TRUE);
    return $code;
}

?>