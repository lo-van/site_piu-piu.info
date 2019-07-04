<div id="wrapper">
    <div id="content">

<p><strong>Удалить категорию</strong></p>

<form action = "<?=base_url();?>sections/delete" method="post">  

<?php foreach ($sections_list as $item): ?>

<p><?="<input name='section_id' type='radio' value='$item[section_id]'>$item[title]";?></p>

<?php endforeach;?>

<p><input type = "submit" name = "delete_button" value = "Удалить категорию"/></p>

</form>
            
    </div>
</div>

