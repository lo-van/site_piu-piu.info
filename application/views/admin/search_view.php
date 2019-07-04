<div id="wrapper">
    <div id="content">

<p><strong>По запросу "<?=$this->session->userdata('search_query')?>" найдено:</strong></p> 

<?php
for ($i = $msearch_results['start_from']; $i < $msearch_results['start_from'] + $msearch_results['limit']; $i++)
{
    if (isset($msearch_results[$i][0]))
    {    
        $msearch_results[$i][1] = highlight_phrase($msearch_results[$i][1], $this->session->userdata('search_query'),'<span style="background:#FFFF66">','</span>');
        $msearch_results[$i][2] = highlight_phrase($msearch_results[$i][2], $this->session->userdata('search_query'),'<span style="background:#FFFF66">','</span>');
       
        print <<<HERE
        <table>
        <tr> 
          
        <td align = "center">
        <p><a href = "http://www.piu-piu.info/materials/{$msearch_results[$i][0]}"><img class="small_img" src="{$msearch_results[$i][3]}" width="45" height="45"/></a></p>
        </td>
        
        <td align = "center">
        <p class = "anons_title"><a href = "http://www.piu-piu.info/materials/{$msearch_results[$i][0]}">{$msearch_results[$i][1]}</a></p>
        <p class = "anons_text">Добавил: {$msearch_results[$i][4]}<br>
        Просмотров материала: {$msearch_results[$i][5]}</p>
        </td>
        
        </tr>
        </table>
       
        <p>{$msearch_results[$i][2]}</p>
        <div class="grey_line"></div>
        <div class="grey_line"></div>
HERE;
    }
}

echo $page_nav;
?>

<p><a href="#top">Наверх</a></p>

    </div>
</div>