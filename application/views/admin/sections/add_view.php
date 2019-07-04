<div id="wrapper">
    <div id="content">

<p><strong>Добавить новую категорию</strong></p>

<?=get_tinymce();?>

<form action = "<?=base_url();?>sections/add" method="post">

<p>Введите идентификатор категории (Имя, под которым она будет доступна в url)<br/>
<input type="text" name="section_id" value = "<?=set_value('section_id');?>"/><br/>
<strong><?=form_error('section_id');?></strong>
</p>

<p>Название категории<br/>
<input type="text" name="title" value = "<?=set_value('title');?>"/><br/>
<strong><?=form_error('title');?></strong>
</p>

<p>Мета-описание категории<br/>
<input type="text" name="description" value = "<?=set_value('description');?>"/><br/>
<strong><?=form_error('description');?></strong>
</p>

<p>Ключевые слова<br/>
<input type="text" name="keywords" value = "<?=set_value('keywords');?>"/><br/>
<strong><?=form_error('keywords');?></strong>
</p>

<p>Краткое описание категории<br/>
<textarea id = "main_text" name="main_text" cols="75" rows="7"><?=set_value('main_text');?></textarea><br/><a href="javascript:setup();">Использовать TinyMCE</a><br/>
<strong><?=form_error('main_text');?></strong>
</p>

<p><input type = "submit" name = "add_button" value = "Добавить категорию"/></p>

</form>
            
    </div>
</div>