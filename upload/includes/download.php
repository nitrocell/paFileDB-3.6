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

 
if ($settings[0]['require_registration'] == 2 && $userinfo[0]['user_userid'] == 0) {
	$logreg = '<br /><br /><a href="'.$settings[0]['dburl'].'/index.php?act=login&qs='.urlencode($_SERVER['QUERY_STRING']).'">'.lang('login').'</a> - <a href="'.$settings[0]['dburl'].'/index.php?act=register">'.lang('register').'</a>';
	smarty_error(lang('login_download').$logreg);
} 

//Fetch the file info from the database
$file = $db->GetArray("SELECT * FROM ".$dbPrefix."files WHERE file_id = ".intval($_GET['id']));
if (count($file) == 0) {

    smarty_error(lang('file_exist'));
}
$file = $file[0];

//Update stuff
$db->Execute("UPDATE ".$dbPrefix."files SET file_dls = file_dls + 1, file_last = ".time()." WHERE file_id = ".intval($_GET['id']));

if (isset($_GET['mirror'])) {
    $mirrors = unserialize($file['file_mirrors']);
    smarty_redirect(str_replace('{fileurl}',$file['file_dlurl'], lang('download_message')), $mirrors[$_GET['mirror']]['url'], true);
} else {
    smarty_redirect(str_replace('{fileurl}',$file['file_dlurl'], lang('download_message')), $file['file_dlurl'], true);
}
?>