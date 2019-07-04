<div id="rightblock">
<table>

<tr>
<td class="tdview">
<h2 class = "sidebartitle">Пиу-пиу, Поиск!</h2>
</td>
</tr>
<tr>
<td>

<form action = "<?=base_url();?>search" method="post">
<p><input type="text" name="search" id ="search" maxlength="50" value="<?=set_value('search');?>"/></p>
<p><?=form_error('search');?></p>
<p><input type = "submit" name = "search_button" id="search_button" value = "Искать"/></p>
</form>

</td>
</tr>

<tr>
<td class="tdview">
<h2 class = "sidebartitle">Читаемое</h2>
</td>
</tr>
<tr>
<td>
<?php foreach ($popular_materials as $item):?>

<p><a href = "<?=base_url()."materials/$item[material_id]";?>"><?=$item['title'];?></a></p>

<?php endforeach;?>
</td>
</tr>


<tr>
<td class="tdview">
<h2 class = "sidebartitle">Архив всего</h2>
</td>
</tr>
<tr>
<td>

<?php foreach ($archive_list as $one):?>
<?php foreach ($one as $month):?>
<p><a href="<?=base_url()."archive/".$month;?>"><?=$month?></a></p>
<?php endforeach; ?>
<?php endforeach; ?>

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
<td class="tdview">
<h2 class = "sidebartitle">Присутствие</h2>
</td>
</tr>
<tr>
<td>
</br><object align="right">
<!--bigmir)net TOP 100-->
<script type="text/javascript" language="javascript"><!--
function BM_Draw(oBM_STAT){
document.write('<table cellpadding="0" cellspacing="0" border="0" style="display:inline;margin-right:4px;"><tr><td><div style="font-family:Tahoma;font-size:10px;padding:0px;margin:0px;"><div style="width:7px;float:left;background:url(\'http://i.bigmir.net/cnt/samples/default/b55_left.gif\');height:17px;padding-top:2px;background-repeat:no-repeat;"></div><div style="float:left;background:url(\'http://i.bigmir.net/cnt/samples/default/b55_center.gif\');text-align:left;height:17px;padding-top:2px;background-repeat:repeat-x;"><a href="http://www.bigmir.net/" target="_blank" style="color:#0000ab;text-decoration:none;">bigmir<span style="color:#ff0000;">)</span>net</a>  <span style="color:#f7ae6c;">хиты</span> <span style="color:#e2762d;font:10px Tahoma;">'+oBM_STAT.hits+'</span> <span style="color:#f7ae6c;">хосты</span> <span style="color:#e2762d;font:10px Tahoma;">'+oBM_STAT.hosts+'</span></div><div style="width:7px;float: left;background:url(\'http://i.bigmir.net/cnt/samples/default/b55_right.gif\');height:17px;padding-top:2px;background-repeat:no-repeat;"></div></div></td></tr></table>');
}
//-->
</script>
<script type="text/javascript" language="javascript"><!--
bmN=navigator,bmD=document,bmD.cookie='b=b',i=0,bs=[],bm={o:1,v:16890113,s:16890113,t:0,c:bmD.cookie?1:0,n:Math.round((Math.random()* 1000000)),w:0};
for(var f=self;f!=f.parent;f=f.parent)bm.w++;
try{if(bmN.plugins&&bmN.mimeTypes.length&&(x=bmN.plugins['Shockwave Flash']))bm.m=parseInt(x.description.replace(/([a-zA-Z]|\s)+/,''));
else for(var f=3;f<20;f++)if(eval('new ActiveXObject("ShockwaveFlash.ShockwaveFlash.'+f+'")'))bm.m=f}catch(e){;}
try{bm.y=bmN.javaEnabled()?1:0}catch(e){;}
try{bmS=screen;bm.v^=bm.d=bmS.colorDepth||bmS.pixelDepth;bm.v^=bm.r=bmS.width}catch(e){;}
r=bmD.referrer.slice(7);if(r&&r.split('/')[0]!=window.location.host){bm.f=escape(r);bm.v^=r.length}
bm.v^=window.location.href.length;for(var x in bm) if(/^[ovstcnwmydrf]$/.test(x)) bs[i++]=x+bm[x];
bmD.write('<sc'+'ript type="text/javascript" language="javascript" src="http://c.bigmir.net/?'+bs.join('&')+'"></sc'+'ript>');
//-->
</script>
<noscript>
<a href="http://www.bigmir.net/" target="_blank"><img src="http://c.bigmir.net/?v16890113&s16890113&t2" width="88" height="31" alt="bigmir)net TOP 100" title="bigmir)net TOP 100" border="0" /></a>
</noscript>
<!--bigmir)net TOP 100-->
</br>
<!-- TOP.zp.ua Counter -->
<a href=http://www.top.zp.ua target=_blank><img src=http://www.top.zp.ua/counter/count.php?id=14586&counter=11 border=0 alt='TOP.zp.ua' width=85 height=30></a><!-- End TOP.zp.ua Counter -->
</br>
<!--LiveInternet counter--><script type="text/javascript">document.write("<a href='http://www.liveinternet.ru/click' target=_blank><img src='//counter.yadro.ru/hit?t25.17;r" + escape(document.referrer) + ((typeof(screen)=="undefined")?"":";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?screen.colorDepth:screen.pixelDepth)) + ";u" + escape(document.URL) + ";" + Math.random() + "' border=0 width=88 height=15 alt='' title='LiveInternet: показано число посетителей за сегодня'><\/a>")</script><!--/LiveInternet-->
</br>
<!--Rating@Mail.ru counter--><a target="_top" href="http://top.mail.ru/jump?from=2054047"><img src="http://d7.c5.bf.a1.top.mail.ru/counter?id=2054047;t=90" border="0" height="18" width="88" alt="Рейтинг@Mail.ru"/></a><!--// Rating@Mail.ru counter-->
</br>
<!-- I.UA counter --><a href="http://www.i.ua/" target="_blank" onclick="this.href='http://i.ua/r.php?120871';" title="Rated by I.UA">
<script type="text/javascript" language="javascript"><!--
iS='<img src="http://r.i.ua/s?u120871&p266&n'+Math.random();
iD=document;if(!iD.cookie)iD.cookie="b=b; path=/";if(iD.cookie)iS+='&c1';
iS+='&d'+(screen.colorDepth?screen.colorDepth:screen.pixelDepth)
+"&w"+screen.width+'&h'+screen.height;
iT=iD.referrer.slice(7);iH=window.location.href.slice(7);
((iI=iT.indexOf('/'))!=-1)?(iT=iT.substring(0,iI)):(iI=iT.length);
if(iT!=iH.substring(0,iI))iS+='&f'+escape(iD.referrer.slice(7));
iS+='&r'+escape(iH);
iD.write(iS+'" border="0" width="88" height="15" />');
//--></script></a><!-- End of I.UA counter -->
</br>
<a href="http://www.airsoftinfo.ru/rating/"><img id="airsoftinfo" border="0" width="88" height="31" title="Рейтинг страйкбольных сайтов." /></a> 
<script type="text/javascript" src="http://www.airsoftinfo.ru/rating/ai.js"></script>
</br>
</object>
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