<div id="wrapper">
    <div id="content">

<p><strong>������������� �����������</strong></p>

<?=get_tinymce();?>

<form action = "<?=base_url()."comments/update/$comment_id";?>" method="post">

<p>�����<br/>
<input type="text" name="author" value="<?=set_value('author', $author);?>"/><br/>
<strong><?=form_error('author');?></strong>
</p>

<p>����� �����������<br/>
<textarea name="comment_text" id="comment_text" cols="75" rows="8"><?=set_value('comment_text', $comment_text);?></textarea><br><a href="javascript:setup();">������������ TinyMCE</a><br/>
<strong><?=form_error('comment_text');?></strong>
</p>

<p><input type = "submit" name = "update_button" value = "�������� �����������"/></p>

</form>
           
    </div>
</div>