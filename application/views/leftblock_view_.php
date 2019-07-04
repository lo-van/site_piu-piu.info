<div id="leftblock">
<table>

<tr>
<td class="tdview">
<h2 class = "sidebartitle">Что новенького?</h2>
</td>
</tr>

<tr>
<td>
<?foreach ($latest_materials as $item):?>

<p><a href = "<?=base_url()."materials/$item[material_id]";?>"><?=$item['title'];?></a></p>

<?php endforeach;?>
</td>
</tr>

<tr>
<td class="tdview">
<h2 class = "sidebartitle">Новостная лента</h2>
</td>
</tr>


<tr>
<td>
<p style="text-align: center;"></p>
</td>
</tr>

<tr>
<td>
<center><a href="<?=base_url();?>rss/"><img alt="RSS-лента" src="<?=base_url();?>img/441.gif"/></a></center>
<p style="text-align: center;"><a href="<?=base_url();?>rss/">Подписаться!</a></p>
</td>
</tr>

<tr>
<td class="tdview">
<h2 class = "sidebartitle">Рассказать друзьям</h2>
</td>
</tr>

<tr>
<td>
<!-- Кнопка +1 Гугл -->
<p><center><g:plusone></g:plusone></center></p>
<!-- Кнопка Мне Нравится -->
<p><center><div id="vk_like"></div>
<script type="text/javascript">
VK.Widgets.Like("vk_like", {type: "mini"});
</script></center><p>
<!-- Кнопка Фейсбука -->
<p><iframe src="http://www.facebook.com/plugins/like.php?app_id=216582165056791&amp;href=http%3A%2F%2Fwww.piu-piu.info&amp;send=false&amp;layout=button_count&amp;width=130&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:130px; height:21px;" allowTransparency="true"></iframe></p>

<p><script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
<div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir,lj"></div></p>
</td>
</tr>


<tr>
<td class="tdview">
<h2 class = "sidebartitle">Немного рекламы</h2>
</td>
</tr>

<tr>
<td>
<p style="text-align: center;"></p>
</td>
</tr>

<tr>
<td>

<center><p>
<?php 
    global $sape; 
    echo $sape->return_links(5);
?>
</p></center>

</td>
</tr>


</table>
</div>