<div id="wrapper">
    <div id="content">

<p><strong>Редактирование настроек</strong></p>

<form action = "<?=base_url();?>administration/preferences" method="post">

<p>Задать логин:<br/>
<input type="text" name="admin_login" value="<?=set_value('admin_login', $this->config->item('admin_login'));?>" size="20"/><br/>
<strong><?=form_error('admin_login');?></strong>
</p>

<p>Задать пароль:<br/>
<input type="password" name="admin_pass" value="<?=set_value('admin_pass', $this->config->item('admin_pass'));?>" size="20"/><br/>
<strong><?=form_error('admin_pass');?></strong>
</p>

<p>Материалов на страницу в пользовательской части:<br/>
<input type="text" name="user_per_page" value="<?=set_value('user_per_page', $this->config->item('user_per_page'));?>" size="4"/><br/>
<strong><?=form_error('user_per_page');?></strong>
</p>

<p>Материалов на страницу в администраторской части:<br/>
<input type="text" name="admin_per_page" value="<?=set_value('admin_per_page', $this->config->item('admin_per_page'));?>" size="4"/><br/>
<strong><?=form_error('admin_per_page');?></strong>
</p>

<p>Результатов поиска на страницу:<br/>
<input type="text" name="search_per_page" value="<?=set_value('search_per_page', $this->config->item('search_per_page'));?>" size="4"/><br/>
<strong><?=form_error('search_per_page');?></strong>
</p>

<p><input type = "submit" name = "save_button" value = "Сохранить настройки"/></p>

</form>
            
    </div>
</div>