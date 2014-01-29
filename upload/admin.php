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

//Load paFileDB settings into $settings array
$settings = $db->GetArray("SELECT * FROM ".$dbPrefix."settings");
$version = '3.6';

//Get Smarty set up and load the right language file
$smarty = new Smarty();
$smarty->config_booleanize = false;
init_smarty($settings[0]['skin']);
$smarty->config_load('english.conf');
if ($settings[0]['lang'] != "english") { $smarty->config_load($settings[0]['lang'].'.conf'); }
$smarty->config_load('config.conf');
$smarty->assign('settings', $settings[0]);
require('./includes/auth.php');

/*Get $act from the query string, set to main if $act is unset 
 (only time its unset is on the main page */
$loginLink = '<br /><br /><b><a href="'.$settings[0]['dburl'].'/index.php?act=login">'.lang('login').'</a></b>';
if (!$userloggedin) { smarty_error(lang('perm_denied').$loginLink); }
else if ($userloggedin && $userinfo[0]['user_status'] < 4) { smarty_error(lang('perm_denied').$loginLink); }
else if ($userloggedin && !isset($_GET['act'])) { $act = 'main'; }
else { $act = $_GET['act']; }

//This stops any l33t h4x0ring of paFileDB. Just an extra security measure
$allowed_acts = array('login', 'main', 'files', 'categories', 'license', 'custom', 'users', 'settings', 'log', 'phpinfo', 'versioncheck', 'myoptions', 'rebuilddrop', 'resetadminpass', 'news');
if (!in_array($act, $allowed_acts))
{
    die("Invalid Action!");
}
if ($act == 'phpinfo') { define('PHP_INFO', true); }

$smarty->assign('act', $act);
$smarty->assign('version', $version);

//Require the file that actually does what we want
require('./includes/admin/'.$act.'.php');

//Display the header
$smarty->display('admin/header.tpl');

//Display the template for whatever page we're showing
$smarty->display('admin/'.$act.'.tpl');

//Calculate execution time
$endtime = microtime();
$endtime = explode(" ",$endtime);
$endtime = $endtime[1] + $endtime[0];
$stime = $endtime - $starttime;

//Send exec time and queries used to Smarty
$smarty->assign('debug_info', array($db->query_count, round($stime,5)));

//Display the footer
$smarty->display('admin/footer.tpl');
?>