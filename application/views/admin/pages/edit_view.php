<div id="wrapper">
    <div id="content">

<p><strong>Редактировать страницу</strong></p>

<?=get_tinymce();?>

<form action = "<?=base_url()."pages/update/$page_id";?>" method="post">

<p>Название страницы<br/>
<input type="text" name="title" value="<?=set_value('title', $title);?>"/><br/>
<strong><?=form_error('title');?></strong>
</p>

<p>Мета-описание страницы<br/>
<input type="text" name="description" value="<?=set_value('description', $description);?>"/><br/>
<strong><?=form_error('description');?></strong>
</p>

<p>Ключевые слова<br/>
<input type="text" name="keywords" value="<?=set_value('keywords', $keywords);?>"/><br/>
<strong><?=form_error('keywords');?></strong>
</p>

<p>Основное содержание страницы<br/>
<textarea name="main_text" cols="75" rows="20"><?=set_value('main_text', $main_text);?></textarea><br/><a href="javascript:setup();">Использовать TinyMCE</a><br/>
<strong><?=form_error('main_text');?></strong>
</p>

<p><input type = "submit" name = "update_button" value = "Обновить  страницу"/></p>

</form>
           
    </div>
</div>