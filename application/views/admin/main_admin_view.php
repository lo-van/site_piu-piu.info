<div id="wrapper">
    <div id="content">

<h2>������� ��������</h2>

<p><strong>����� �� �����:</strong></p>

<div class="comment">
<p>����������: <?=$materials_count;?>, ������������: <?=$comments_count;?>, ���������: <?=$sections_count;?>, �������: <?=$pages_count;?></p>
</div>
<p><strong>����� ���������� ���������:</strong></p>

<div class="comment">
<?php foreach ($popular_materials as $item):?>

<p><a href = "<?=base_url()."materials/$item[material_id]";?>"><?=$item['title'];?></a> (<?=$item['count_views'];?> ���������(��))</p>

<?php endforeach;?>
</div>

<p><strong>������ �����������:</strong></p>

<?php foreach ($latest_comments as $item):?>

<div class="comment">
<p class = "comment">����: <?=$item['date'];?><br/>
<strong><?=$item['author'];?></strong>:</p>
<p><?=$item['comment_text'];?></p>
<p><a href = "<?=base_url()."materials/$item[material_id]#captcha";?>">�������� �� �����������</a></p>
</div>

<?php endforeach;?>


<p><a href="#top">������</a></p>

    </div>
</div>