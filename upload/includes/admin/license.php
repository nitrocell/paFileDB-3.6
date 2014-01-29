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

checkaccess(5);

$smarty->assign('l', $_GET['l']);
if ($_GET['l'] == 'add'){
    if (isset($_GET['process'])) {
        
        //Check...........
        if (!check_input($_POST)) {
            smarty_error(lang('emptyfield'));
        }
        $db->Execute("INSERT INTO ".$dbPrefix."license (license_name, license_text) VALUES ('".xhtml_convert($_POST['name'])."', '".smart_slashes(str_replace("\n", "<br />", $_POST['text']))."')");                           
        smarty_redirect(lang('acp_add_l_redir'), 'admin.php?act=license&l');
    }
} elseif ($_GET['l'] == 'edit') {
    if (isset($_GET['process'])) {
        
        //Check again...........
        if (!check_input($_POST)) {
            smarty_error(lang('emptyfield'));
        }
        
        $db->Execute("UPDATE ".$dbPrefix."license SET license_name = '".xhtml_convert($_POST['name'])."', license_text = '".smart_slashes(str_replace("\n", "<br />", $_POST['text']))."' WHERE license_id = ".intval($_GET['id']));
        smarty_redirect(lang('acp_edit_l_redir'), 'admin.php?act=license&l');
    } else {
        $license = $db->GetArray("SELECT * FROM ".$dbPrefix."license WHERE license_id = ".intval($_GET['id']));
        $license[0]['license_text'] = str_replace("<br />", "\n", $license[0]['license_text']);
        $smarty->assign('target', $license[0]);
    }
} elseif ($_GET['l'] == 'delete') {

    $db->Execute("UPDATE ".$dbPrefix."files SET file_license = 0 WHERE file_license = ".intval($_GET['id']));
    $db->Execute("DELETE FROM ".$dbPrefix."license WHERE license_id = ".intval($_GET['id']));
    
    smarty_redirect(lang('acp_del_l_redir'), 'admin.php?act=license&l');
} else {
    
    $licenses = $db->GetArray("SELECT * FROM ".$dbPrefix."license");
    $smarty->assign('licenses', $licenses);
}
if(eregi("safari", $_SERVER['HTTP_USER_AGENT'])){
	$isSafari = true;
} else {
	$isSafari = false;
}
$smarty->assign('isSafari', $isSafari);
?>