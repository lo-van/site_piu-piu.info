<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//Проставляет галочки в чекбоксах для тех категорий, к которым относится материал на момент редактирования. Суть в том, что если у нас материал отнесен к категории articles, то он в любом случае имеет категорию section0. Если материал отнесен к категории html, то он может иметь категорию section0 или section1 (если html - единственная категория, либо если материал относится к одновременно к категориям articles и html)). Далее если материал имеет категорию php, то он может иметь категорию section0 или section1 или section2. И так далее...

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