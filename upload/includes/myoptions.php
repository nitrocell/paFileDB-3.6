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

if ($userinfo[0]['user_status'] < 3) {
	smarty_error(lang('perm_denied'));
}

if (isset($_GET['process'])) {

    //Check input *yawn*
    if (!check_input($_POST, array('new_password', 'new_confirm', 'current_password'))) {
        smarty_error(lang('emptyfield'));
    }
    
    
    //Check e-mail address *yawn*
    if (!eregi('^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$', $_POST['email'])) {
        smarty_error(lang('emailinvalid'));
    }
    
    if(md5($_POST['current_password']) != $userinfo[0]['user_password']) {
        smarty_error(lang('wrongpass'));
    }
    
    if ($_POST['new_password'] != $_POST['new_confirm']) {
        smarty_error(lang('nomatch'));
    }
    
    if (!empty($_POST['new_password'])) {
        $passUpdate = ", user_password = '".md5($_POST['new_password'])."'";
        setcookie('pafiledb_pass', md5($_POST['new_password']), time()+31536000);
    } else {
    	$passUpdate = "";
    }
    
    //Update DB *yawn*
    $db->Execute("UPDATE ".$dbPrefix."users SET user_email = '".$_POST['email']."'".$passUpdate." WHERE user_userid = ".$userinfo[0]['user_userid']);
    smarty_redirect(lang('myoptions_redir'), 'index.php');
    
} else {
    $me = $db->GetArray("SELECT * FROM ".$dbPrefix."users WHERE user_userid = ".$userinfo[0]['user_userid']);
    $smarty->assign('me', $me[0]);
}
$smarty->assign('navbar', array(array('name' => $settings[0]['dbname'], 'url' => ''), array('name' => lang('myoptions'), 'url' => '?act=myoptions')));
$smarty->assign('title', $settings[0]['dbname'].' &raquo; '.lang('myoptions'));

?>