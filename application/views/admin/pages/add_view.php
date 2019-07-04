<div id="wrapper">
    <div id="content">

<p><strong>Добавить новую страницу</strong></p>

<?=get_tinymce();?>

<form action = "<?=base_url();?>pages/add" method="post">

<p>Идентификатор страницы (Имя, под которым она будет доступна в url)<br/>
<input type="text" name="page_id" value="<?=set_value('page_id');?>"/><br/>
<strong><?=form_error('page_id');?></strong>
</p>

<p>Название страницы<br/>
<input type="text" name="title" value="<?=set_value('title');?>"/><br/>
<strong><?=form_error('title');?></strong>
</p>

<p>Мета-описание страницы<br/>
<input type="text" name="description" value="<?=set_value('description');?>"/><br/>
<strong><?=form_error('description');?></strong>
</p>

<p>Ключевые слова<br/>
<input type="text" name="keywords" value="<?=set_value('keywords');?>"/><br/>
<strong><?=form_error('keywords');?></strong>
</p>

<p>Основное содержание страницы<br/>
<textarea name="main_text" cols="75" rows="20"><?=set_value('main_text');?></textarea><br/><a href="javascript:setup();">Использовать TinyMCE</a><br/>
<strong><?=form_error('main_text');?></strong>
</p>

<p><input type = "submit" name = "add_button" value = "Добавить страницу"/></p>

</form>
            
    </div>
</div>