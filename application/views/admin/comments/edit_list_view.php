<div id="wrapper">
    <div id="content">

<p><strong>Редактировать комментарий</strong></p>

<?php foreach ($comments_list as $item):?>

<a style="text-decoration: none;" href = "<?=base_url()."comments/edit/$item[comment_id]";?>"><?="$item[comment_text]";?></a>
<p><a href = "<?=base_url()."materials/$item[material_id]#captcha";?>">Ответить на комментарий</a></p>

<div class="grey_line"></div>

<?php endforeach;?>

<?=$page_nav;?>

<p><a href="#top">Наверх</a></p>
            
    </div>
</div>