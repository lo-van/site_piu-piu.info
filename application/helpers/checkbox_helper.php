<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//����������� ������� � ��������� ��� ��� ���������, � ������� ��������� �������� �� ������ ��������������. ���� � ���, ��� ���� � ��� �������� ������� � ��������� articles, �� �� � ����� ������ ����� ��������� section0. ���� �������� ������� � ��������� html, �� �� ����� ����� ��������� section0 ��� section1 (���� html - ������������ ���������, ���� ���� �������� ��������� � ������������ � ���������� articles � html)). ����� ���� �������� ����� ��������� php, �� �� ����� ����� ��������� section0 ��� section1 ��� section2. � ��� �����...

function populate($material_id,$names,$section_name)
{   
    switch($section_name)
    {    
        case 'news':        
        
        for ($i=0;$i<1;$i++)
        {
            $cname = 'section'.$i;
            
            if ($names[$cname] == 'news')
            {
                echo 'checked';        
            }                    
        }       
        break;
        
        
        case 'obzor':
        
        for ($i=0;$i<2;$i++)
        {
            $cname = 'section'.$i;
            
            if ($names[$cname] == 'obzor')
            {
                echo 'checked';        
            }                    
        }
        break;
        
        
        case 'gbb':
        
        for ($i=0;$i<3;$i++)
        {
            $cname = 'section'.$i;
            
            if ($names[$cname] == 'gbb')
            {
                echo 'checked';        
            }                    
        }
        break;
        
        
        case 'snaryaga':
        
        for ($i=0;$i<4;$i++)
        {
            $cname = 'section'.$i;
            
            if ($names[$cname] == 'snaryaga')
            {
                echo 'checked';        
            }                    
        }
        break;
        
        case 'video':
        
        for ($i=0;$i<5;$i++)
        {
            $cname = 'section'.$i;
            
            if ($names[$cname] == 'video')
            {
                echo 'checked';        
            }                    
        }
        break;  
        
        case 'smex':
        
        for ($i=0;$i<6;$i++)
        {
            $cname = 'section'.$i;
            
            if ($names[$cname] == 'smex')
            {
                echo 'checked';        
            }                    
        }
        break;        
                             
    }     
}
?>