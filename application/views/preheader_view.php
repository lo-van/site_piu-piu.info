<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<title><?=$main_info['title'];?></title>

<meta http-equiv="content-type" content="text/html; charset=windows-1251"/>
<link rel="shortcut icon" href="/img/ico.png" />
<meta name="robots" content="index, follow" /> 
<meta name="description" content="<?=$main_info['description'];?>"/>
<meta name="keywords" content="<?=$main_info['keywords'];?>"/>

<link href="<?=base_url();?>styles/style.css" rel="stylesheet" type="text/css"/>

<?=smiley_js();?>

<!-- ВКОНТАКТЕ Мне Нравится Put this script tag to the <head> of your page -->
<script type="text/javascript" src="http://userapi.com/js/api/openapi.js?34"></script>
<script type="text/javascript">
  VK.init({apiId: 2433675, onlyWidgets: true});
</script> 

<!-- ГУГЛ +1 Разместите этот тег в теге head или непосредственно перед закрывающим тегом body -->
<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
  {lang: 'ru'}
</script>

<script type="text/javascript">var switchTo5x=false;</script><script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script><script type="text/javascript">stLight.options({publisher:'099879bf-d92d-4250-b827-6bcddc4a7e18'});</script>
<meta name='yandex-verification' content='691d8b1e10d3abe2' />
<meta name="alexaVerifyID" content="U3NSJ6UqyKqQlNMO4Yroz35aGAQ" />

<?php 
    global $sape;
    if (!defined('_SAPE_USER')){
        define('_SAPE_USER', 'ab661507a23d87f98c9f6845e783c431'); 
    }
    require_once($_SERVER['DOCUMENT_ROOT'].'/'._SAPE_USER.'/sape.php'); 
    $sape = new SAPE_client();
?>
<!-- ГУГЛ Аналитикс -->
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-25164553-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
</head>

<body> 
<a name="top"></a>
<div id="container">