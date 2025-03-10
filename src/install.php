<?php
/*
=====================================================
 DataLife Engine - by SoftNews Media Group
-----------------------------------------------------
 http://dle-news.ru/
-----------------------------------------------------
 Copyright (c) 2004-2021 SoftNews Media Group
=====================================================
 This code is protected by copyright
=====================================================
 File: install.php
-----------------------------------------------------
 Use: Script installation
=====================================================
*/
session_start();

error_reporting(E_ALL ^ E_WARNING ^ E_DEPRECATED ^ E_NOTICE);
ini_set('error_reporting', E_ALL ^ E_WARNING ^ E_DEPRECATED ^ E_NOTICE);

define('DATALIFEENGINE', true);
define('ROOT_DIR', dirname (__FILE__));
define('ENGINE_DIR', ROOT_DIR.'/engine');

header("Content-type: text/html; charset=utf-8");

require_once(ROOT_DIR.'/language/Russian/adminpanel.lng');

$_REQUEST['action'] = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

$url = explode( basename($_SERVER['PHP_SELF']), $_SERVER['PHP_SELF'] );
$url = reset($url);

if( isSSL() ) $url  = "https://".$_SERVER['HTTP_HOST'].$url;
else $url  = "http://".$_SERVER['HTTP_HOST'].$url;

$skin_header = <<<HTML
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>DataLife Engine - Установка</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="HandheldFriendly" content="true">
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width"> 
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link href="engine/skins/fonts/fontawesome/styles.min.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="engine/skins/stylesheets/application.css" media="screen" rel="stylesheet" type="text/css" />
    <script src="engine/skins/javascripts/application.js"></script>
</head>
<body class="no-theme">
<script>
<!--
var dle_act_lang   = [];
var cal_language   = {en:{months:[],dayOfWeek:[]}};
var filedefaulttext= '';
var filebtntext    = '';
//-->
</script>
<div class="navbar navbar-inverse bg-primary-700">
	<div class="navbar-header">
		<a class="navbar-brand" href="#">Мастер установки DataLife Engine</a>
	</div>
</div>
<div class="page-container">
	<div class="page-content">
		<div class="col-md-8 col-md-offset-2 mt-20">
<!--MAIN area-->

HTML;


$skin_footer = <<<HTML
	 <!--MAIN area-->
    </div>
  </div>
</div>
</body>
</html>
HTML;

function msgbox($type, $title, $text, $back=false){
global $lang, $skin_header, $skin_footer;

  if ($back) $back = "onclick=\"history.go(-1); return false;\""; else $back = "";

  echo $skin_header;

echo <<<HTML
<form action="install.php" method="get">
<div class="panel panel-default">
  <div class="panel-heading">
	{$title}
  </div>
  <div class="panel-body">
		{$text}
  </div>
  <div class="panel-footer">
	<button type="submit" {$back} class="btn bg-teal btn-sm btn-raised position-left"><i class="fa fa-arrow-circle-o-right position-left"></i>Продолжить</button>
  </div>
</div>
</form>
HTML;

  echo $skin_footer;

  exit();
}

function GetRandInt($max){

	if(function_exists('openssl_random_pseudo_bytes')) {
	     do{
	         $result = (int)floor($max*(hexdec(bin2hex(openssl_random_pseudo_bytes(4)))/0xffffffff));
	     }while($result == $max);
	} else {

		$result = mt_rand( 0, $max );
	}

    return $result;
}

function generate_auth_key() {

    $arr = array('a','b','c','d','e','f',
                 'g','h','i','j','k','l',
                 'm','n','o','p','r','s',
                 't','u','v','x','y','z',
                 'A','B','C','D','E','F',
                 'G','H','I','J','K','L',
                 'M','N','O','P','R','S',
                 'T','U','V','X','Y','Z',
                 '1','2','3','4','5','6',
                 '7','8','9','0','.',',',
                 '(',')','[',']','!','?',
                 '&','^','%','@','*',' ',
                 '<','>','/','|','+','-',
                 '{','}','`','~','#',';',
                 '/','|','=',':','`');

    $key = "";
    for($i = 0; $i < 64; $i++)
    {
      $index = GetRandInt(count($arr)-1);
      $key .= $arr[$index];
    }
    return $key;
}

function isSSL() {
    if( (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off')
        || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
        || (!empty($_SERVER['HTTP_X_FORWARDED_SSL']) && strtolower($_SERVER['HTTP_X_FORWARDED_SSL']) == 'on')
        || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
        || (isset($_SERVER['HTTP_X_FORWARDED_PORT']) && $_SERVER['HTTP_X_FORWARDED_PORT'] == 443)
        || (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https')
		|| (isset($_SERVER['CF_VISITOR']) && $_SERVER['CF_VISITOR'] == '{"scheme":"https"}')
		|| (isset($_SERVER['HTTP_CF_VISITOR']) && $_SERVER['HTTP_CF_VISITOR'] == '{"scheme":"https"}')
    ) return true; else return false;
}

function listdir($dir) {
	
	$current_dir = @opendir( $dir );
	
	if($current_dir !== false ) {
		while ( $entryname = readdir( $current_dir ) ) {
			if( is_dir( $dir."/".$entryname ) AND ($entryname != "." AND $entryname != "..") ) {
				listdir( $dir."/".$entryname );
			} elseif( $entryname != "." AND $entryname != ".." ) {
				@unlink( $dir."/".$entryname );
			}
		}
		@closedir( $current_dir );
		@rmdir( $dir );
	}

}

if($_REQUEST['action'] == "eula") {

  if ( !$_SESSION['dle_install'] ) msgbox( "", "Ошибка", "Установка скрипта была начата не с начала. Вернитесь на главную страницу начала установки скрипта: <br><br><a href=\"http://{$_SERVER['HTTP_HOST']}/install.php\">http://{$_SERVER['HTTP_HOST']}/install.php</a>" );

  echo $skin_header;

echo <<<HTML
<form id="check-eula" method="get" action="">
<input type=hidden name=action value="function_check">
<script language='javascript'>
function check_eula(){

	if( document.getElementById( 'eula' ).checked == true )
	{
		return true;
	}
	else
	{
		DLEalert( 'Вы должны принять лицензионное соглашение, прежде чем продолжите установку.', 'Информация' );
		return false;
	}
};
document.getElementById( 'check-eula' ).onsubmit = check_eula;
</script>
<div class="panel panel-default">
  <div class="panel-heading">
    Лицензионное соглашение
  </div>
  <div class="panel-body">
		Пожалуйста, внимательно прочитайте и примите пользовательское соглашение по использованию DataLife Engine.<br><br><div style="height: 300px; border: 1px solid #76774C; background-color: #FDFDD3; padding: 5px; overflow: auto;"><div style="text-align:center;"><b>Пользовательское лицензионное соглашение на использование программы для ЭВМ "DataLife Engine"</b></div><br><br><!--colorstart:#FF0000--><span style="color:#FF0000"><!--/colorstart-->Уважаемый Пользователь! Перед началом установки, копирования либо иного использования Программы внимательно ознакомьтесь с условиями ее использования, содержащимися в настоящем Соглашении. Установка, запуск или иное начало использования Программы означает надлежащее заключение настоящего Соглашения и Ваше полное согласие со всеми его условиями. Если Вы не согласны безоговорочно принять условия настоящего Соглашения, Вы не имеете права устанавливать и использовать Программу и должны удалить все ее компоненты со своего компьютера (ЭВМ).<!--colorend--></span><!--/colorend--><br><br>Настоящее лицензионное соглашение (далее – Соглашение) заключается между ООО «СофтНьюс Медиа Групп» (далее – Правообладатель) и любым физическим лицом, индивидуальным предпринимателем, юридическим лицом (далее – Пользователь).<br><br><div style="text-align:center;"><b>1. Основные термины</b></div><br><b>1.1. </b><b>Программа</b> – программа для ЭВМ "DataLife Engine", соответствующей версии (как в целом, так и ее компоненты), являющаяся представленной в объективной форме совокупностью данных и команд, в том числе, исходного текста, базы данных, аудиовизуальных произведений, включенных Правообладателем в состав указанной программы для ЭВМ, а также любая документация по её использованию.<br><br><b>1.2. Использование программы</b> - любые действия, связанные с функционированием Программы в соответствии с ее назначением (в том числе запись в память ЭВМ).<br><br><b>1.3. Техническая поддержка</b> – мероприятия, осуществляемые Правообладателем в установленных им пределах и объемах для обеспечения функционирования Программы, включая информационно-консультационную поддержку Пользователей по вопросам использования Программы.<br><br><b>1.4. Пользователь</b> - физическое или юридическое лицо, или индивидуальный предприниматель, приобретающий лицензию на право использования DataLife Engine по данному лицензионному соглашению.<br><br><div style="text-align:center;"><b>2. Предмет лицензионного соглашения</b></div><br><b>2.1. </b>Предметом настоящего лицензионного соглашения является право использования одной лицензионной копии программы для ЭВМ "DataLife Engine", в порядке и на условиях, установленных настоящим соглашением. Если вы не согласны с условиями данного соглашения, вы не можете использовать данный продукт. Установка и использование продукта означает ваше полное согласие со всеми пунктами настоящего соглашения.<br><br><b>2.2. </b>Все положения настоящего Соглашение распространяется как на Программу в целом, так и на её отдельные компоненты, за исключением случаев, когда для компонента системы применяется другой тип лицензии.<br><br><b>2.3. </b>Настоящее Соглашение заключается до или непосредственно в момент начала использования Программы и действует на протяжении всего срока ее правомерного использования Пользователем в пределах срока действия авторского права на нее при условии надлежащего соблюдения Пользователем условий настоящего Соглашения.<br><br><div style="text-align:center;"><b>3. Содержание договора</b></div><br><b>3.1. </b>Срок обслуживания клиента с момента приобретения одной лицензионной копии Программы "DataLife Engine" равен одному году. Если по истечении срока обслуживания, Вы решите не продлевать его действие, то Ваша Программа будет функционировать в полном объеме, но без нашей технической поддержки и без предоставления новых версий Программы, за исключением критических обновлений Программы.<br><br><b>3.2. </b>Правообладатель осуществляет Техническую поддержку Пользователя, в том числе по вопросам, связанным с функциональностью, особенностями установки и эксплуатации на стандартных конфигурациях поддерживаемых (популярных) операционных, почтовых и иных систем Программы в порядке и на условиях, указанных в технической документации к ней.<br><br><b>3.3. </b>В случае приобретения и использования только базовой лицензии на Программу, обслуживание клиентов, на время действия лицензионного соглашения, ограничивается только предоставлением стандартных услуг по обслуживанию: предоставление дистрибутивов, новых версий Программы, критических обновлений Программы. Технической поддержки по базовым лицензиям не предоставляется. Для получения технической поддержки по Программе, пользователям необходимо иметь лицензию, включающую в себя службу технической поддержки, либо быть подписчиком на службу технической поддержки.<br><br><b>3.4. </b>В случае приобретения Пользователем Программы для передачи непосредственным заказчикам уже готового сайта или проекта, Пользователь обязан уведомить заказчика о настоящем лицензионном соглашении, а также полностью передать ему свой клиентский доступ на сайте dle-news.ru, в противном случае, Пользователем лицензии остается лицо непосредственно оплатившее лицензию, и имеющие клиентский доступ на сайте dle-news.ru. Третьим лицам, не имеющим данного доступа, в поддержке и предоставлению дистрибутивов будет отказано.<br><br><b>3.5. </b>Мы оставляем за собой право публиковать, с согласия пользователя программного продукта, списки избранных сайтов, на которых используется Программа "DataLife Engine". Мы оставляем за собой право в любое время изменять условия данного договора, но данные изменения не имеют обратной силы. Изменения данного договора будут разосланы пользователям по электронной почте на адреса, указанные при приобретении лицензии на Программу.<br><br><div style="text-align:center;"><b>4. Ограничения использования Программы</b></div><br><b>4.1. </b>Программа является результатом интеллектуальной деятельности и объектом авторских прав (программа для ЭВМ), которые регулируются и защищены законодательством Российской Федерации об интеллектуальной собственности и нормами международного права.<br><br><b>4.2. </b>Название "DataLife Engine", а также входящие в данную Программу скрипты являются собственностью Правообладателя, использование которых возможно только в рамках данного соглашения, за исключением случаев, когда для компонента системы применяется другой тип лицензии. Любые публикуемые оригинальные материалы, создаваемые в результате использования нашей Программы, и связанные с этим права на них, являются собственностью пользователя и защищены законом. Правообладатель не несет никакой ответственности за содержание сайтов, создаваемых пользователем Программы "DataLife Engine".<br><br><b>4.3. </b>Алгоритм работы Программы и ее исходные коды (в том числе их части) являются собственностью Правообладателя. Любое их использование или использование Программы в нарушение условий настоящего Соглашения рассматривается как нарушение прав Правообладателя и является достаточным основанием для лишения Пользователя предоставленных по настоящему Соглашению прав.<br><br><b>4.4. </b>Правообладатель гарантирует, что обладает всеми необходимыми по настоящему Соглашению правами для предоставления их Пользователю, включая документацию к Программе.<br><br><b>4.5. </b>Приобретая лицензию на Программу "DataLife Engine", вы должны знать, что не приобретаете авторские права на Программу. Вы приобретаете только право на использование Программы на единственном веб-сайте (одном домене второго уровня и его поддоменах), принадлежащем Вам или Вашему клиенту. Для использования Программы на другом сайте, вам необходимо приобретать повторную лицензию.<br><br><b>4.6. </b>Запрещается перепродажа Программы третьим лицам.<br><br><b>4.7. </b>Настоящим соглашением Пользователю не предоставляются никакие права на использование товарных знаков и знаков обслуживания Правообладателя.<br><br><b>4.8. </b>Пользователь не может ни при каких условиях удалять или изменять вид информации и сведения об авторских правах, правах на товарные знаки или патенты, указанные в исходном коде Программы.<br><br><div style="text-align:center;"><b>5. Права и обязанности сторон</b></div><br><b>5.1. Пользователь имеет право:</b><br><br><div style="margin-left:20px;"><b>5.1.1 </b>Изменять дизайн и структуру программного кода в соответствии с нуждами своего сайта.</div><br><div style="margin-left:20px;"><b>5.1.2 </b>Производить и распространять инструкции по созданным собственным модификациям скрипта, шаблонов и языковых файлов, если в них будет иметься указание на оригинального разработчика программного продукта до Ваших модификаций. Модификации, произведенные Вами самостоятельно, не являются собственностью Правообладателя, если не содержат программные коды непосредственно Программы.</div><br><div style="margin-left:20px;"><b>5.1.3 </b>Создавать дополнительные собственные модули для Программы, которые будут взаимодействовать с программными кодами Программы, с указанием на то, что это оригинальный продукт Пользователя.</div><br><div style="margin-left:20px;"><b>5.1.4 </b>Переносить Программу на другой сайт после обязательного уведомления об этом Правообладателя, а также полного удаления Программы с предыдущего сайта.</div><br><div><b>5.2. Пользователь не имеет право:</b></div><br><div style="margin-left:20px;"><b>5.2.1 </b>Передавать права на использование Программы третьим лицам.</div><br><div style="margin-left:20px;"><b>5.2.2 </b>Использовать или изменять структуру программных кодов, функции программы, с целью создания родственных продуктов.</div><br><div style="margin-left:20px;"><b>5.2.3 </b>Создавать отдельные самостоятельные продукты, базирующиеся на нашем программном коде.</div><br><div style="margin-left:20px;"><b>5.2.4 </b>Использовать копии Программы "DataLife Engine" по одной лицензии на более чем одном сайте (одном домене второго уровня и его поддоменах).</div><br><div style="margin-left:20px;"><b>5.2.5 </b>Рекламировать, продавать или публиковать на своем сайте пиратские копии Программы.</div><br><div style="margin-left:20px;"><b>5.2.6 </b>Использовать, распространять нелицензионные копии Программы "DataLife Engine" или содействовать распространению нелицензионных копий Программы "DataLife Engine".</div><br><div style="margin-left:20px;"><b>5.2.7 </b>Модифицировать или удалять механизмы проверки наличия оригинальной лицензии на использование Программы.</div><br><div style="margin-left:20px;"><b>5.2.8</b> Модифицировать или удалять копирайты исходного кода Программы.</div><br><div style="text-align:center;"><b>6. Ограничение гарантийных обязательств</b></div><br><b>6.1. </b>Механизмы безопасности, установленные на "DataLife Engine", могут иметь известные ограничения, и несмотря на то, что мы прилагаем максимальные усилия по обеспечению безопасности Программы, вы должны быть ознакомлены с отсутствием абсолютных гарантий от взлома вашего сайта. Так же наши гарантии и техническая поддержка не распространяются на модификации, произведенные третьей стороной, включая изменения программного кода, стиля, языковых пакетов, а также на изменения перечисленных частей, внесенные владельцем лицензии самостоятельно. Если Программа изменена Вами или третьей стороной, то мы вправе отказать Вам в технической поддержке.<br><br><b>6.2. </b>Программа "DataLife Engine" не подлежит возврату или обмену из-за отсутствия гарантий защищающих Программу от копирования.<br><br><div style="text-align:center;"><b>7. Досрочное расторжение договорных обязательств</b></div><br><b>7.1. </b>Данное соглашение расторгается автоматически, если Вы отказываетесь выполнять условия нашего соглашения. Данное лицензионное соглашение может быть расторгнуто нами в одностороннем порядке, в случае установления фактов нарушения данного лицензионного соглашения. В случае досрочного расторжения соглашения Вы обязуетесь удалить все Ваши копии нашей Программы в течении 3 рабочих дней, с момента получения соответствующего уведомления.<br><br><div style="text-align:center;"><b>8. Контактная информация Правообладателя</b></div><br><b>ООО “СофтНьюс Медиа Групп”<br>660093, г. Красноярск, ул. Капитанская, дом 12, офис 43<br>ИНН/КПП 2464251745/246401001<br>e-mail: support@dle-news.ru</b></div>
		<div class="checkbox"><label><input type="checkbox" name="eula" id="eula" class="icheck">Я принимаю данное соглашение</label></div>
  </div>
  <div class="panel-footer">
	<button type="submit" class="btn bg-teal btn-sm btn-raised position-left"><i class="fa fa-arrow-circle-o-right position-left"></i>Продолжить</button>
  </div>
</div>
</form>
HTML;

} elseif($_REQUEST['action'] == "function_check") {

    if ( !$_SESSION['dle_install'] ) msgbox( "", "Ошибка", "Установка скрипта была начата не с начала. Вернитесь на главную страницу начала установки скрипта: <br><br><a href=\"http://{$_SERVER['HTTP_HOST']}/install.php\">http://{$_SERVER['HTTP_HOST']}/install.php</a>" );

  echo $skin_header;

echo <<<HTML
<form method="get" action="">
<input type=hidden name="action" value="chmod_check">
<div class="panel panel-default">
  <div class="panel-heading">
    Проверка установленных компонентов PHP
  </div>
  <div class="table-responsive">
<table class="table table-striped table-xs">
<thead>
<th width="300">Минимальные требования скрипта</th>
<th colspan="2">Текущее значение</th>
</thead>
HTML;

	$errors=false;

	if( version_compare(phpversion(), '5.4', '<') ) {
		$status = '<span class="text-danger"><b>Нет</b></span>';
		$errors=true;
	} else {
		$status = '<span class="text-success"><b>Да</b></span>';
  }
	
   echo "<tr>
         <td>Версия PHP 5.4 и выше</td>
         <td colspan=2>$status</td>
         </tr>";

	if( function_exists('mysqli_connect') ) {
	  $status = '<span class="text-success"><b>Да</b></span>';
	} else {
	  $status = '<span class="text-danger"><b>Нет</b></span>';
	  $errors=true;
	}

   echo "<tr>
         <td>Поддержка MySQLi</td>
         <td colspan=2>$status</td>
         </tr>";

	if( function_exists('gzopen') ) {
	  $status = '<span class="text-success"><b>Да</b></span>';
	} else {
	  $status = '<span class="text-danger"><b>Нет</b></span>';
	  $errors=true;
	}

   echo "<tr>
         <td>Поддержка сжатия ZLib</td>
         <td colspan=2>$status</td>
         </tr>";

	if( function_exists('mb_convert_encoding') ) {
	  $status = '<span class="text-success"><b>Да</b></span>';
	} else {
	  $status = '<span class="text-danger"><b>Нет</b></span>';
	  $errors=true;
	}

   echo "<tr>
         <td>Поддержка многобайтных строк</td>
         <td colspan=2>$status</td>
         </tr>";

	if($errors) {
	 $button= "<button onclick=\"location.reload(true); return false;\" class=\"btn bg-danger btn-sm btn-raised position-left\"><i class=\"fa fa-refresh position-left\"></i>Проверить еще раз</button>";
	} else {
	 $button = "<button type=\"submit\" class=\"btn bg-teal btn-sm btn-raised position-left\"><i class=\"fa fa-arrow-circle-o-right position-left\"></i>Продолжить</button>";
	}

echo <<<HTML
</table>
  <div class="panel-body">
	Если любой из этих пунктов выделен красным, то пожалуйста выполните действия для исправления этого. Вам необходимо установить недостающие компоненты на сервер. Для этого обратитесь в службу поддержки вашего хостинга.
  </div>
  <div class="panel-footer">
	{$button}
  </div>

  </div>
</div></form>
HTML;

}
// ********************************************************************************
// Проверка прав на запись
// ********************************************************************************
elseif($_REQUEST['action'] == "chmod_check") {

if ( !$_SESSION['dle_install'] ) msgbox( "", "Ошибка", "Установка скрипта была начата не с начала. Вернитесь на главную страницу начала установки скрипта: <br><br><a href=\"http://{$_SERVER['HTTP_HOST']}/install.php\">http://{$_SERVER['HTTP_HOST']}/install.php</a>" );

  echo $skin_header;

echo <<<HTML
<form method="get" action="">
<input type=hidden name="action" value="doconfig">
<div class="panel panel-default">
  <div class="panel-heading">
    Проверка на запись у важных файлов системы
  </div>
  <div class="table-responsive">
<table class="table table-striped table-xs">
HTML;

echo"<thead><tr>
<th>Папка/Файл</th>
<th width=\"100\">CHMOD</th>
<th width=\"100\">Статус</th></tr></thead><tbody>";

$important_files = array(
'./backup/',
'./engine/data/',
'./engine/cache/',
'./engine/cache/system/',
'./uploads/',
'./uploads/files/',
'./uploads/fotos/',
'./uploads/posts/',
'./uploads/posts/thumbs/',
'./uploads/posts/medium/',
'./uploads/thumbs/',
'./templates/',
'./templates/Default/',
);


$chmod_errors = 0;
$not_found_errors = 0;
    foreach($important_files as $file){

        if(!file_exists($file)){
            $file_status = "<span class=\"text-danger\">не найден!</span>";
            $not_found_errors ++;
        }
        elseif(is_writable($file)){
            $file_status = "<span class=\"text-success\">разрешено</span>";
        }
        else{
            @chmod($file, 0777);
            if(is_writable($file)){
                $file_status = "<span class=\"text-success\">разрешено</span>";
            }else{
                @chmod("$file", 0755);
                if(is_writable($file)){
                    $file_status = "<span class=\"text-success\">разрешено</span>";
                }else{
                    $file_status = "<span class=\"text-danger\">запрещено</span>";
                    $chmod_errors ++;
                }
            }
        }
        $chmod_value = @decoct(@fileperms($file)) % 1000;

    echo"<tr>
         <td>$file</td>
         <td>$chmod_value</td>
         <td>$file_status</td>
         </tr>";
    }
    
if($chmod_errors == 0 and $not_found_errors == 0){

    $status_report = 'Проверка успешно завершена! Можете продолжить установку!';

} else {
    
    if($chmod_errors > 0){
        $status_report = "<span class=\"text-danger\">Внимание!!!</span><br><br>Во время проверки обнаружены ошибки: <b>$chmod_errors</b>. Запрещена запись в файл.<br>Вы должны выставить для папок CHMOD 777, для файлов CHMOD 666, используя FTP клиент.<br><br><span class=\"text-danger\"><b>Настоятельно не рекомендуется</b></span> продолжать установку, пока не будут произведены изменения.<br>";
    }

    if($not_found_errors > 0){
        $status_report .= "<span class=\"text-danger\">Внимание!!!</span><br>Во время проверки обнаружены ошибки: <b>$not_found_errors</b>. Файлы не найдены!<br><br><span class=\"text-danger\"><b>Не рекомендуется</b></span> продолжать установку, пока не будут произведены изменения.<br>";
    }
}

echo <<<HTML
</tbody></table>
  </div>
  <div class="panel-body">
	{$status_report}
  </div>
  <div class="panel-footer">
	<button type="submit" class="btn bg-teal btn-sm btn-raised position-left"><i class="fa fa-arrow-circle-o-right position-left"></i>Продолжить</button>
  </div>
</div></form>
HTML;

} elseif($_REQUEST['action'] == "doconfig") {

  if ( !$_SESSION['dle_install'] ) msgbox( "", "Ошибка", "Установка скрипта была начата не с начала. Вернитесь на главную страницу начала установки скрипта: <br><br><a href=\"http://{$_SERVER['HTTP_HOST']}/install.php\">http://{$_SERVER['HTTP_HOST']}/install.php</a>" );

  echo $skin_header;

  echo <<<HTML
<form method="post" action="">
<input type=hidden name="action" value="doinstall">
<div class="panel panel-default">
  <div class="panel-heading">
    Настройка конфигурации системы
  </div>
  <div class="panel-body">
<table width="100%">
HTML;

echo '<tr>
<tr><td colspan="2" style="padding: 5px;"><b>Данные для доступа к MySQL серверу</b><td></tr>
<tr><td style="padding: 5px;" width="175">Сервер MySQL:</td><td style="padding: 5px;"><input type="text" class="classic" style="width:220px;" name="dbhost" value="localhost"></tr>
<tr><td style="padding: 5px;">Имя базы данных:</td><td style="padding: 5px;"><input type="text" class="classic" style="width:220px;"" name="dbname"></tr>
<tr><td style="padding: 5px;">Имя пользователя:</td><td style="padding: 5px;"><input type="text" class="classic" style="width:220px;" name="dbuser"></tr>
<tr><td style="padding: 5px;">Пароль:</td><td style="padding: 5px;"><input type="text" class="classic" style="width:220px;" name="dbpasswd"></tr>
<tr><td style="padding: 5px;">Префикс:</td><td style="padding: 5px;"><input type="text" class="classic" style="width:220px;" name="dbprefix" value="dle"> <span class="text-size-small text-muted">Не изменяйте параметр, если не знаете для чего он предназначен</span></tr>
<tr><td colspan="2" style="padding: 5px;"><b>Данные для доступа с которыми вы будете входить в админпанель скрипта</b><td></tr>
<tr><td style="padding: 5px;">Имя администратора:</td><td style="padding: 5px;"><input type="text" class="classic" style="width:220px;" name="reg_username" ></tr>
<tr><td style="padding: 5px;">Пароль:</td><td style="padding: 5px;"><input type="password" class="classic" style="width:220px;" name="reg_password1"></tr>
<tr><td style="padding: 5px;">Повторите пароль:</td><td style="padding: 5px;"><input type="password" class="classic" style="width:220px;" name="reg_password2"></tr>
<tr><td style="padding: 5px;">E-mail:</td><td style="padding: 5px;"><input type="text" class="classic" style="width:220px;" name="reg_email"></tr>';

echo <<<HTML
</table>
  </div>
  <div class="panel-footer">
	<button type="submit" class="btn bg-teal btn-sm btn-raised position-left"><i class="fa fa-arrow-circle-o-right position-left"></i>Продолжить</button>
  </div>
</div></form>
HTML;

}
// ********************************************************************************
// Do Install
// ********************************************************************************
elseif($_REQUEST['action'] == "doinstall")
{

	if ( !$_SESSION['dle_install'] ) msgbox( "", "Ошибка", "Установка скрипта была начата не с начала. Вернитесь на главную страницу начала установки скрипта: <br><br><a href=\"http://{$_SERVER['HTTP_HOST']}/install.php\">http://{$_SERVER['HTTP_HOST']}/install.php</a>" );
		
	if( !$_POST['reg_username'] OR !$_POST['reg_email'] OR !$_POST['reg_password1'] OR $_POST['reg_password1'] != $_POST['reg_password2'] ){ msgbox("error", "Ошибка!!!" ,"Заполните необходимые поля!", "history.go(-1)"); }
	
	if (preg_match("/[\||\'|\<|\>|\[|\]|\"|\!|\?|\$|\@|\#|\/|\\\|\&\~\*\{\+]/", $_POST['reg_username']))
	{
		msgbox("error", "Ошибка!!!" ,"Введенное имя администратора недопустимо к регистрации!", "history.go(-1)");
	}
	
	$reg_password = password_hash($_POST['reg_password1'], PASSWORD_DEFAULT);
	
	if( !$reg_password ) {
		msgbox("error", "Ошибка", "PHP extension Crypt must be loaded for password_hash to function", "history.go(-1)");
	}

	$reg_username = $_POST['reg_username'];

	$not_allow_symbol = array ("\x22", "\x60", "\t", '\n', '\r', "\n", "\r", '\\', ",", "/", "¬", "#", ";", ":", "~", "[", "]", "{", "}", ")", "(", "*", "^", "%", "$", "<", ">", "?", "!", '"', "'", " ", "&" );
	$reg_email = trim( str_replace( $not_allow_symbol, '', strip_tags( stripslashes( $_POST['reg_email'] ) ) ) );

	$timezone = date_default_timezone_get();
	
	$timezones = array('Pacific/Midway','US/Samoa','US/Hawaii','US/Alaska','US/Pacific','America/Tijuana','US/Arizona','US/Mountain','America/Chihuahua','America/Mazatlan','America/Mexico_City','America/Monterrey','US/Central','US/Eastern','US/East-Indiana','America/Lima','America/Caracas','Canada/Atlantic','America/La_Paz','America/Santiago','Canada/Newfoundland','America/Buenos_Aires','America/Godthab','Atlantic/Stanley','Atlantic/Azores','Africa/Casablanca','Europe/Dublin','Europe/Lisbon','Europe/London','Europe/Amsterdam','Europe/Belgrade','Europe/Berlin','Europe/Bratislava','Europe/Brussels','Europe/Budapest','Europe/Copenhagen','Europe/Madrid','Europe/Paris','Europe/Prague','Europe/Rome','Europe/Sarajevo','Europe/Stockholm','Europe/Vienna','Europe/Warsaw','Europe/Zagreb','Europe/Athens','Europe/Bucharest','Europe/Helsinki','Europe/Istanbul','Asia/Jerusalem','Europe/Kiev','Europe/Minsk','Europe/Riga','Europe/Sofia','Europe/Tallinn','Europe/Vilnius','Asia/Baghdad','Asia/Kuwait','Africa/Nairobi','Asia/Tehran','Europe/Kaliningrad','Europe/Moscow','Europe/Volgograd','Europe/Samara','Asia/Baku','Asia/Muscat','Asia/Tbilisi','Asia/Yerevan','Asia/Kabul','Asia/Yekaterinburg','Asia/Tashkent','Asia/Kolkata','Asia/Kathmandu','Asia/Almaty','Asia/Novosibirsk','Asia/Jakarta','Asia/Krasnoyarsk','Asia/Hong_Kong','Asia/Kuala_Lumpur','Asia/Singapore','Asia/Taipei','Asia/Ulaanbaatar','Asia/Urumqi','Asia/Irkutsk','Asia/Seoul','Asia/Tokyo','Australia/Adelaide','Australia/Darwin','Asia/Yakutsk','Australia/Brisbane','Pacific/Port_Moresby','Australia/Sydney','Asia/Vladivostok','Asia/Sakhalin','Asia/Magadan','Pacific/Auckland','Pacific/Fiji');

	if ( !in_array($timezone, $timezones) ) {
		$timezone = "Europe/Moscow";
		date_default_timezone_set ( $timezone );
	}
	
	$dbhost = str_replace ('"', '\"', str_replace ("$", "\\$", $_POST['dbhost']) );
	$dbname = str_replace ('"', '\"', str_replace ("$", "\\$", $_POST['dbname']) );
	$dbuser = str_replace ('"', '\"', str_replace ("$", "\\$", $_POST['dbuser']) );
	$dbpasswd = str_replace ('"', '\"', str_replace ("$", "\\$", $_POST['dbpasswd']) );
	$dbprefix = str_replace ('"', '\"', str_replace ("$", "\\$", $_POST['dbprefix']) );
	
	$auth_key = generate_auth_key();
	
	define ("PREFIX", $dbprefix);
	define ("COLLATE", "utf8mb4");

	include ENGINE_DIR.'/classes/mysql.php';
	
	$check_db = new db;
	
	if ( !$check_db->connect($_POST['dbuser'], $_POST['dbpasswd'], $_POST['dbname'], $_POST['dbhost'], false) ) {
		msgbox("error", "Ошибка!!!" ,"Невозможно соединиться с MySQL сервером по указанным доступам. Введите корректные данные доступа для соединения с БД MySQL. У вас возникла ошибка:<br><br>".$check_db->query_errors_list[0]['error'], "history.go(-1)");
	}
	
	if( version_compare($check_db->mysql_version, '5.5.3', '<') ) {
		msgbox("error", "Ошибка!!!" ,"На вашем сервере установления версия MySQL <b>{version}</b>, для установки скрипта DataLife Engine необходима версия MySQL не ниже 5.5.3", "history.go(-1)");
	}
	
	if( version_compare($check_db->mysql_version, '5.6.4', '<') ) {
		$storage_engine = "MyISAM";
	} else $storage_engine = "InnoDB";


	unset($check_db);
	
$config = <<<HTML
<?PHP

//System Configurations

\$config = array (

'version_id' => "14.2",

'home_title' => "DataLife Engine",

'http_home_url' => "{$url}",

'charset' => "utf-8",

'admin_mail' => "{$reg_email}",

'description' => "Демонстрационная страница движка DataLife Engine",

'keywords' => "DataLife, Engine, CMS, PHP движок",

'date_adjust' => "{$timezone}",

'site_offline' => "0",

'allow_alt_url' => "1",

'langs' => "Russian",

'skin' => "Default",

'allow_gzip' => "0",

'allow_admin_wysiwyg' => "1",

'allow_static_wysiwyg' => "1",

'news_number' => "10",

'smilies' => "bowtie,smile,laughing,blush,smiley,relaxed,smirk,heart_eyes,kissing_heart,kissing_closed_eyes,flushed,relieved,satisfied,grin,wink,stuck_out_tongue_winking_eye,stuck_out_tongue_closed_eyes,grinning,kissing,stuck_out_tongue,sleeping,worried,frowning,anguished,open_mouth,grimacing,confused,hushed,expressionless,unamused,sweat_smile,sweat,disappointed_relieved,weary,pensive,disappointed,confounded,fearful,cold_sweat,persevere,cry,sob,joy,astonished,scream,tired_face,angry,rage,triumph,sleepy,yum,mask,sunglasses,dizzy_face,imp,smiling_imp,neutral_face,no_mouth,innocent",

'timestamp_active' => "j-m-Y, H:i",

'news_sort' => "date",

'news_msort' => "DESC",

'hide_full_link' => "0",

'allow_site_wysiwyg' => "1",

'allow_comments' => "1",

'comm_nummers' => "30",

'comm_msort' => "ASC",

'flood_time' => "30",

'auto_wrap' => "80",

'timestamp_comment' => "j F Y H:i",

'allow_comments_wysiwyg' => "1",

'allow_registration' => "1",

'allow_cache' => "0",

'allow_votes' => "1",

'allow_topnews' => "1",

'allow_read_count' => "1",

'allow_calendar' => "1",

'allow_archives' => "1",

'files_allow' => "1",

'files_count' => "1",

'reg_group' => "4",

'registration_type' => "0",

'allow_sec_code' => "1",

'allow_skin_change' => "1",

'max_users' => "0",

'max_users_day' => "0",

'max_up_size' => "200",

'max_image_days' => "2",

'allow_watermark' => "1",

'max_watermark' => "150",

'max_image' => "200",

'jpeg_quality' => "85",

'files_antileech' => "1",

'allow_banner' => "1",

'log_hash' => "0",

'show_sub_cats' => "1",

'tag_img_width' => "0",

'mail_metod' => "php",

'smtp_host' => "localhost",

'smtp_port' => "25",

'smtp_user' => "",

'smtp_pass' => "",

'mail_bcc' => "0",

'speedbar' => "1",

'extra_login' => "0",

'image_align' => "center",

'ip_control' => "1",

'cache_count' => "0",

'related_news' => "1",

'no_date' => "1",

'mail_news' => "1",

'mail_comments' => "1",

'admin_path' => "admin.php",

'rss_informer' => "1",

'allow_cmod' => "0",

'max_up_side' => "0",

'files_force' => "1",

'short_rating' => "1",

'full_search' => "0",

'allow_multi_category' => "1",

'short_title' => "Демонстрационный сайт",

'allow_rss' => "1",

'rss_mtype' => "0",

'rss_number' => "10",

'rss_format' => "1",

'comments_maxlen' => "3000",

'offline_reason' => "Сайт находится на текущей реконструкции, после завершения всех работ сайт будет открыт.<br><br>Приносим вам свои извинения за доставленные неудобства.",

'catalog_sort' => "date",

'catalog_msort' => "DESC",

'related_number' => "5",

'seo_type' => "2",

'max_moderation' => "0",

'allow_quick_wysiwyg' => "1",

'sec_addnews' => "2",

'mail_pm' => "1",

'allow_change_sort' => "1",

'registration_rules' => "1",

'allow_tags' => "1",

'allow_add_tags' => "1",

'allow_fixed' => "1",

'max_file_count' => "0",

'allow_smartphone' => "0",

'allow_smart_images' => "0",

'allow_smart_video' => "0",

'allow_search_print' => "1",

'allow_search_link' => "1",

'allow_smart_format' => "1",

'thumb_dimming' => "0",

'thumb_gallery' => "1",

'max_comments_days' => "0",

'allow_combine' => "1",

'allow_subscribe' => "1",

'parse_links' => "0",

't_seite' => "0",

'comments_minlen' => "10",

'js_min' => "0",

'outlinetype' => "0",

'fast_search' => "1",

'login_log' => "5",

'allow_recaptcha' => "0",

'recaptcha_public_key' => "",

'recaptcha_private_key' => "",

'search_number' => "10",

'news_navigation' => "1",

'smtp_mail' => "",

'seo_control' => "0",

'news_restricted' => "0",

'comments_restricted' => "0",

'auth_metod' => "0",

'comments_ajax' => "0",

'create_catalog' => "0",

'mobile_news' => "10",

'reg_question' => "0",

'news_future' => "0",

'cache_type' => "0",

'memcache_server' => "localhost:11211",

'allow_comments_cache' => "1",

'reg_multi_ip' => "1",

'top_number' => "10",

'tags_number' => "40",

'mail_title' => "",

'o_seite' => "0",

'online_status' => "1",

'avatar_size' => "100",

'allow_share' => "1",

'auth_domain' => "0",

'start_site' => "1",

'clear_cache' => "0",

'allow_complaint_mail' => "0",

'spam_api_key' => "",

'create_metatags' => '1',

'admin_allowed_ip' => '',

'related_only_cats' => '0',

'allow_links' => '1',

'comments_lazyload' => '0',

'category_separator' => ' / ',

'speedbar_separator' => ' &raquo; ',

'adminlog_maxdays' => '30',

'allow_social' => '0',

'medium_image' => '450',

'login_ban_timeout' => '20',

'watermark_seite' => '4',

'auth_only_social' => '0',

'rating_type' => '0',

'allow_comments_rating' => '1',

'comments_rating_type' => '1',

'tree_comments' => '0',

'tree_comments_level' => '5',

'simple_reply' => '0',

'recaptcha_theme' => "light",

'smtp_secure' => '',

'search_pages' => '5',

'profile_news' => '1',

'fullcache_days' => '30',

'twofactor_auth' => '1',

'category_newscount' => '1',

'max_cache_pages' => '10',

'only_ssl' => '0',

'bbimages_in_wysiwyg' => '0',

'allow_redirects' => '1',

'allow_own_meta' => '1',

'own_404' => '0',

'own_ip' => '',

'disable_frame' => '0',

'allow_plugins' => '1',

'allow_admin_social' => '0',

'image_lazy' => '0',

'search_length_min' => '4',

'min_up_side' => '10x10',

'jquery_version' => '0',

'allow_yandex_dzen' => '1',

'allow_yandex_turbo' => '1',

'emoji' => '1',

'last_viewed' => '0',

'image_tinypng' => '0',

'tinypng_key' => '',

'tinypng_avatar' => '0',

'tinypng_resize' => '0',

'tags_separator' => ', ',

'session_timeout' => '0',

'decline_date' => '0',

'redis_user' => '',

'redis_pass' => '',

'news_noreferrer' => '0',

'comm_noreferrer' => '1',

'user_in_news' => '0',

'key' => '',

);

?>
HTML;


$dbconfig = <<<HTML
<?PHP

define ("DBHOST", "{$dbhost}");

define ("DBNAME", "{$dbname}");

define ("DBUSER", "{$dbuser}");

define ("DBPASS", "{$dbpasswd}");

define ("PREFIX", "{$dbprefix}");

define ("USERPREFIX", "{$dbprefix}");

define ("COLLATE", "utf8mb4");

define('SECURE_AUTH_KEY', '{$auth_key}');

\$db = new db;

?>
HTML;


$video_config = <<<HTML
<?PHP

//Videoplayers Configurations

\$video_config = array (

'width' => "600",

'audio_width' => "600",

'preload' => '1',

'theme' => 'light',

);

?>
HTML;


$social_config = <<<HTML
<?PHP

//Social Configurations

\$social_config = array (

'vk' => '0',

'vkid' => '',

'vksecret' => '',

'od' => '0',

'odid' => '',

'odpublic' => '',

'odsecret' => '',

'fc' => '0',

'fcid' => '',

'fcsecret' => '',

'google' => '0',

'googleid' => '',

'googlesecret' => '',

'mailru' => '0',

'mailruid' => '',

'mailrusecret' => '',

'yandex' => '0',

'yandexid' => '',

'yandexsecret' => '',

);

?>
HTML;

$con_file = fopen("engine/data/config.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/config.php</b>.<br>Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $config);
fclose($con_file);
@chmod("engine/data/config.php", 0666);

$con_file = fopen("engine/data/dbconfig.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/dbconfig.php</b>.<br>Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $dbconfig);
fclose($con_file);
@chmod("engine/data/dbconfig.php", 0666);

$con_file = fopen("engine/data/videoconfig.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/videoconfig.php</b>.<br>Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $video_config);
fclose($con_file);
@chmod("engine/data/videoconfig.php", 0666);

$con_file = fopen("engine/data/socialconfig.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/socialconfig.php</b>.<br>Проверьте правильность проставленного CHMOD!");
fwrite($con_file, $social_config);
fclose($con_file);
@chmod("engine/data/socialconfig.php", 0666);

$con_file = fopen("engine/data/wordfilter.db.php", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/wordfilter.db.php</b>.<br>Проверьте правильность проставленного CHMOD!");
fwrite($con_file, '');
fclose($con_file);
@chmod("engine/data/wordfilter.db.php", 0666);

$con_file = fopen("engine/data/xfields.txt", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/xfields.txt</b>.<br>Проверьте правильность проставленного CHMOD!");
fwrite($con_file, '');
fclose($con_file);
@chmod("engine/data/xfields.txt", 0666);

$con_file = fopen("engine/data/xprofile.txt", "w+") or die("Извините, но невозможно создать файл <b>.engine/data/xprofile.txt</b>.<br>Проверьте правильность проставленного CHMOD!");
fwrite($con_file, '');
fclose($con_file);
@chmod("engine/data/xprofile.txt", 0666);

@unlink(ENGINE_DIR.'/cache/system/usergroup.php');
@unlink(ENGINE_DIR.'/cache/system/vote.php');
@unlink(ENGINE_DIR.'/cache/system/banners.php');
@unlink(ENGINE_DIR.'/cache/system/category.php');
@unlink(ENGINE_DIR.'/cache/system/banned.php');
@unlink(ENGINE_DIR.'/cache/system/cron.php');
@unlink(ENGINE_DIR.'/cache/system/informers.php');
@unlink(ENGINE_DIR.'/cache/system/plugins.php');
@unlink(ENGINE_DIR.'/data/snap.db');

listdir( ENGINE_DIR . '/cache/system/CSS' );
listdir( ENGINE_DIR . '/cache/system/HTML' );
listdir( ENGINE_DIR . '/cache/system/URI' );
listdir( ENGINE_DIR . '/cache/system/plugins' );

$fdir = opendir( ENGINE_DIR . '/cache' );
		
while ( $file = readdir( $fdir ) ) {
	if( $file != '.htaccess' AND !is_dir($file) ) {
		@unlink( ENGINE_DIR . '/cache/' . $file );
	}
}

include ENGINE_DIR.'/data/dbconfig.php';

$reg_username = $db->safesql( $reg_username );
$reg_password = $db->safesql( $reg_password );

$tableSchema = array();

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_category";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_category (
  `id` mediumint(8) NOT NULL auto_increment,
  `parentid` mediumint(8) NOT NULL default '0',
  `posi` mediumint(8) NOT NULL default '1',
  `name` varchar(50) NOT NULL default '',
  `alt_name` varchar(50) NOT NULL default '',
  `icon` varchar(200) NOT NULL default '',
  `skin` varchar(50) NOT NULL default '',
  `descr` varchar(300) NOT NULL default '',
  `keywords` text NOT NULL,
  `news_sort` varchar(10) NOT NULL default '',
  `news_msort` varchar(4) NOT NULL default '',
  `news_number` smallint(5) NOT NULL default '0',
  `short_tpl` varchar(40) NOT NULL default '',
  `full_tpl` varchar(40) NOT NULL default '',
  `metatitle` varchar(255) NOT NULL default '',
  `show_sub` tinyint(1) NOT NULL default '0',
  `allow_rss` tinyint(1) NOT NULL default '1',
  `fulldescr` text NOT NULL,
  `disable_search` tinyint(1) NOT NULL default '0',
  `disable_main` tinyint(1) NOT NULL default '0',
  `disable_rating` tinyint(1) NOT NULL default '0',
  `disable_comments` tinyint(1) NOT NULL default '0',
  `enable_dzen` tinyint(1) NOT NULL default '1',
  `enable_turbo` tinyint(1) NOT NULL default '1',
  `active` tinyint(1) NOT NULL default '1',
  `rating_type` tinyint(1) NOT NULL default '-1',
  PRIMARY KEY  (`id`)
  ) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_comments";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_comments (
  `id` int(10) unsigned NOT NULL auto_increment,
  `post_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  `date` datetime NOT NULL default '2000-01-01 00:00:00',
  `autor` varchar(40) NOT NULL default '',
  `email` varchar(40) NOT NULL default '',
  `text` text NOT NULL,
  `ip` varchar(46) NOT NULL default '',
  `is_register` tinyint(1) NOT NULL default '0',
  `approve` tinyint(1) NOT NULL default '1',
  `rating` int(11) NOT NULL default '0',
  `vote_num` int(11) NOT NULL default '0',
  `parent` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`),
  KEY `approve` (`approve`),
  KEY `parent` (`parent`),
  KEY `rating` (`rating`),
  FULLTEXT KEY `text` (`text`)
  ) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_email";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_email (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(10) NOT NULL default '',
  `template` text NOT NULL,
  `use_html` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
  ) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";


$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_flood";

$tableSchema[] = "CREATE TABLE  " . PREFIX . "_flood (
  `f_id` int(11) unsigned NOT NULL auto_increment,
  `ip` varchar(46) NOT NULL default '',
  `id` varchar(20) NOT NULL default '',
  `flag` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`f_id`),
  KEY `ip` (`ip`),
  KEY `id` (`id`),
  KEY `flag` (`flag`)
  ) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_images";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_images (
  `id` int(10) unsigned NOT NULL auto_increment,
  `images` text NOT NULL,
  `news_id` int(10) NOT NULL default '0',
  `author` varchar(40) NOT NULL default '',
  `date` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `author` (`author`),
  KEY `news_id` (`news_id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_logs";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_logs (
  `id` int(10) unsigned NOT NULL auto_increment,
  `news_id` int(10) NOT NULL default '0',
  `member` varchar(40) NOT NULL default '',
  `ip` varchar(46) NOT NULL default '',
  `rating` TINYINT(4) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`),
  KEY `member` (`member`),
  KEY `ip` (`ip`)
  ) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_vote";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_vote (
  `id` mediumint(8) NOT NULL auto_increment,
  `category` text NOT NULL,
  `vote_num` mediumint(8) NOT NULL default '0',
  `date` varchar(25) NOT NULL default '0',
  `title` varchar(200) NOT NULL default '',
  `body` text NOT NULL,
  `approve` tinyint(1) NOT NULL default '1',
  `start` varchar(15) NOT NULL default '',
  `end` varchar(15) NOT NULL default '',
  `grouplevel` varchar(250) NOT NULL default 'all',
  PRIMARY KEY  (`id`),
  KEY `approve` (`approve`)
  ) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_vote_result";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_vote_result (
  `id` int(10) NOT NULL auto_increment,
  `ip` varchar(46) NOT NULL default '',
  `name` varchar(40) NOT NULL default '',
  `vote_id` mediumint(8) NOT NULL default '0',
  `answer` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `answer` (`answer`),
  KEY `vote_id` (`vote_id`),
  KEY `ip` (`ip`),
  KEY `name` (`name`)
  ) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_lostdb";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_lostdb (
  `id` mediumint(8) NOT NULL auto_increment,
  `lostname` mediumint(8) NOT NULL default '0',
  `lostid` varchar( 40 ) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `lostid` (`lostid`)
  ) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_pm";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_pm (
  `id` int(11) unsigned NOT NULL auto_increment,
  `subj` varchar(255) NOT NULL default '',
  `text` text NOT NULL,
  `user` MEDIUMINT(8) NOT NULL default '0',
  `user_from` varchar(40) NOT NULL default '',
  `date` int(11) unsigned NOT NULL default '0',
  `pm_read` TINYINT(1) NOT NULL default '0',
  `folder` varchar(10) NOT NULL default '',
  `reply` tinyint(1) NOT NULL default '0',
  `sendid` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `folder` (`folder`),
  KEY `user` (`user`),
  KEY `user_from` (`user_from`),
  KEY `pm_read` (`pm_read`)
  ) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_post";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_post (
  `id` int(11) NOT NULL auto_increment,
  `autor` varchar(40) NOT NULL default '',
  `date` datetime NOT NULL default '2000-01-01 00:00:00',
  `short_story` MEDIUMTEXT NOT NULL,
  `full_story` MEDIUMTEXT NOT NULL,
  `xfields` MEDIUMTEXT NOT NULL,
  `title` varchar(255) NOT NULL default '',
  `descr` varchar(300) NOT NULL default '',
  `keywords` text NOT NULL,
  `category` varchar(190) NOT NULL default '0',
  `alt_name` varchar(190) NOT NULL default '',
  `comm_num` mediumint(8) unsigned NOT NULL default '0',
  `allow_comm` tinyint(1) NOT NULL default '1',
  `allow_main` tinyint(1) unsigned NOT NULL default '1',
  `approve` tinyint(1) NOT NULL default '0',
  `fixed` tinyint(1) NOT NULL default '0',
  `allow_br` tinyint(1) NOT NULL default '1',
  `symbol` varchar(3) NOT NULL default '',
  `tags` VARCHAR(255) NOT NULL default '',
  `metatitle` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `autor` (`autor`),
  KEY `alt_name` (`alt_name`),
  KEY `category` (`category`),
  KEY `approve` (`approve`),
  KEY `allow_main` (`allow_main`),
  KEY `date` (`date`),
  KEY `symbol` (`symbol`),
  KEY `comm_num` (`comm_num`),
  KEY `fixed` (`fixed`),
  FULLTEXT KEY `short_story` (`short_story`,`full_story`,`xfields`,`title`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_post_extras";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_post_extras (
  `eid` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL DEFAULT '0',
  `news_read` int(11) NOT NULL DEFAULT '0',
  `allow_rate` tinyint(1) NOT NULL DEFAULT '1',
  `rating` int(11) NOT NULL DEFAULT '0',
  `vote_num` int(11) NOT NULL DEFAULT '0',
  `votes` tinyint(1) NOT NULL DEFAULT '0',
  `view_edit` tinyint(1) NOT NULL DEFAULT '0',
  `disable_index` tinyint(1) NOT NULL DEFAULT '0',
  `related_ids` varchar(255) NOT NULL DEFAULT '',
  `access` varchar(150) NOT NULL DEFAULT '',
  `editdate` int(11) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(40) NOT NULL DEFAULT '',
  `reason` varchar(255) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `disable_search` tinyint(1) NOT NULL DEFAULT '0',
  `need_pass` tinyint(1) NOT NULL DEFAULT '0',
  `allow_rss` TINYINT(1) NOT NULL DEFAULT '1',
  `allow_rss_turbo` TINYINT(1) NOT NULL DEFAULT '1',
  `allow_rss_dzen` TINYINT(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`eid`),
  KEY `news_id` (`news_id`),
  KEY `user_id` (`user_id`),
  KEY `rating` (`rating`),
  KEY `disable_search` (`disable_search`),
  KEY `allow_rss` (`allow_rss`),
  KEY `news_read` (`news_read`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_post_extras_cats";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_post_extras_cats (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` INT(11) NOT NULL default '0',
  `cat_id` INT(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`),
  KEY `cat_id` (`cat_id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_static";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_static (
  `id` MEDIUMINT(8) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `descr` varchar(255) NOT NULL default '',
  `template` MEDIUMTEXT NOT NULL,
  `allow_br` tinyint(1) NOT NULL default '0',
  `allow_template` tinyint(1) NOT NULL default '0',
  `grouplevel` varchar(100) NOT NULL default 'all',
  `tpl` varchar(40) NOT NULL default '',
  `metadescr` varchar(300) NOT NULL default '',
  `metakeys` text NOT NULL,
  `views` mediumint(8) NOT NULL default '0',
  `template_folder` varchar(50) NOT NULL default '',
  `date` int(11) unsigned NOT NULL default '0',
  `metatitle` varchar(255) NOT NULL default '',
  `allow_count` tinyint(1) NOT NULL default '1',
  `sitemap` tinyint(1) NOT NULL default '1',
  `disable_index` tinyint(1) NOT NULL default '0',
  `disable_search` tinyint(1) NOT NULL default '0',
  `password` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`),
  KEY `disable_search` (`disable_search`),
  FULLTEXT KEY `template` (`template`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_users";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_users (
  `email` varchar(50) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `name` varchar(40) NOT NULL default '',
  `user_id` int(11) NOT NULL auto_increment,
  `news_num` mediumint(8) NOT NULL default '0',
  `comm_num` mediumint(8) NOT NULL default '0',
  `user_group` smallint(5) NOT NULL default '4',
  `lastdate` varchar(20) NOT NULL default '',
  `reg_date` varchar(20) NOT NULL default '',
  `banned` varchar(5) NOT NULL default '',
  `allow_mail` tinyint(1) NOT NULL default '1',
  `info` text NOT NULL,
  `signature` text NOT NULL,
  `foto` varchar(255) NOT NULL default '',
  `fullname` varchar(100) NOT NULL default '',
  `land` varchar(100) NOT NULL default '',
  `favorites` text NOT NULL,
  `pm_all` smallint(5) NOT NULL default '0',
  `pm_unread` smallint(5) NOT NULL default '0',
  `time_limit` varchar(20) NOT NULL default '',
  `xfields` text NOT NULL,
  `allowed_ip` varchar(255) NOT NULL default '',
  `hash` varchar(32) NOT NULL default '',
  `logged_ip` varchar(46) NOT NULL default '',
  `restricted` tinyint(1) NOT NULL default '0',
  `restricted_days` smallint(4) NOT NULL default '0',
  `restricted_date` varchar(15) NOT NULL default '',
  `timezone` varchar(100) NOT NULL default '',
  `news_subscribe` tinyint(1) NOT NULL default '0',
  `comments_reply_subscribe` tinyint(1) NOT NULL default '0',
  `twofactor_auth` tinyint(1) NOT NULL default '0',
  `cat_add` varchar(500) NOT NULL DEFAULT '',
  `cat_allow_addnews` varchar(500) NOT NULL DEFAULT '',
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `email` (`email`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_banned";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_banned (
  `id` smallint(5) NOT NULL auto_increment,
  `users_id` int(11) NOT NULL default '0',
  `descr` text NOT NULL,
  `date` varchar(15) NOT NULL default '',
  `days` smallint(4) NOT NULL default '0',
  `ip` varchar(46) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`users_id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_files";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_files (
  `id` int(11) NOT NULL auto_increment,
  `news_id` int(11) NOT NULL default '0',
  `name` varchar(250) NOT NULL default '',
  `onserver` varchar(250) NOT NULL default '',
  `author` varchar(40) NOT NULL default '',
  `date` varchar(15) NOT NULL default '',
  `dcount` int(11) NOT NULL default '0',
  `size` bigint(20) NOT NULL default '0',
  `checksum` char(32) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_usergroups";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_usergroups (
  `id` smallint(5) NOT NULL auto_increment,
  `group_name` varchar(50) NOT NULL default '',
  `allow_cats` text NOT NULL,
  `allow_adds` tinyint(1) NOT NULL default '1',
  `cat_add` text NOT NULL,
  `allow_admin` tinyint(1) NOT NULL default '0',
  `allow_addc` tinyint(1) NOT NULL default '0',
  `allow_editc` tinyint(1) NOT NULL default '0',
  `allow_delc` tinyint(1) NOT NULL default '0',
  `edit_allc` tinyint(1) NOT NULL default '0',
  `del_allc` tinyint(1) NOT NULL default '0',
  `moderation` tinyint(1) NOT NULL default '0',
  `allow_all_edit` tinyint(1) NOT NULL default '0',
  `allow_edit` tinyint(1) NOT NULL default '0',
  `allow_pm` tinyint(1) NOT NULL default '0',
  `max_pm` smallint(5) NOT NULL default '0',
  `max_foto` VARCHAR(10) NOT NULL default '',
  `allow_files` tinyint(1) NOT NULL default '0',
  `allow_hide` tinyint(1) NOT NULL default '1',
  `allow_short` tinyint(1) NOT NULL default '0',
  `time_limit` tinyint(1) NOT NULL default '0',
  `rid` smallint(5) NOT NULL default '0',
  `allow_fixed` tinyint(1) NOT NULL default '0',
  `allow_feed`  tinyint(1) NOT NULL default '1',
  `allow_search`  tinyint(1) NOT NULL default '1',
  `allow_poll`  tinyint(1) NOT NULL default '1',
  `allow_main`  tinyint(1) NOT NULL default '1',
  `captcha`  tinyint(1) NOT NULL default '0',
  `icon` varchar(200) NOT NULL default '',
  `allow_modc`  tinyint(1) NOT NULL default '0',
  `allow_rating` tinyint(1) NOT NULL default '1',
  `allow_offline` tinyint(1) NOT NULL default '0',
  `allow_image_upload` tinyint(1) NOT NULL default '0',
  `allow_file_upload` tinyint(1) NOT NULL default '0',
  `allow_signature` tinyint(1) NOT NULL default '0',
  `allow_url` tinyint(1) NOT NULL default '1',
  `news_sec_code` tinyint(1) NOT NULL default '1',
  `allow_image` tinyint(1) NOT NULL default '0',
  `max_signature` SMALLINT(6) NOT NULL default '0',
  `max_info` SMALLINT(6) NOT NULL default '0',
  `admin_addnews` tinyint(1) NOT NULL default '0',
  `admin_editnews` tinyint(1) NOT NULL default '0',
  `admin_comments` tinyint(1) NOT NULL default '0',
  `admin_categories` tinyint(1) NOT NULL default '0',
  `admin_editusers` tinyint(1) NOT NULL default '0',
  `admin_wordfilter` tinyint(1) NOT NULL default '0',
  `admin_xfields` tinyint(1) NOT NULL default '0',
  `admin_userfields` tinyint(1) NOT NULL default '0',
  `admin_static` tinyint(1) NOT NULL default '0',
  `admin_editvote` tinyint(1) NOT NULL default '0',
  `admin_newsletter` tinyint(1) NOT NULL default '0',
  `admin_blockip` tinyint(1) NOT NULL default '0',
  `admin_banners` tinyint(1) NOT NULL default '0',
  `admin_rss` tinyint(1) NOT NULL default '0',
  `admin_iptools` tinyint(1) NOT NULL default '0',
  `admin_rssinform` tinyint(1) NOT NULL default '0',
  `admin_googlemap` tinyint(1) NOT NULL default '0',
  `allow_html` tinyint(1) NOT NULL default '1',
  `group_prefix` text NOT NULL,
  `group_suffix` text NOT NULL,
  `allow_subscribe` tinyint(1) NOT NULL default '0',
  `allow_image_size` tinyint(1) NOT NULL default '0',
  `cat_allow_addnews` text NOT NULL,
  `flood_news` smallint(6) NOT NULL default '0',
  `max_day_news` smallint(6) NOT NULL default '0',
  `force_leech` tinyint(1) NOT NULL default '0',
  `edit_limit` smallint(6) NOT NULL default '0',
  `captcha_pm` tinyint(1) NOT NULL default '0',
  `max_pm_day` smallint(6) NOT NULL default '0',
  `max_mail_day` smallint(6) NOT NULL default '0',
  `admin_tagscloud` tinyint(1) NOT NULL default '0',
  `allow_vote` tinyint(1) NOT NULL default '0',
  `admin_complaint` tinyint(1) NOT NULL default '0',
  `news_question` tinyint(1) NOT NULL default '0',
  `comments_question` tinyint(1) NOT NULL default '0',
  `max_comment_day` smallint(6) NOT NULL default '0',
  `max_images` smallint(6) NOT NULL default '0',
  `max_files` smallint(6) NOT NULL default '0',
  `disable_news_captcha` smallint(6) NOT NULL default '0',
  `disable_comments_captcha` smallint(6) NOT NULL default '0',
  `pm_question` tinyint(1) NOT NULL default '0',
  `captcha_feedback` tinyint(1) NOT NULL default '1',
  `feedback_question` tinyint(1) NOT NULL default '0',
  `files_type` varchar(255) NOT NULL default '',
  `max_file_size` mediumint(9) NOT NULL default '0',
  `files_max_speed` smallint(6) NOT NULL default '0',
  `spamfilter` tinyint(1) NOT NULL default '2',
  `allow_comments_rating` tinyint(1) NOT NULL default '1',
  `max_edit_days` tinyint(1) NOT NULL default '0',
  `spampmfilter` tinyint(1) NOT NULL default '0',
  `force_reg` TINYINT(1) NOT NULL default '0',
  `force_reg_days` MEDIUMINT(9) NOT NULL default '0',
  `force_reg_group` SMALLINT(6) NOT NULL default '4',
  `force_news` TINYINT(1) NOT NULL default '0',
  `force_news_count` MEDIUMINT(9) NOT NULL default '0',
  `force_news_group` SMALLINT(6) NOT NULL default '4',
  `force_comments` TINYINT(1) NOT NULL default '0',
  `force_comments_count` MEDIUMINT(9) NOT NULL default '0',
  `force_comments_group` SMALLINT(6) NOT NULL default '4',
  `force_rating` TINYINT(1) NOT NULL default '0',
  `force_rating_count` MEDIUMINT(9) NOT NULL default '0',
  `force_rating_group` SMALLINT(6) NOT NULL default '4',
  `not_allow_cats` text NOT NULL,
  `allow_up_image` TINYINT(1) NOT NULL default '0',
  `allow_up_watermark` TINYINT(1) NOT NULL default '0',
  `allow_up_thumb` TINYINT(1) NOT NULL default '0',
  `up_count_image` SMALLINT(6) NOT NULL default '0',
  `up_image_side` varchar(20) NOT NULL default '',
  `up_image_size` MEDIUMINT(9) NOT NULL default '0',
  `up_thumb_size` varchar(20) NOT NULL default '',
  `allow_mail_files` TINYINT(1) NOT NULL DEFAULT '0',
  `max_mail_files` SMALLINT(6) NOT NULL DEFAULT '0',
  `max_mail_allfiles` MEDIUMINT(9) NOT NULL DEFAULT '0',
  `mail_files_type` VARCHAR(100) NOT NULL DEFAULT '',
  `video_comments` TINYINT(1) NOT NULL DEFAULT '0',
  `media_comments` TINYINT(1) NOT NULL DEFAULT '0',
  `min_image_side` VARCHAR(20) NOT NULL DEFAULT '',
  PRIMARY KEY  (`id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";


$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_poll";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_poll (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `news_id` int(10) unsigned NOT NULL default '0',
  `title` varchar(200) NOT NULL default '',
  `frage` varchar(200) NOT NULL default '',
  `body` text NOT NULL,
  `votes` mediumint(8) NOT NULL default '0',
  `multiple` tinyint(1) NOT NULL default '0',
  `answer` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_poll_log";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_poll_log (
  `id` int(10) unsigned NOT NULL auto_increment,
  `news_id` int(10) unsigned NOT NULL default '0',
  `member` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`),
  KEY `member` (`member`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_banners";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_banners (
  `id` smallint(5) NOT NULL auto_increment,
  `banner_tag` varchar(40) NOT NULL default '',
  `descr` varchar(200) NOT NULL default '',
  `code` text NOT NULL,
  `approve` tinyint(1) NOT NULL default '0',
  `short_place` tinyint(1) NOT NULL default '0',
  `bstick` tinyint(1) NOT NULL default '0',
  `main` tinyint(1) NOT NULL default '0',
  `category` VARCHAR(255) NOT NULL default '',
  `grouplevel` varchar(100) NOT NULL default 'all',
  `start` varchar(15) NOT NULL default '',
  `end` varchar(15) NOT NULL default '',
  `fpage` tinyint(1) NOT NULL default '0',
  `innews` tinyint(1) NOT NULL default '0',
  `devicelevel` varchar(10) NOT NULL default '',
  `allow_views` tinyint(1) NOT NULL default '0',
  `max_views` int(11) NOT NULL default '0',
  `allow_counts` tinyint(1) NOT NULL default '0',
  `max_counts` int(11) NOT NULL default '0',
  `views` int(11) NOT NULL default '0',
  `clicks` int(11) NOT NULL default '0',
  `rubric` mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_rss";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_rss (
  `id` smallint(5) NOT NULL auto_increment,
  `url` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `allow_main` tinyint(1) NOT NULL default '0',
  `allow_rating` tinyint(1) NOT NULL default '0',
  `allow_comm` tinyint(1) NOT NULL default '0',
  `text_type` tinyint(1) NOT NULL default '0',
  `date` tinyint(1) NOT NULL default '0',
  `search` text NOT NULL,
  `max_news` tinyint(3) NOT NULL default '0',
  `cookie` text NOT NULL,
  `category` smallint(5) NOT NULL default '0',
  `lastdate` INT(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_views";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_views (
  `id` int(11) NOT NULL auto_increment,
  `news_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";


$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_rssinform";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_rssinform (
  `id` smallint(5) NOT NULL auto_increment,
  `tag` varchar(40) NOT NULL default '',
  `descr` varchar(255) NOT NULL default '',
  `category` varchar(200) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `template` varchar(40) NOT NULL default '',
  `news_max` smallint(5) NOT NULL default '0',
  `tmax` smallint(5) NOT NULL default '0',
  `dmax` smallint(5) NOT NULL default '0',
  `approve` tinyint(1) NOT NULL default '1',
  `rss_date_format` VARCHAR(20) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_notice";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_notice (
  `id` mediumint(8) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `notice` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_static_files";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_static_files (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `static_id` int(11) NOT NULL default '0',
  `author` varchar(40) NOT NULL default '',
  `date` varchar(15) NOT NULL default '',
  `name` varchar(200) NOT NULL default '',
  `onserver` varchar(190) NOT NULL default '',
  `dcount` int(11) NOT NULL default '0',
  `size` bigint(20) NOT NULL default '0',
  `checksum` char(32) NOT NULL default '',
  PRIMARY KEY (`id`),
  KEY `static_id` (`static_id`),
  KEY `onserver` (`onserver`),
  KEY `author` (`author`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_tags";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_tags (
  `id` INT(11) NOT NULL auto_increment,
  `news_id` INT(11) NOT NULL default '0',
  `tag` varchar(100) CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_bin NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`),
  KEY `tag` (`tag`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_post_log";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_post_log (
  `id` INT(11) NOT NULL auto_increment,
  `news_id` INT(11) NOT NULL default '0',
  `expires` varchar(15) NOT NULL default '',
  `action` tinyint(1) NOT NULL default '0',
  `move_cat` VARCHAR(190) NOT NULL DEFAULT '',
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`),
  KEY `expires` (`expires`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_admin_sections";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_admin_sections (
  `id` mediumint(8) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `descr` varchar(255) NOT NULL default '',
  `icon` varchar(255) NOT NULL default '',
  `allow_groups` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_subscribe";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_subscribe (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `name` varchar(40) NOT NULL default '',
  `email`  varchar(50) NOT NULL default '',
  `news_id` int(11) NOT NULL default '0',
  `hash` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`),
  KEY `user_id` (`user_id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_sendlog";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_sendlog (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(40) NOT NULL DEFAULT '',
  `date` INT(11) unsigned NOT NULL DEFAULT '0',
  `flag` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `date` (`date`),
  KEY `flag` (`flag`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_login_log";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_login_log (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(46) NOT NULL DEFAULT '',
  `count` smallint(6) NOT NULL DEFAULT '0',
  `date` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip` (`ip`),
  KEY `date` (`date`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_mail_log";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_mail_log (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `mail` varchar(50) NOT NULL DEFAULT '',
  `hash` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `hash` (`hash`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_complaint";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_complaint (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `p_id` int(11) NOT NULL DEFAULT '0',
  `c_id` int(11) NOT NULL DEFAULT '0',
  `n_id` int(11) NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `from` varchar(40) NOT NULL DEFAULT '',
  `to` varchar(255) NOT NULL DEFAULT '',
  `date` int(11) unsigned NOT NULL DEFAULT '0',
  `email` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `c_id` (`c_id`),
  KEY `p_id` (`p_id`),
  KEY `n_id` (`n_id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_ignore_list";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_ignore_list (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL default '0',
  `user_from` VARCHAR(40) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `user` (`user`),
  KEY `user_from` (`user_from`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_admin_logs";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_admin_logs (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL DEFAULT '',
  `date` int(11) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(46) NOT NULL DEFAULT '',
  `action` int(11) NOT NULL DEFAULT '0',
  `extras` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `date` (`date`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_question";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_question (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL DEFAULT '',
  `answer` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_read_log";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_read_log (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(46) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`),
  KEY `ip` (`ip`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_spam_log";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_spam_log (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(46) NOT NULL DEFAULT '',
  `is_spammer` tinyint(1) NOT NULL DEFAULT '0',
  `email` varchar(50) NOT NULL DEFAULT '',
  `date` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`),
  KEY `is_spammer` (`is_spammer`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_links";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_links (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(255) NOT NULL DEFAULT '',
  `link` varchar(255) NOT NULL DEFAULT '',
  `only_one` tinyint(1) NOT NULL DEFAULT '0',
  `replacearea` tinyint(1) NOT NULL DEFAULT '1',
  `rcount` tinyint(3) NOT NULL DEFAULT '0',
  `targetblank` tinyint(1) NOT NULL DEFAULT '0',
   `title` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_social_login";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_social_login (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` varchar(40) NOT NULL DEFAULT '',
  `uid` int(11) NOT NULL DEFAULT '0',
  `password` varchar(32) NOT NULL DEFAULT '',
  `provider` varchar(15) NOT NULL DEFAULT '',
  `wait` tinyint(1) NOT NULL DEFAULT '0',
  `waitlogin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sid` (`sid`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_comment_rating_log";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_comment_rating_log (
  `id` int unsigned NOT NULL auto_increment,
  `c_id` int NOT NULL default '0',
  `member` varchar(40) NOT NULL default '',
  `ip` varchar(46) NOT NULL default '',
  `rating` TINYINT(4) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`),
  KEY `c_id` (`c_id`),
  KEY `member` (`member`),
  KEY `ip` (`ip`)
  ) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_xfsearch";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_xfsearch (
  `id` INT(11) NOT NULL auto_increment,
  `news_id` INT(11) NOT NULL default '0',
  `tagname` varchar(50) NOT NULL default '',
  `tagvalue` varchar(100) CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_bin NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`),
  KEY `tagname` (`tagname`),
  KEY `tagvalue` (`tagvalue`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_comments_files";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_comments_files (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `c_id` int(10) NOT NULL default '0',
  `author` varchar(40) NOT NULL default '',
  `date` varchar(15) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY (`id`),
  KEY `c_id` (`c_id`),
  KEY `author` (`author`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_twofactor";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_twofactor (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL default '0',
  `pin` varchar(10) NOT NULL default '',
  `attempt` tinyint(1) NOT NULL DEFAULT '0',
  `date` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `pin` (`pin`),
  KEY `date` (`date`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_redirects";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_redirects (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from` varchar(250) NOT NULL default '',
  `to` varchar(250) NOT NULL default '',
  PRIMARY KEY (`id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_post_pass";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_post_pass (
  `id` INT(11) NOT NULL auto_increment,
  `news_id` INT(11) NOT NULL default '0',
  `password` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_metatags";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_metatags (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(250) NOT NULL default '',
  `title` varchar(200) NOT NULL default '',
  `description` varchar(300) NOT NULL default '',
  `keywords` text NOT NULL,
  `page_title` varchar(255) NOT NULL default '',
  `page_description` text NOT NULL,
  `robots` VARCHAR(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_banners_logs";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_banners_logs (
  `id` int(11) unsigned NOT NULL auto_increment,
  `bid` int(11) NOT NULL default '0',
  `click` tinyint(1) NOT NULL default '0',
  `ip` varchar(46) NOT NULL  default '',
  PRIMARY KEY  (`id`),
  KEY `bid` (`bid`),
  KEY `ip` (`ip`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_banners_rubrics";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_banners_rubrics (
  `id` mediumint(8) NOT NULL auto_increment,
  `parentid` mediumint(8) NOT NULL default '0',
  `title` varchar(70) NOT NULL default '',
  `description` varchar(255) NOT NULL  default '',
  PRIMARY KEY  (`id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_plugins";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_plugins (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `icon` varchar(255) NOT NULL DEFAULT '',
  `version` varchar(10) NOT NULL DEFAULT '',
  `dleversion` varchar(10) NOT NULL DEFAULT '',
  `versioncompare` char(2) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `mysqlinstall` text NOT NULL,
  `mysqlupgrade` text NOT NULL,
  `mysqlenable` text NOT NULL,
  `mysqldisable` text NOT NULL,
  `mysqldelete` text NOT NULL,
  `filedelete` tinyint(1) NOT NULL DEFAULT '0',
  `filelist` text NOT NULL,
  `upgradeurl` varchar(255) NOT NULL DEFAULT '',
  `needplugin` varchar(100) NOT NULL default '',
  `phpinstall` text NOT NULL,
  `phpupgrade` text NOT NULL,
  `phpenable` text NOT NULL,
  `phpdisable` text NOT NULL,
  `phpdelete` text NOT NULL,
  `notice` TEXT NOT NULL,
  `mnotice` TINYINT(1) NOT NULL DEFAULT '0',
  `posi` MEDIUMINT(8) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_plugins_files";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_plugins_files (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin_id` int(11) NOT NULL DEFAULT '0',
  `file` varchar(255) NOT NULL DEFAULT '',
  `action` varchar(10) NOT NULL DEFAULT '',
  `searchcode` text NOT NULL,
  `replacecode` mediumtext NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `searchcount` smallint(6) NOT NULL DEFAULT '0',
  `replacecount` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `plugin_id` (`plugin_id`),
  KEY `active` (`active`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_plugins_logs";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_plugins_logs (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin_id` int(11) NOT NULL DEFAULT '0',
  `area` text NOT NULL,
  `error` text NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `plugin_id` (`plugin_id`)
) ENGINE=" . $storage_engine . " DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci";

$tableSchema[] = "INSERT INTO " . PREFIX . "_rssinform VALUES (1, 'dle', 'Новости с Яндекса', '0', 'https://news.yandex.ru/index.rss', 'informer', 3, 0, 200, 1, 'j F Y H:i')";

$tableSchema[] = "INSERT INTO " . PREFIX . "_usergroups VALUES (1, 'Администраторы', 'all', 1, 'all', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 50, 101, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 0, '{THEME}/images/icon_1.gif', 0, 1, 1, 1, 1, 1, 1, 0, 1,500,1000,1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1,1,'<b><span style=\"color:red\">','</span></b>',1,1,'all', 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'zip,rar,exe,doc,pdf,swf', 4096, 0, 2, 1, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 0, 1, '', 1, 1, 1, 3, '800x600', 300, '200x150', 1, 3, 1000, 'jpg,png,zip,pdf',1,1,'10x10')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_usergroups VALUES (2, 'Главные редакторы', 'all', 1, 'all', 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 50, 101, 1, 1, 1, 0, 2, 1, 1, 1, 1, 1, 0, '{THEME}/images/icon_2.gif', 0, 1, 0, 1, 1, 1, 1, 0, 1,500,1000,1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,1,'','',1,1,'all', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'zip,rar,exe,doc,pdf,swf', 4096, 0, 2, 1, 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, 2, 0, 0, 2, '', 1, 1, 1, 3, '800x600', 300, '200x150', 1, 3, 1000, 'jpg,png,zip,pdf',1,1,'10x10')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_usergroups VALUES (3, 'Журналисты', 'all', 1, 'all', 1, 1, 1, 1, 0, 0, 1, 0, 1, 1, 50, 101, 1, 1, 1, 0, 3, 0, 1, 1, 1, 1, 0, '{THEME}/images/icon_3.gif', 0, 1, 0, 1, 1, 1, 1, 0, 1,500,1000,1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,1,'','',1,1,'all', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'zip,rar,exe,doc,pdf,swf', 4096, 0, 2, 1, 0, 0, 0, 0, 3, 0, 0, 3, 0, 0, 3, 0, 0, 3, '', 1, 1, 1, 3, '800x600', 300, '200x150', 0, 3, 1000, 'jpg,png,zip,pdf',1,1,'10x10')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_usergroups VALUES (4, 'Посетители', 'all', 1, 'all', 0, 1, 1, 1, 0, 0, 0, 0, 0, 1, 20, 101, 1, 1, 1, 0, 4, 0, 1, 1, 1, 1, 0, '{THEME}/images/icon_4.gif', 0, 1, 0, 1, 0, 1, 1, 1, 0,500,1000,0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,1,'','',1,0,'all', 0, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'zip,rar,exe,doc,pdf,swf', 4096, 0, 2, 1, 0, 2, 0, 0, 4, 0, 0, 4, 0, 0, 4, 0, 0, 4, '', 0, 0, 0, 1, '800x600', 300, '200x150', 0, 3, 1000, 'jpg,png,zip,pdf',0,0,'10x10')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_usergroups VALUES (5, 'Гости', 'all', 0, 'all', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 5, 0, 1, 1, 1, 0, 1, '{THEME}/images/icon_5.gif', 0, 1, 0, 0, 0, 0, 1, 1, 0,1,1,0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,0,'','',0,0,'all', 0, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '', 0, 0, 2, 1, 0, 2, 0, 0, 5, 0, 0, 5, 0, 0, 5, 0, 0, 5, '', 0, 0, 0, 1, '800x600', 300, '200x150', 0, 3, 1000, 'jpg,png,zip,pdf',0,0,'10x10')";

$tableSchema[] = "INSERT INTO " . PREFIX . "_rss VALUES (1, 'https://dle-news.ru/rss.xml', 'Официальный сайт DataLife Engine', 1, 1, 1, 1, 1, '<div class=\"full-post-content row\">{get}</div><div class=\"full-post-footer ignore-select\">', 5, '', 1, 0)";

$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (1, 'reg_mail', '{%username%},\r\n\r\nЭто письмо отправлено с сайта $url\r\n\r\nВы получили это письмо, так как этот e-mail адрес был использован при регистрации на сайте. Если Вы не регистрировались на этом сайте, просто проигнорируйте это письмо и удалите его. Вы больше не получите такого письма.\r\n\r\n------------------------------------------------\r\nВаш логин и пароль на сайте:\r\n------------------------------------------------\r\n\r\nЛогин: {%username%}\r\nПароль: {%password%}\r\n\r\n------------------------------------------------\r\nИнструкция по активации\r\n------------------------------------------------\r\n\r\nБлагодарим Вас за регистрацию.\r\nМы требуем от Вас подтверждения Вашей регистрации, для проверки того, что введённый Вами e-mail адрес - реальный. Это требуется для защиты от нежелательных злоупотреблений и спама.\r\n\r\nДля активации Вашего аккаунта, зайдите по следующей ссылке:\r\n\r\n{%validationlink%}\r\n\r\nЕсли и при этих действиях ничего не получилось, возможно Ваш аккаунт удалён. В этом случае, обратитесь к Администратору, для разрешения проблемы.\r\n\r\nС уважением,\r\n\r\nАдминистрация $url.', 0)";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (2, 'feed_mail', '{%username_to%},\r\n\r\nДанное письмо вам отправил {%username_from%} с сайта $url\r\n\r\n------------------------------------------------\r\nТекст сообщения\r\n------------------------------------------------\r\n\r\n{%text%}\r\n\r\nIP адрес отправителя: {%ip%}\r\nГруппа: {%group%}\r\n\r\n------------------------------------------------\r\nПомните, что администрация сайта не несет ответственности за содержание данного письма\r\n\r\nС уважением,\r\n\r\nАдминистрация $url', 0)";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (3, 'lost_mail', 'Уважаемый {%username%},\r\n\r\nВы сделали запрос на получение забытого пароля на сайте $url Однако в целях безопасности все пароли хранятся в зашифрованном виде, поэтому мы не можем сообщить вам ваш старый пароль, поэтому если вы хотите сгенерировать новый пароль, зайдите по следующей ссылке: \r\n\r\n{%lostlink%}\r\n\r\nЕсли вы не делали запроса для получения пароля, то просто удалите данное письмо, ваш пароль храниться в надежном месте, и недоступен посторонним лицам.\r\n\r\nIP адрес отправителя: {%ip%}\r\n\r\nС уважением,\r\n\r\nАдминистрация $url', 0)";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (4, 'new_news', 'Уважаемый администратор,\r\n\r\nуведомляем вас о том, что на сайт  $url была добавлена новость, которая в данный момент ожидает модерации.\r\n\r\n------------------------------------------------\r\nКраткая информация о новости\r\n------------------------------------------------\r\n\r\nАвтор: {%username%}\r\nЗаголовок новости: {%title%}\r\nКатегория: {%category%}\r\nДата добавления: {%date%}\r\n\r\nС уважением,\r\n\r\nАдминистрация $url', 0)";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (5, 'comments', 'Уважаемый {%username_to%},\r\n\r\nуведомляем вас о том, что на сайт  $url был добавлен комментарий к новости, на которую вы были подписаны.\r\n\r\n------------------------------------------------\r\nКраткая информация о комментарии\r\n------------------------------------------------\r\n\r\nАвтор: {%username%}\r\nДата добавления: {%date%}\r\nСсылка на новость: {%link%}\r\n\r\n------------------------------------------------\r\nТекст комментария\r\n------------------------------------------------\r\n\r\n{%text%}\r\n\r\n------------------------------------------------\r\n\r\nЕсли вы не хотите больше получать уведомлений о новых комментариях к данной новости, то проследуйте по данной ссылке: {%unsubscribe%}\r\n\r\nС уважением,\r\n\r\nАдминистрация $url', 0)";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (6, 'pm', 'Уважаемый {%username%},\r\n\r\nуведомляем вас о том, что на сайте  $url вам было отправлено персональное сообщение.\r\n\r\n------------------------------------------------\r\nКраткая информация о сообщении\r\n------------------------------------------------\r\n\r\nОтправитель: {%fromusername%}\r\nДата  получения: {%date%}\r\nЗаголовок: {%title%}\r\n\r\n------------------------------------------------\r\nТекст сообщения\r\n------------------------------------------------\r\n\r\n{%text%}\r\n\r\nС уважением,\r\n\r\nАдминистрация $url', 0)";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (7, 'wait_mail', 'Уважаемый {%username%},\r\n\r\nВы сделали запрос на обьединение  вашего аккаунта на сайте $url с аккаунтом в социальной сети {%network%}.  Однако в целях безопасности вам необходимо подтвердить данное действие по следующей ссылке: \r\n\r\n------------------------------------------------\r\n{%link%}\r\n------------------------------------------------\r\n\r\nЕсли вы не делали данного запроса, то просто удалите это письмо, данные вашего аккаунта хранятся в надежном месте, и недоступны посторонним лицам.\r\n\r\nIP адрес отправителя: {%ip%}\r\n\r\nС уважением,\r\n\r\nАдминистрация $url', 0)";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (8, 'newsletter', '<html>\r\n<head>\r\n<title>{%title%}</title>\r\n<meta content=\"text/html; charset={%charset%}\" http-equiv=Content-Type>\r\n<style type=\"text/css\">\r\nhtml,body{\r\n    font-family: Verdana;\r\n    word-spacing: 0.1em;\r\n    letter-spacing: 0;\r\n    line-height: 1.5em;\r\n    font-size: 11px;\r\n}\r\n\r\np {\r\n	margin:0px;\r\n	padding: 0px;\r\n}\r\n\r\na:active,\r\na:visited,\r\na:link {\r\n	color: #4b719e;\r\n	text-decoration:none;\r\n}\r\n\r\na:hover {\r\n	color: #4b719e;\r\n	text-decoration: underline;\r\n}\r\n</style>\r\n</head>\r\n<body>\r\n{%content%}\r\n</body>\r\n</html>', 0)";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (9, 'twofactor', '{%username%},\r\n\r\nЭто письмо отправлено с сайта $url\r\n\r\nВы получили это письмо, так как для вашего аккаунта включена двухфакторная авторизация. Для авторизации на сайте вам необходимо ввести полученный вами пин-код.\r\n\r\n------------------------------------------------\r\nПин-код:\r\n------------------------------------------------\r\n\r\n{%pin%}\r\n\r\n------------------------------------------------\r\nЕсли Вы не авторизовывались на нашем сайте, то ваш пароль известен посторонним лицам. Вам нужно незамедлительно зайти на сайт под своим логином и паролем, и в своем профиле изменить свой пароль.\r\n\r\nIP пользователя который ввел пароль: {%ip%}\r\n\r\nС уважением,\r\n\r\nАдминистрация $url', 0)";


$tableSchema[] = "INSERT INTO " . PREFIX . "_category (name, alt_name, keywords) values ('О скрипте', 'o-skripte', '')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_category (name, alt_name, keywords) values ('В мире', 'v-mire', '')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_category (name, alt_name, keywords) values ('Экономика', 'ekonomika', '')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_category (name, alt_name, keywords) values ('Религия', 'religiya', '')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_category (name, alt_name, keywords) values ('Криминал', 'kriminal', '')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_category (name, alt_name, keywords) values ('Спорт', 'sport', '')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_category (name, alt_name, keywords) values ('Культура', 'kultura', '')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_category (name, alt_name, keywords) values ('Инопресса', 'inopressa', '')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_banners (banner_tag, descr, code, approve, short_place, bstick, main, category) values ('header', 'Верхний баннер', '<div style=\"text-align:center;\"><a href=\"https://dle-news.ru/\" target=\"_blank\"><img src=\"{$url}templates/Default/images/_banner_.gif\" style=\"border: none;\" alt=\"\" /></a></div>', 1, 0, 0, 0, 0)";

$add_time = time();
$thistime = date ("Y-m-d H:i:s", $add_time);

$tableSchema[] = "INSERT INTO " . PREFIX . "_static (`name`, `descr`, `template`, `allow_br`, `allow_template`, `grouplevel`, `tpl`, `metadescr`, `metakeys`, `views`, `template_folder`, `date`) VALUES ('dle-rules-page', 'Общие правила на сайте', '<b>Общие правила поведения на сайте:</b><br><br>Начнем с того, что на сайте общаются сотни людей, разных религий и взглядов, и все они являются полноправными посетителями нашего сайта, поэтому если мы хотим чтобы это сообщество людей функционировало нам и необходимы правила. Мы настоятельно рекомендуем прочитать настоящие правила, это займет у вас всего минут пять, но сбережет нам и вам время и поможет сделать сайт более интересным и организованным.<br><br>Начнем с того, что на нашем сайте нужно вести себя уважительно ко всем посетителям сайта. Не надо оскорблений по отношению к участникам, это всегда лишнее. Если есть претензии - обращайтесь к Админам или Модераторам (воспользуйтесь личными сообщениями). Оскорбление других посетителей считается у нас одним из самых тяжких нарушений и строго наказывается администрацией. <b>У нас строго запрещен расизм, религиозные и политические высказывания.</b> Заранее благодарим вас за понимание и за желание сделать наш сайт более вежливым и дружелюбным.<br><br><b>На сайте строго запрещено:</b> <br><br>- сообщения, не относящиеся к содержанию статьи или к контексту обсуждения<br>- оскорбление и угрозы в адрес посетителей сайта<br>- в комментариях запрещаются выражения, содержащие ненормативную лексику, унижающие человеческое достоинство, разжигающие межнациональную рознь<br>- спам, а также реклама любых товаров и услуг, иных ресурсов, СМИ или событий, не относящихся к контексту обсуждения статьи<br><br>Давайте будем уважать друг друга и сайт, на который Вы и другие читатели приходят пообщаться и высказать свои мысли. Администрация сайта оставляет за собой право удалять комментарии или часть комментариев, если они не соответствуют данным требованиям.<br><br>При нарушении правил вам может быть дано <b>предупреждение</b>. В некоторых случаях может быть дан бан <b>без предупреждений</b>. По вопросам снятия бана писать администратору.<br><br><b>Оскорбление</b> администраторов или модераторов также караются <b>баном</b> - уважайте чужой труд.<br><br><div style=\"text-align:center;\">{ACCEPT-DECLINE}</div>', 1, 1, 'all', '', 'Общие правила', 'Общие правила', 0, '', '{$add_time}')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_users (name, password, email, reg_date, lastdate, user_group, news_num, info, signature, favorites, xfields) values ('$reg_username', '$reg_password', '$reg_email', '$add_time', '$add_time', '1', '3', '', '', '', '')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_vote (category, vote_num, date, title, body) VALUES ('all', '0', '$thistime', 'Оцените работу движка', 'Лучший из новостных<br>Неплохой движок<br>Устраивает ... но ...<br>Встречал и получше<br>Совсем не понравился')";

$title = "Добро пожаловать";
$short_story = "<div style=\"text-align:center;\"><img src=\"".$url."uploads/boxsmall.jpg\" alt=\"\" /></div>Добро пожаловать на демонстрационную страницу движка DataLife Engine. DataLife Engine - это многопользовательский новостной движок, обладающий большими функциональными возможностями. Движок предназначен, в первую очередь, для создания новостных блогов и сайтов с большим информационным контекстом. Однако, он имеет большое количество настроек, которые позволяют использовать его практически для любых целей. Движок может быть интегрирован практически в любой существующий дизайн, и не имеет никаких ограничений по созданию шаблонов для него. Еще одной ключевой особенностью DataLife Engine является низкая нагрузка на системные ресурсы. Даже при очень большой аудитории сайта нагрузка на сервер будет минимальной, и вы не будете испытывать каких-либо проблем с отображением информации. Движок оптимизирован под поисковые системы. Обо всех функциональных особенностях вы сможете прочитать на <a href=\"https://dle-news.ru/\" target=\"_blank\">нашей странице</a>.<br><br>Обсуждение скрипта по всем вопросам ведется <a href=\"https://forum.dle-news.ru/index.php\" target=\"_blank\">здесь</a>. Также там Вы сможете получить оперативную помощь.";
$full_story = "";

$tableSchema[] = "INSERT INTO " . PREFIX . "_post (id, date, autor, short_story, full_story, xfields, title, keywords, category, alt_name, allow_comm, approve, allow_main, tags) values ('1', '$thistime', '$reg_username', '$short_story', '$full_story', '', '$title', '', '1', 'post1', '1', '1', '1', 'по, новости')";

$title = "Приобретение и оплата скрипта";
$short_story = "Уважаемые вебмастера хотим для вас сделать небольшое дополнение. Прежде чем обратиться с каким-либо вопросом в службу поддержки скрипта, убедитесь что вы тщательно прочитали документацию по скрипту и не нашли там для вас необходимого ответа. Мы оставляем за собой право игнорировать вопросы, поступившие к нам от пользователей, использующих некоммерческую версию скрипта или не оплативших лицензию, включающую в себя службу технической поддержки. Вы можете приобрести один из двух типов лицензии на DataLife Engine по вашему желанию:<br><br>- <b>Базовая лицензия.</b> При приобретении данной лицензии вы также получаете возможность получения бесплатно новых версий скрипта в течении <b>одного года</b>.<br><br>- <b>Расширенная лицензия.</b> При приобретении данной лицензии вы получаете все что входит в базовую лицензию, а также дополнительно входит служба технической поддержки скрипта и разрешение на снятие копирайтов на скрипт с пользовательской части (видимой для обычных посетителей сайта).<br><br><b>Срок действия лицензии</b> составляет <span style=\"color:#FF0000\">1 год</span>, в течении которого вы бесплатно будете получать все последующие версии скрипта и обновления, а в случае приобретения расширенной лицензии, и тех. поддержку. После окончания срока лицензии вы можете ее продлить, либо использовать пожизненно бесплатно актуальную на тот момент времени версию скрипта.<br><br><b>Как оплатить скрипт вы можете прочитать на</b> <a href=\"https://dle-news.ru/price.html\" target=\"_blank\">https://dle-news.ru/price.html</a><br><br><b>С уважением,<br><br>SoftNews Media Group</b>";

$add_time = time()-20;
$thistime = date ("Y-m-d H:i:s", $add_time);

$tableSchema[] = "INSERT INTO " . PREFIX . "_post (id, date, autor, short_story, full_story, xfields, title, keywords, category, alt_name, allow_comm, approve, allow_main, tags) values ('2', '$thistime', '$reg_username', '$short_story', '$full_story', '', '$title', '', '1', 'post2', '1', '1', '1', 'по, новости')";

$title = "Осуществление технической поддержки скрипта";
$short_story = "<b>Техническая поддержка скрипта</b> осуществляется силами <a href=\"https://forum.dle-news.ru/index.php\" target=\"_blank\">форума поддержки</a>, а также по E-Mail. По мере поступления возникших у вас вопросов мы стараемся ответить на все ваши вопросы, но в связи с большим количеством посетителей, это не всегда является возможным. Поэтому гарантированная техническая поддержка предоставляется, только пользователям, которые приобрели расширенную лицензию на скрипт.<br><br><b>Услуги по технической поддержке скрипта включают в себя:</b><br><br>1. Приоритетное получение ответа на вопросы, которые задают пользователи впервые столкнувшиеся со скриптом и естественно не знающие всех нюансов работы скрипта. В компетенции службы поддержки находится только помощь только по непосредственным сбоям самого скрипта, в случае если причиной некорректной работы скрипта явился ваш шаблон, не соответствующий требованиям скрипта, то в поддержке вам может быть отказано.<br><br>2. Также вы получаете возможность одноразовой установки скрипта вам на сервер, включая настройку его до полной работоспособности с учетом текущих настроек сервера (иногда нужно верно отключить поддержку ЧПУ, включение специальных директив для Русского Апача, для верной загрузки картинок и прочее...).<br><br>3. Вы получаете консультационную поддержку по работе со структурой скрипта, например у вас есть желание добавить небольшие изменения в скрипт для более удобной работы для вас, вы сможете сэкономить время на поиске нужного куска кода просто спросив у нас. Вам будет предоставлена консультация где это копать и как вообще лучше реализовать поставленную задачу. (Внимание мы не пишем за вас дополнительные модули, а только помогаем вам лучше разобраться со структурой скрипта, поэтому всегда задавайте вопросы по существу, вопросы типа: \"как мне сделать такую фишку\" могут быть проигнорированы службой поддержки).<br><br>4. Еще одна из часто возникающих проблем это некорректное обновление скрипта, например во время обновления произошел сбой сервера, часть новых данных была внесена в базу и настройки, часть нет, в итоге вы получаете нерабочий скрипт, со всеми вытекающими последствиями. В данном случае для вас будет проведена ручная коррекция поврежденной структуры базы данных.<br><br>В случае если вы не являетесь подписчиком дополнительной службы поддержки, ваши вопросы могут быть проигнорированы и оставлены без ответа.<br><br><b>С уважением,<br><br>SoftNews Media Group</b>";

$add_time = time()-50;
$thistime = date ("Y-m-d H:i:s", $add_time);

$tableSchema[] = "INSERT INTO " . PREFIX . "_post (id, date, autor, short_story, full_story, xfields, title, keywords, category, alt_name, allow_comm, approve, allow_main, tags) values ('3', '$thistime', '$reg_username', '$short_story', '$full_story', '', '$title', '', '1', 'post4', '1', '1', '1', '')";

$tableSchema[] = "INSERT INTO " . PREFIX . "_post_extras (news_id, user_id) values ('1', '1'), ('2', '1'), ('3', '1')";

$tableSchema[] = "INSERT INTO " . PREFIX . "_post_extras_cats (news_id, cat_id) values ('1', '1'), ('2', '1'), ('3', '1')";

$tableSchema[] = "INSERT INTO " . PREFIX . "_tags (news_id, tag) values ('1', 'по'), ('2', 'по'), ('3', 'по'), ('1', 'новости'), ('2', 'новости')";

      foreach($tableSchema as $table) {

        $db->query($table);

      }

  echo $skin_header;


echo <<<HTML
<div class="panel panel-default">
  <div class="panel-heading">
    Установка завершена
  </div>
  <div class="panel-body">
Поздравляем Вас, DataLife Engine был успешно установлен на Ваш сервер. Вы можете зайти теперь на главную <a href="{$url}">страницу вашего сайта</a>  и посмотреть возможности скрипта. Либо Вы можете <a href="admin.php">зайти</a> в панель управления DataLife Engine и изменить другие настройки системы.
<br><br><span class="text-danger">Внимание: при установке скрипта создается структура базы данных, создается аккаунт администратора, а также прописываются основные настройки системы, поэтому после успешной установки удалите файл <b>install.php</b> во избежание повторной установки скрипта!</span><br><br>
Приятной Вам работы<br><br>
SoftNews Media Group
  </div>
  <div class="panel-footer">
	<a href="{$url}" class="btn bg-teal btn-sm btn-raised position-left"><i class="fa fa-arrow-circle-o-right position-left"></i>Продолжить</a>
  </div>
</div>
HTML;

}
else {

	if (@file_exists(ENGINE_DIR.'/data/config.php')) {

		msgbox( "", "Установка скрипта автоматически заблокирована", "Внимание, на сервере обнаружена уже установленная копия DataLife Engine. Если вы хотите еще раз произвести установку скрипта, то вам необходимо вручную удалить файл <b>/engine/data/config.php</b>, используя FTP протокол." );

		die ();
	}

	$_SESSION['dle_install'] = 1;

// ********************************************************************************
// Приветствие
// ********************************************************************************

  echo $skin_header;

echo <<<HTML
<form method="get" action="">
<input type="hidden" name="action" value="eula">
<div class="panel panel-default">
  <div class="panel-heading">
    Мастер установки DataLife Engine
  </div>
  <div class="panel-body">
	Добро пожаловать в мастер установки DataLife Engine. Данный мастер поможет вам установить скрипт всего за несколько минут. Однако, не смотря на это, мы настоятельно рекомендуем Вам ознакомиться с документацией по работе со скриптом, а также по его установке, которая поставляется вместе со скриптом.<br><br>
	<span class="text-danger">Внимание: при установке скрипта создается структура базы данных, создается аккаунт администратора, а также прописываются основные настройки системы, поэтому после успешной установки удалите файл <b>install.php</b> во избежание повторной установки скрипта!</span><br><br>
	Приятной Вам работы,<br><br>
	SoftNews Media Group
  </div>
  <div class="panel-footer">
	<button type="submit" class="btn bg-teal btn-sm btn-raised position-left"><i class="fa fa-arrow-circle-o-right position-left"></i>Начать установку</button>
  </div>
</div>
</form>
HTML;
}


echo $skin_footer;
?>