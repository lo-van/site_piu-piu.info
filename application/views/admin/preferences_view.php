<div id="wrapper">
    <div id="content">

<p><strong>�������������� ��������</strong></p>

<form action = "<?=base_url();?>administration/preferences" method="post">

<p>������ �����:<br/>
<input type="text" name="admin_login" value="<?=set_value('admin_login', $this->config->item('admin_login'));?>" size="20"/><br/>
<strong><?=form_error('admin_login');?></strong>
</p>

<p>������ ������:<br/>
<input type="password" name="admin_pass" value="<?=set_value('admin_pass', $this->config->item('admin_pass'));?>" size="20"/><br/>
<strong><?=form_error('admin_pass');?></strong>
</p>

<p>���������� �� �������� � ���������������� �����:<br/>
<input type="text" name="user_per_page" value="<?=set_value('user_per_page', $this->config->item('user_per_page'));?>" size="4"/><br/>
<strong><?=form_error('user_per_page');?></strong>
</p>

<p>���������� �� �������� � ����������������� �����:<br/>
<input type="text" name="admin_per_page" value="<?=set_value('admin_per_page', $this->config->item('admin_per_page'));?>" size="4"/><br/>
<strong><?=form_error('admin_per_page');?></strong>
</p>

<p>����������� ������ �� ��������:<br/>
<input type="text" name="search_per_page" value="<?=set_value('search_per_page', $this->config->item('search_per_page'));?>" size="4"/><br/>
<strong><?=form_error('search_per_page');?></strong>
</p>

<p><input type = "submit" name = "save_button" value = "��������� ���������"/></p>

</form>
            
    </div>
</div>