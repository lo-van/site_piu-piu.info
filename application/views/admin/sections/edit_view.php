<div id="wrapper">
    <div id="content">
    
<p><strong>������������� ���������</strong></p>

<?=get_tinymce();?>

<form action = "<?=base_url()."sections/update/$section_id";?>" method="post">

<p>�������� ���������<br/>
<input type="text" name="title" value="<?=set_value('title', $title);?>"/><br/>
<strong><?=form_error('title');?></strong>
</p>

<p>����-�������� ���������<br/>
<input type="text" name="description" value="<?=set_value('description', $description);?>"/><br/>
<strong><?=form_error('description');?></strong>
</p>

<p>�������� �����<br/>
<input type="text" name="keywords" value="<?=set_value('keywords', $keywords);?>"/><br/>
<strong><?=form_error('keywords');?></strong>
</p>

<p>������� �������� ���������<br/>
<textarea id="about_text" name="main_text" cols="75" rows="7"><?=set_value('main_text',$main_text);?></textarea><br/><a href="javascript:setup();">������������ TinyMCE</a><br/>
<strong><?=form_error('main_text');?></strong>
</p>

<p><input type = "submit" name = "update_button" value = "��������  ���������"/></p>

</form>
           
    </div>
</div>