<div id="wrapper">
    <div id="content">
        <div class="center">
<p><strong>���� � ������ ��������������</strong></p>

<form action = "<?=base_url();?>administration/login" method="post">

<p>�����<br/>
<input type="text" name="login" value="<?=set_value('login');?>"/><br/>
<strong><?=form_error('login');?></strong>
</p>

<p>������<br/>
<input type="password" name="pass"/><br/>
<strong><?=form_error('pass');?></strong>
</p>

<p><input type = "submit" name = "enter_button" value = "�����"/></p>

</form>
    
        </div>           
    </div>
</div>