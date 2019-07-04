<div id="wrapper">
    <div id="content">

<p><strong>������������� ��������</strong></p>

<?=get_tinymce();?>

<form action = "<?=base_url()."materials/update/$material_id";?>" method="post">

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

<p>���� � ����-������ ��� ������<br/>
<input type="text" name="small_img_url" value="<?=set_value('small_img_url', $small_img_url);?>"/><br/>
<strong><?=form_error('small_img_url');?></strong>
</p>

<p>������� ��������<br/>
<textarea name="short_text" id="short_text" cols="75" rows="7"><?=set_value('short_text', $short_text);?></textarea><br/><a href="javascript:setup();">������������ TinyMCE</a><br/>
<strong><?=form_error('short_text');?></strong>
</p>

<p>������ �����<br/>
<textarea name="main_text" id="main_text" cols="75" rows="20"><?=set_value('main_text', $main_text);?></textarea><br/><a href="javascript:setup();">������������ TinyMCE</a><br/>
<strong><?=form_error('main_text');?></strong>
</p>

<p>���� ����������<br/>
<input type="text" name="date" value="<?=set_value('date', $date);?>"/><br/>
<strong><?=form_error('date');?></strong>
</p>

<p>����� ���������<br/>
<input type="text" name="author" value="<?=set_value('author', $author);?>"/><br/>
<strong><?=form_error('author');?></strong>
</p>

<p>��������� ���������:<br/>

<input type = "checkbox" name = "section[]" value = "news" <?=populate($material_id,$names,'news'); 
echo set_checkbox('section[]','news');?>/>������� (news)<br/>

<input type = "checkbox" name = "section[]" value = "obzor" <?=populate($material_id,$names,'obzor');
echo set_checkbox('section[]','obzor');?>/>������ (obzor)<br/>

<input type = "checkbox" name = "section[]" value = "gbb" <?=populate($material_id,$names,'gbb');
echo set_checkbox('section[]','gbb');?>/>��� (gbb)<br/>

<input type = "checkbox" name = "section[]" value = "snaryaga" <?=populate($material_id,$names,'snaryaga');
echo set_checkbox('section[]','snaryaga');?>/>���������� (snaryaga)<br/>

<input type = "checkbox" name = "section[]" value = "video" <?=populate($material_id,$names,'video');
echo set_checkbox('section[]','video');?>/>����� (video)<br/>

<input type = "checkbox" name = "section[]" value = "smex" <?=populate($material_id,$names,'smex');
echo set_checkbox('section[]','smex');?>/>���� (smex)<br/>

<strong><?=form_error('section[]');?></strong>

</p>

<p><input type = "submit" name = "update_button" value = "��������  ��������"/></p>

</form>

<p><a href="#top">������</a></p>
           
    </div>
</div>