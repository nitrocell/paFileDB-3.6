<?php

/***************************************************************
* paFileDB 3.6                                                 *
*                                                              *
* Author: PHP Arena <http://www.phparena.net>                  *
* File Version 3.6                                             *
* Copyright ©2005-2007 PHP Arena. All Rights Reserved.         *
*                                                              *
* THIS FILE MAY NOT BE REDISTRIBUTED.                          *
* For more information, please see the PHP Arena license at:   *
* http://www.phparena.net/license.html                         *
***************************************************************/

if (file_exists('install')) { die("Please remove the install directory to use paFileDB!"); }
if (file_exists('upgrade')) { die("Please remove the upgrade directory to use paFileDB!"); }

//Start the execution timer
$starttime = microtime();	
$starttime = explode(" ",$starttime);
$starttime = $starttime[1] + $starttime[0];


//Require the important files so paFileDB isn't paUselessScript
require('./includes/smarty/Smarty.class.php');
require('./includes/functions.php');
include('./includes/adodb/adodb-errorhandler.inc.php'); 
include('./includes/adodb/adodb.inc.php');
require('./includes/config.php');
/*Get $act from the query string, set to main if $act is unset 
 (only time its unset is on the main page */
if (!isset($_GET['act'])) { $act = 'main'; } else { $act = $_GET['act']; }


//Load paFileDB settings into $settings array
$settings = $db->GetArray("SELECT * FROM ".$dbPrefix."settings");
$version = '3.6';

//This stops any l33t h4x0ring of paFileDB. Just an extra security measure
$allowed_acts = array('main', 'category', 'view', 'download', 'viewall', 'search', 'email', 'license', 'mirror', 'report', 'stats', 'login', 'register', 'comments', 'myoptions', 'lostpw', 'viewtag');
if (!in_array($act, $allowed_acts))
{
    die("Invalid Action!");
}

//Get Smarty set up and load the right language file
$smarty = new Smarty();
$smarty->config_booleanize = false;
init_smarty($settings[0]['skin']);
$smarty->config_load('english.conf');
if ($settings[0]['lang'] != "english") { $smarty->config_load($settings[0]['lang'].'.conf'); }
$smarty->config_load('config.conf');
$smarty->assign('settings', $settings[0]);
$smarty->assign('act');
$smarty->assign('version', $version);
require('./includes/auth.php');

if (($settings[0]['require_registration'] == 1 && $userinfo[0]['user_userid'] == 0) && ($act != "login" && $act != "register" && $act != "lostpw")) {
	$logreg = '<br /><br /><a href="'.$settings[0]['dburl'].'/index.php?act=login&qs='.urlencode($_SERVER['QUERY_STRING']).'">'.lang('login').'</a> - <a href="'.$settings[0]['dburl'].'/index.php?act=register">'.lang('register').'</a>';
	smarty_error(lang('login_view').$logreg);
}

//Require the file that actually does what we want
require('./includes/'.$act.'.php');

//Display the header
$smarty->display('header.tpl');

//Display the template for whatever page we're showing
$smarty->display($act.'.tpl');

//Calculate execution time
$endtime = microtime();
$endtime = explode(" ",$endtime);
$endtime = $endtime[1] + $endtime[0];
$stime = $endtime - $starttime;

dropDown($settings[0]['dropdown']);
//Send exec time and queries used to Smarty
$smarty->assign('debug_info', array($db->query_count, round($stime,5)));

//Display the footer

$smarty->display('footer.tpl');
?>