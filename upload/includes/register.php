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

if ($settings[0]['enable_registration'] == 0) {
	smarty_error(lang('registration_disabled'));
}

if (isset($_GET['process'])) {
    
    //Make sure fields aren't blank
    if (!check_input($_POST)) {
        smarty_error(lang('emptyfield'));
    }
    
    //Make sure the passwords match
    if ($_POST['password'] != $_POST['conf']) {
    	smarty_error(lang('nomatch'));
    }
    
    //Make sure the e-mail address is valid
    if (!eregi('^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$', $_POST['email'])) {
        smarty_error(lang('emailinvalid'));
    }
    
    //Make sure a user doesn't exist with that name
	$a = $db->GetArray("SELECT * FROM ".$dbPrefix."users WHERE user_username = '".$_POST['username']."'");
	if (count($a) > 0) {
		smarty_error(lang('usernametaken'));
	}
	
	//Is e-mail validation turned on?
	if ($settings[0]['validateemail'] == 1) {
		//Generate a random validation key and md5 it. A random number between zero and a million?
		//There's not a chance that anyone's gonna guess that. So, they need to check their inbox
		//which will have the e-mail with this key in the URL. If they entered a bad e-mail? No
		//message in their inbox with the key and they're SOL.
		$validation = md5(rand(0,1000000)); 
		
		//The boring stuff. DB insert, send e-mail.
		$db->Execute("INSERT INTO ".$dbPrefix."users (user_username, user_password, user_email, user_status, user_emailvalidation) VALUES ('".xhtml_convert($_POST['username'])."', '".md5($_POST['password'])."', '".xhtml_convert($_POST['email'])."', 2, '".$validation."')");
		$newID = $db->Insert_Id();
		$emailmsg = str_replace('%DBNAME%', $settings[0]['dbname'], lang('validation_email'));
		$emailmsg .= "\n\n";
		$emailmsg .= $settings[0]['dburl'].'/index.php?act=register&validate&userid='.$newID.'&validation='.$validation;
		pafiledb_mail($settings[0]['dbname'], $settings[0]['fromemail'], array(array('name' => $_POST['username'], 'address' => $_POST['email'])), str_replace('%DBNAME%', $settings[0]['dbname'], lang('validation_email_subject')), $emailmsg);
		$smarty->assign('act', 'regvalidate');
	} else {
		//Validation not turned on, so just register them with a status of 3 (registered user)
		$db->Execute("INSERT INTO ".$dbPrefix."users (user_username, user_password, user_email, user_status) VALUES ('".xhtml_convert($_POST['username'])."', '".md5($_POST['password'])."', '".xhtml_convert($_POST['email'])."', 3)");
		smarty_redirect(lang('register_thankyou'), 'index.php?act=login');
	}
} else if(isset($_GET['validate'])) {
	//The validation key in the query string needs to match what we put in the database before...
	$user = $db->GetArray("SELECT * FROM ".$dbPrefix."users WHERE user_userid = ".intval($_GET['userid']));
	if ($user[0]['user_emailvalidation'] == $_GET['validation']) {
		$db->Execute("UPDATE ".$dbPrefix."users SET user_status = 3, user_emailvalidation = NULL WHERE user_userid = ".intval($_GET['userid']));
		smarty_redirect(lang('validation_complete'), 'index.php?act=login');
	} else {
		smarty_error(lang('validation_error'));
	}
}
$smarty->assign('navbar', array(array('name' => $settings[0]['dbname'], 'url' => ''), array('name' => lang('register'), 'url' => '?act=register')));
$smarty->assign('title', $settings[0]['dbname'].' &raquo; '.lang('register'));

?>