<div id="wrapper">
    <div id="content">

<p><strong>Редактировать страницу</strong></p>

<?php foreach ($pages_list as $item):?>

<p><a href = "<?=base_url()."pages/edit/$item[page_id]";?>"><?="$item[title]";?></a></p>

<?php endforeach;?>
            
    </div>
</div>