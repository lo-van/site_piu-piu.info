<div id="wrapper">
    <div id="content">

<p><strong>������� ��������</strong></p>

<form action = "<?=base_url();?>pages/delete" method="post">  

<?php foreach ($pages_list as $item): ?>

<p><?="<input name='page_id' type='radio' value='$item[page_id]'>$item[title]";?></p>

<?php endforeach;?>

<p><input type = "submit" name = "delete_button" value = "������� ��������"/></p>

</form>
            
    </div>
</div>

