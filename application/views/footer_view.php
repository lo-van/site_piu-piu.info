<div id = "footer">

<table>
<tr>
<td>
<a href="<?=base_url();?>">Главная</a>&nbsp;&nbsp;
<a href="<?=base_url();?>sections/news">Новости</a>&nbsp;&nbsp;
<a href="<?=base_url();?>sections/obzor">Обзоры</a>&nbsp;&nbsp;
<a href="<?=base_url();?>sections/gbb">ГББ</a>&nbsp;&nbsp;
<a href="<?=base_url();?>sections/snaryaga">Снаряжение</a>&nbsp;&nbsp;
<a href="<?=base_url();?>sections/video">Видео</a>&nbsp;&nbsp;
<a href="<?=base_url();?>sections/smex">Юмор</a>&nbsp;&nbsp;
<a href="<?=base_url();?>pages/contact">Связь</a>
</td>
</tr>

<tr>
<td>
&#8853; Piu-piu.info &copy; 2011 &#8853; 
</br>
</td></tr>
</table>
<tr><td><center><?php 
    global $sape; 
    echo $sape->return_links();
?></center></td></tr></div>

</div>

</body>
</html>