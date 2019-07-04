<div id="wrapper">
    <div id="content">
        <div class="center">
<p><strong>Вход в панель администратора</strong></p>

<form action = "<?=base_url();?>administration/login" method="post">

<p>Логин<br/>
<input type="text" name="login" value="<?=set_value('login');?>"/><br/>
<strong><?=form_error('login');?></strong>
</p>

<p>Пароль<br/>
<input type="password" name="pass"/><br/>
<strong><?=form_error('pass');?></strong>
</p>

<p><input type = "submit" name = "enter_button" value = "Войти"/></p>

</form>
    
        </div>           
    </div>
</div>