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

if (isset($_GET['process'])) {
    $smarty->assign('act', 'process');
    $user = $db->GetArray("SELECT * FROM ".$dbPrefix."users WHERE user_username = '".xhtml_convert($_POST['username'])."'");
    if (count($user) < 1) {
    	smarty_error(lang('user_doesnt_exit'));
    }
 	$smarty->assign('user', $user[0]);
 	
 	//We want this reset key to be impossible to guess, so we MD5 a bunch of random crap.
 	$key = rand(0,1000000000).rand(888888888,999999999).$user[0]['user_password'].time().$_SERVER['REMOTE_ADDR'].substr($user[0]['user_password'], rand(0,16), rand(17,32)).md5(time());
 	//I think that's enough.
	$emailmsg = str_replace(array('%USERNAME%', '%DBNAME%'), array($_POST['username'], $settings[0]['dbname']), lang('lost_password_email'));
	$emailmsg .= "\n\n";
	$emailmsg .= $settings[0]['dburl'].'/index.php?act=lostpw&reset&userid='.$user[0]['user_userid'].'&key='.md5($key);
 	
 	$db->Execute("UPDATE ".$dbPrefix."users SET user_passvalidation = '".md5($key)."' WHERE user_userid = ".$user[0]['user_userid']);
 	pafiledb_mail($settings[0]['dbname'], $settings[0]['fromemail'], array(array('name' => $_POST['username'], 'address' => $user[0]['user_email'])), lang('lost_password'), $emailmsg);

 	
} else if(isset($_GET['reset'])) {
	$smarty->assign('act', 'reset');
	
	$user = $db->GetArray("SELECT * FROM ".$dbPrefix."users WHERE user_userid = ".intval($_GET['userid']));
	if (($_GET['key'] != $user[0]['user_passvalidation']) || empty($user[0]['user_passvalidation'])) {
		smarty_error(lang('reset_error'));
	}
	$smarty->assign('user', $user[0]);
	$smarty->assign('key', $_GET['key']);
} else if (isset($_GET['processreset'])) {
	$user = $db->GetArray("SELECT * FROM ".$dbPrefix."users WHERE user_userid = ".intval($_GET['userid']));
	if (($_GET['key'] != $user[0]['user_passvalidation']) || empty($user[0]['user_passvalidation'])) {
		smarty_error(lang('reset_error'));
	}
	if ($_POST['new_password'] != $_POST['new_confirm']) {
        smarty_error(lang('nomatch'));
    }
    $db->Execute("UPDATE ".$dbPrefix."users SET user_password = '".md5($_POST['new_password'])."', user_passvalidation = '' WHERE user_userid = ".intval($_GET['userid']));
    smarty_redirect(lang('password_reset'), 'index.php?act=login');
}
$smarty->assign('navbar', array(array('name' => $settings[0]['dbname'], 'url' => ''), array('name' => lang('lost_password'), 'url' => '?act=lostpw')));
$smarty->assign('title', $settings[0]['dbname'].' &raquo; '.lang('lost_password'));

?>