<div id="wrapper">
    <div id="content">

<p><strong>������������� �����������</strong></p>

<?php foreach ($comments_list as $item):?>

<a style="text-decoration: none;" href = "<?=base_url()."comments/edit/$item[comment_id]";?>"><?="$item[comment_text]";?></a>
<p><a href = "<?=base_url()."materials/$item[material_id]#captcha";?>">�������� �� �����������</a></p>

<div class="grey_line"></div>

<?php endforeach;?>

<?=$page_nav;?>

<p><a href="#top">������</a></p>
            
    </div>
</div>