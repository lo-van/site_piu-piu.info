<div id="wrapper">
    <div id="content">

<p><strong>������������� ���������</strong></p>

<?php foreach ($sections_list as $item):?>

<p><a href = "<?=base_url()."sections/edit/$item[section_id]";?>"><?="$item[title]";?></a></p>

<?php endforeach;?>
            
    </div>
</div>