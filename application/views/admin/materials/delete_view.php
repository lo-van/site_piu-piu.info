<div id="wrapper">
    <div id="content">

<p><strong>������� ��������</strong></p>

<form action = "<?=base_url();?>materials/delete" method="post">  

<?php foreach ($materials_list as $item): ?>

<p><?="<input name='material_id' type='radio' value='$item[material_id]'>$item[title]";?></p>

<?php endforeach;?>

<p><input type = "submit" name = "delete_button" value = "������� ��������"/></p>

</form>

<?=$page_nav;?>

<p><a href="#top">������</a></p>
            
    </div>
</div>
