<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_lib
{

//Проверяет на совпадение введенные данные с данными из базы и авторизует в случае совпадения
public function do_login($login,$pass)
{
    $CI =& get_instance();//Получаем доступ к объекту CodeIgniter

    //Правильные данные из базы данных
    $right_login = $CI->config->item('admin_login');
    $right_pass = $CI->config->item('admin_pass');

    //Проверка на совпадение (если совпадают, записываем сессию)
    if (($right_login === $login) && ($right_pass === $pass))
    {
        $ses = array();
        $ses['admin_logined'] = 'yes';//Администратор вошел
        $ses['admin_hash'] = $this->the_hash();//Доп. защита - хэш

        $CI->session->set_userdata($ses);//Записываем сессию
        
        // Перенаправляем на главную страницу админки
        redirect ('administration');
    }

    //Если данные не совпали, перенаправляем на функцию login
    else
    {
        redirect ('administration/login');
    }
}



public function the_hash()
{
    $CI =& get_instance();//Получаем доступ к объекту CodeIgniter

    //Формирование хэша: пароль+IP+дополнительное слово
    $hash = md5($CI->config->item('admin_pass').$_SERVER['REMOTE_ADDR'].'cigniter');

    return $hash;
}



// Очищает данные сессии
public function do_logout()
{
    $CI =& get_instance();//Получаем доступ к объекту CodeIgniter

    $ses = array();
    $ses['admin_logined'] = '';
    $ses['admin_hash'] = '';

    $CI->session->unset_userdata($ses);//Удаляем сессию

    redirect ('administration/login');
}



//Функция для проверки того, был ли совершен вход - проставить во всех контроллерах и функциях, доступ к которым должен быть закрыт паролем
public function check_admin()
{
    $CI =& get_instance();//Получаем доступ к объекту CodeIgniter

    //Если в сессии admin_logined = yes и хэш в сессии совпадает с заново     сгенерированным хэшем функцией the_hash
    if (($CI->session->userdata('admin_logined') === 'yes') &&
    ($CI->session->userdata('admin_hash') === $this->the_hash()))
    {
        return TRUE;//Просто возвращаем значение, если все совпадает
    }

    else
    {
        redirect ('administration/login');
    }
}

}
?>