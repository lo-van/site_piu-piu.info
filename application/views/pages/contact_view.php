<div id="wrapper">
    <div id="content">

<h2><?=$main_info['title'];?></h2>
<?=$main_info['main_text'];?>

<form action = "<?=base_url();?>pages/contact" method="post">

<p>Ваше имя<br/>
<input type="text" name="name" value="<?=set_value('name');?>"/><br/>
<strong><?=form_error('name');?></strong>
</p>

<p>Ваш e-mail<br/>
<input type="text" name="email" value="<?=set_value('email');?>"/><br/>
<strong><?=form_error('email');?></strong>
</p>

<p>Тема сообщения<br/>
<input type="text" name="topic" value="<?=set_value('topic');?>"/><br/>
<strong><?=form_error('topic');?></strong>
</p>

<p>Текст сообщения<br/>
<textarea name="message" cols="50" rows="10"><?=set_value('message');?></textarea><br/>
<strong><?=form_error('message');?></strong>
</p>

<p>Введите цифры с картинки:</p>
<p><?=$imgcode?></p>
<p><input type="text" name="captcha" size="10"/><br/>
<strong><?=form_error('captcha'),$info;?></strong>
</p>

<p><input type = "submit" name = "send_message" value = "Отправить письмо"/></p>

</form>
           
    </div>
</div>