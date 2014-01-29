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

checkaccess(6);

$smarty->assign('u', $_GET['u']);

if ($_GET['u'] == 'add') {
    if (isset($_GET['process'])) { //Add user to DB
    
        //Check input *yawn*
        if (!check_input($_POST, array('status'))) {
            smarty_error(lang('emptyfield'));
        }
        
        
        //Check e-mail address *yawn*
        if (!eregi('^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$', $_POST['email'])) {
            smarty_error(lang('emailinvalid'));
        }
        
        //Check username for invalid characters *yawn*
        if (!preg_match('/^([A-Za-z0-9 ]{1,})$/', $_POST['uname'])) {
            smarty_error(lang('invalidchars'));
        }
        
        //Make sure username doesn't exist *yawn*
        $a = $db->GetArray("SELECT * FROM ".$dbPrefix."users WHERE user_username = '".$_POST['uname']."'");
        if (count($a) > 0) {
            smarty_error(lang('usernametaken'));
        }
        
        //Insert to DB *yawn*
        $db->Execute("INSERT INTO ".$dbPrefix."users (user_username, user_email, user_password, user_status) VALUES ('".$_POST['uname']."', '".$_POST['email']."', '".md5($_POST['password'])."', ".$_POST['status'].")");
        smarty_redirect(lang('acp_add_u_redir'), 'admin.php?act=users&u');
        
        
    } else {
        $stat_id = array(1,3,4,5,6);
        $stat_name = array(lang('banned'), lang('regular_user'), lang('moderator'), lang('administrator'), lang('super_administrator'));
        $smarty->assign('stat_id', $stat_id);
        $smarty->assign('stat_name', $stat_name);
    }
} elseif ($_GET['u'] == 'edit') { 
    //To prevent issues, admins cant edit themselves via ACP, gotta use my options
    if ($userinfo[0]['user_userid'] == $_GET['id']) { smarty_error(lang('edit_self')); }
    if (isset($_GET['process'])) {
    
        //Not going to bother commenting next few lines
        if (!check_input($_POST, array('password', 'status'))) {
            smarty_error(lang('emptyfield'));
        }
        if (!eregi('^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$', $_POST['email'])) {
            smarty_error(lang('emailinvalid'));
        }
        if (!preg_match('/^([A-Za-z0-9 ]{1,})$/', $_POST['uname'])) {
            smarty_error(lang('invalidchars'));
        }
        if ($_POST['oldname'] != $_POST['uname']) {
            $a = $db->GetArray("SELECT * FROM ".$dbPrefix."users WHERE user_username = '".$_POST['uname']."'");
            if (count($a) > 0) {
                smarty_error(lang('usernametaken'));
            }
        }
        
        $pass = trim($_POST['password']);
        
        if (!empty($pass)) { 
        	$passUpdate = ", user_password = '".md5($pass)."'";
        } else {
        	$passUpdate = "";
        }
        
        $db->Execute("UPDATE ".$dbPrefix."users SET user_username = '".$_POST['uname']."', user_email = '".$_POST['email']."', user_status = ".$_POST['status'].$passUpdate." WHERE user_userid = ".intval($_GET['id']));
        smarty_redirect(lang('acp_edit_u_redir'), 'admin.php?act=users&u');
    } else {
        $stat_id = array(1,3,4,5,6);
        $stat_name = array(lang('banned'), lang('regular_user'), lang('moderator'), lang('administrator'), lang('super_administrator'));
        $smarty->assign('stat_id', $stat_id);
        $smarty->assign('stat_name', $stat_name);
        $u = $db->GetArray("SELECT * FROM ".$dbPrefix."users WHERE user_userid = ".intval($_GET['id']));
        $smarty->assign('target', $u[0]);
    }
} elseif ($_GET['u'] == 'delete') {
    //Can't delete yourself. 
    if ($userinfo[0]['user_userid'] == $_GET['id']) { smarty_error(lang('delete_self')); }
    
    //Delete from DB
    $db->Execute("DELETE FROM ".$dbPrefix."users WHERE user_userid = ".intval($_GET['id']));
    $db->Execute("UPDATE ".$dbPrefix."comments SET comment_userid = 0 WHERE comment_userid = ".intval($_GET['id']));
    smarty_redirect(lang('acp_del_u_redir'), 'admin.php?act=users&u');
} else {
    $users = $db->GetArray("SELECT * FROM ".$dbPrefix."users");
    $smarty->assign('users', $users);
}

?>