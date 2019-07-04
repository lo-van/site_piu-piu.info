<div id="wrapper">
    <div id="content">

<h2>Главная страница</h2>

<p><strong>Всего на сайте:</strong></p>

<div class="comment">
<p>Материалов: <?=$materials_count;?>, Комментариев: <?=$comments_count;?>, Категорий: <?=$sections_count;?>, Страниц: <?=$pages_count;?></p>
</div>
<p><strong>Самые популярные материалы:</strong></p>

<div class="comment">
<?php foreach ($popular_materials as $item):?>

<p><a href = "<?=base_url()."materials/$item[material_id]";?>"><?=$item['title'];?></a> (<?=$item['count_views'];?> просмотра(ов))</p>

<?php endforeach;?>
</div>

<p><strong>Свежие комментарии:</strong></p>

<?php foreach ($latest_comments as $item):?>

<div class="comment">
<p class = "comment">Дата: <?=$item['date'];?><br/>
<strong><?=$item['author'];?></strong>:</p>
<p><?=$item['comment_text'];?></p>
<p><a href = "<?=base_url()."materials/$item[material_id]#captcha";?>">Ответить на комментарий</a></p>
</div>

<?php endforeach;?>


<p><a href="#top">Наверх</a></p>

    </div>
</div>