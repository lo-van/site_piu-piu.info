<div id="wrapper">
    <div id="content">

<p><strong>������������� ��������</strong></p>

<?php foreach ($materials_list as $item):?>

<p><a href = "<?=base_url()."materials/edit/$item[material_id]";?>"><?="$item[title]";?></a></p>

<?php endforeach;?>

<?=$page_nav;?>

<p><a href="#top">������</a></p>

    </div>
</div>