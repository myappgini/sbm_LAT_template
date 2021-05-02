<?php
if (!isset($Translation)) {
  $currDir = dirname(__FILE__);
	include("{$currDir}/../defaultLang.php");
	include("{$currDir}/../language.php");
}
include_once("header.php");
$mi = getMemberInfo();

	include("{$currDir}/../hooks/homePages/home_{$mi['group']}.php");

include_once("footer.php"); 
?>
