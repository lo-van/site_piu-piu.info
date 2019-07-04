<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_lib
{

//��������� �� ���������� ��������� ������ � ������� �� ���� � ���������� � ������ ����������
public function do_login($login,$pass)
{
    $CI =& get_instance();//�������� ������ � ������� CodeIgniter

    //���������� ������ �� ���� ������
    $right_login = $CI->config->item('admin_login');
    $right_pass = $CI->config->item('admin_pass');

    //�������� �� ���������� (���� ���������, ���������� ������)
    if (($right_login === $login) && ($right_pass === $pass))
    {
        $ses = array();
        $ses['admin_logined'] = 'yes';//������������� �����
        $ses['admin_hash'] = $this->the_hash();//���. ������ - ���

        $CI->session->set_userdata($ses);//���������� ������
        
        // �������������� �� ������� �������� �������
        redirect ('administration');
    }

    //���� ������ �� �������, �������������� �� ������� login
    else
    {
        redirect ('administration/login');
    }
}



public function the_hash()
{
    $CI =& get_instance();//�������� ������ � ������� CodeIgniter

    //������������ ����: ������+IP+�������������� �����
    $hash = md5($CI->config->item('admin_pass').$_SERVER['REMOTE_ADDR'].'cigniter');

    return $hash;
}



// ������� ������ ������
public function do_logout()
{
    $CI =& get_instance();//�������� ������ � ������� CodeIgniter

    $ses = array();
    $ses['admin_logined'] = '';
    $ses['admin_hash'] = '';

    $CI->session->unset_userdata($ses);//������� ������

    redirect ('administration/login');
}



//������� ��� �������� ����, ��� �� �������� ���� - ���������� �� ���� ������������ � ��������, ������ � ������� ������ ���� ������ �������
public function check_admin()
{
    $CI =& get_instance();//�������� ������ � ������� CodeIgniter

    //���� � ������ admin_logined = yes � ��� � ������ ��������� � ������     ��������������� ����� �������� the_hash
    if (($CI->session->userdata('admin_logined') === 'yes') &&
    ($CI->session->userdata('admin_hash') === $this->the_hash()))
    {
        return TRUE;//������ ���������� ��������, ���� ��� ���������
    }

    else
    {
        redirect ('administration/login');
    }
}

}
?>