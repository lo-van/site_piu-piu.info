<div id="wrapper">
    <div id="content">

<p><strong>�������� ����� ��������</strong></p>

<?=get_tinymce();?>

<form action = "<?=base_url();?>materials/add" method="post">

<p>�������� ���������<br/>
<input type="text" name="title" value="<?=set_value('title');?>"/><br/>
<strong><?=form_error('title');?></strong>
</p>

<p>����-�������� ���������<br/>
<input type="text" name="description" value="<?=set_value('description');?>"/><br/>
<strong><?=form_error('description');?></strong>
</p>

<p>�������� �����<br/>
<input type="text" name="keywords" value="<?=set_value('keywords');?>"/><br/>
<strong><?=form_error('keywords');?></strong>
</p>

<p>���� � ����-������ ��� ������<br/>
<input type="text" name="small_img_url" value="<?=set_value('small_img_url');?>"/><br/>
<strong><?=form_error('small_img_url');?></strong>
</p>

<p>������� ��������<br/>
<textarea name="short_text" cols="75" rows="7"><?=set_value('short_text');?></textarea><br/><a href="javascript:setup();">������������ TinyMCE</a><br/>
<strong><?=form_error('short_text');?></strong>
</p>

<p>������ �����<br/>
<textarea name="main_text" cols="75" rows="20"><?=set_value('main_text');?></textarea><br/><a href="javascript:setup();">������������ TinyMCE</a><br/>
<strong><?=form_error('main_text');?></strong>
</p>

<p>���� ����������<br/>
<input type="text" name="date" value = "<? $date = date ("Y-m-d"); echo $date;?>"/><br/>
<strong><?=form_error('date');?></strong>
</p>

<p>����� ���������<br/>
<input type="text" name="author" value="<?=set_value('author');?>"/><br/>
<strong><?=form_error('author');?></strong>
</p>

<p>��������� ���������<br/>
<input type = "checkbox" name = "section[]" value = "news" <?=set_checkbox('section[]','news')?>/>�������<br/>
<input type = "checkbox" name = "section[]" value = "obzor" <?=set_checkbox('section[]','obzor')?>/>������<br/>
<input type = "checkbox" name = "section[]" value = "gbb" <?=set_checkbox('section[]','gbb')?>/>���<br/>
<input type = "checkbox" name = "section[]" value = "snaryaga" <?=set_checkbox('section[]','snaryaga')?>/>����������<br/>
<input type = "checkbox" name = "section[]" value = "video" <?=set_checkbox('section[]','video')?>/>�����<br/>
<input type = "checkbox" name = "section[]" value = "smex" <?=set_checkbox('section[]','video')?>/>����<br/>

<strong><?=form_error('section[]');?></strong>
</p>

<p><input type = "submit" name = "add_button" value = "��������  ��������"/></p>

</form>

<p><a href="#top">������</a></p>
            
    </div>
</div>